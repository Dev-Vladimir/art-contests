<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Contest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\Form;
use App\Models\GeneratedForm;
use Exception;
use App\Services\FormBuilderService;

class ContestsController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $contests = $user->contests->toArray();
        // dd($contests->toArray());
        return view('user.contests.index', compact('user', 'contests'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        // dd($user->forms->toArray());
        return view('user.contests.create', ['user' => $user, 'forms' => $user->forms->toArray()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->toArray());
        $user = Auth::user();

        $validated = $request->validate([
            'title' => 'required|max:12500',
            'form_id' => 'required|exists:forms,id', // проверяем что форма существует
            'groups' => 'nullable|array',
            'nominations' => 'nullable|array',
        ], [
            'title.required' => 'Название конкурса должно быть заполнено',
            'title.max' => 'Слишком длинное название',
            'form_id.required' => 'Вы не привязали форму к конкурсу',
        ]);

        $data = [
            'user_id' => $user->id,
            'title' => $request->title,
            'form_id' => $request->form_id,
            'is_active' => false,
        ];

        if ($request->has('groups') && is_array($request->groups)) {
            $data['groups'] = implode('|', $request->groups);
        }

        if ($request->has('nominations') && is_array($request->nominations)) {
            $data['nominations'] = implode('|', $request->nominations);
        }

        // Создаем конкурс - form_id сохраняется автоматически
        $contest = Contest::create($data);

        return redirect(route('user.contests.index'))
            ->with('success', 'Конкурс успешно создан');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = Auth::user();
        $contest = Contest::with('form:id,title')->findOrFail($id);
        $form = $contest->form;
        // dd($contest->toArray());
        return view('user.contests.view', compact('user', 'contest', 'form'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = Auth::user();
        $contest = Contest::with('form')->findOrFail($id);
        // dd($contest->toArray());
        $forms = $user->forms->toArray();
        $this->authorize('edit-contest', $contest);
        return view('user.contests.edit', compact('user', 'contest', 'forms'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $contest = Contest::findOrFail($id);
        $user = Auth::user();
        $this->authorize('edit-contest', $contest);
        $validated = $request->validate([
            'title' => 'required|max:12500',
            'form_id' => 'required|exists:forms,id', // проверяем что форма существует
            'groups' => 'nullable|array',
            'nominations' => 'nullable|array',
        ], [
            'title.required' => 'Название конкурса должно быть заполнено',
            'title.max' => 'Слишком длинное название',
            'form_id.required' => 'Вы не привязали форму к конкурсу',
        ]);
        $data = [
            'title' => $request->title,
            'form_id' => $request->form_id,
        ];
        if ($request->has('groups') && is_array($request->groups)) {
            $data['groups'] = implode('|', $request->groups);
        }

        if ($request->has('nominations') && is_array($request->nominations)) {
            $data['nominations'] = implode('|', $request->nominations);
        }
        $contest->update($data);
        return redirect(route('users.contests.index'))->with('success', 'Конкурс успешно обновлен');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $contest = Contest::findOrFail($id);
            
            // Проверка прав (если используете Gates)
            $this->authorize('delete-contest', $contest);
            
            $contest->delete();
            
            return redirect()->route('user.contests.index')
                ->with('success', 'Конкурс успешно удалён');
                
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('user.contests.index')
                ->with('error', 'Конкурс не найден');
                
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            return redirect()->route('user.contests.index')
                ->with('error', 'У вас нет прав для удаления этого конкурса');
                
        } catch (\Exception $e) {
            return redirect()->route('user.contests.index')
                ->with('error', 'Ошибка при удалении: ' . $e->getMessage());
        }
    }

    public function makeActive($id){
        try{
            $contest = Contest::findOrFail($id);
            $this->authorize('activate-contest', $contest);
            // dd($contest->form->toArray());
            if ($contest->is_active) return redirect()->back->with('error', 'Конкурс уже активен');
            $contest->is_active = true;
            $save = $contest->save();
            if (!$save) return redirect(route('user.contests.list'))->with('error', 'Не удалось активировать конкурс');
            return redirect()->back()->with('success', 'Конкурс успешно назначен активным');
        }catch (\Illuminate\Auth\Access\AuthorizationException $e) {
        // Ошибка прав доступа
            return redirect()->back()->with('error', 'У вас нет прав для активации этого конкурса');
                
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Конкурс не найден
            return redirect()->route('user.contests.index')->with('error', 'Конкурс не найден');
                
        } catch (\Exception $e) {
            // Любая другая ошибка
            \Log::error('Неизвестная ошибка при активации конкурса', [
                'contest_id' => $id,
                'user_id' => Auth::id(),
                'error' => $e->getMessage()
            ]);
            
            return redirect()->route('user.contests.index')->with('error', 'Произошла ошибка при активации конкурса');
        }
    }

    public function makeInactive($id){
        try{
            $contest = Contest::findOrFail($id);
            $this->authorize('activate-contest', $contest);
            if (!$contest->is_active) return redirect()->back->with('error', 'Конкурс уже приостановлен');
            $contest->is_active = false;
            $save = $contest->save();
            if (!$save) return redirect(route('user.contests.index'))->with('error', 'Не удалось приостановить конкурс');
            return redirect()->back()->with('success', 'Конкурс успешно приостановлен');
        }catch (\Illuminate\Auth\Access\AuthorizationException $e) {
        // Ошибка прав доступа
            return redirect()->back()->with('error', 'У вас нет прав для приостановки этого конкурса');
                
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Конкурс не найден
            return redirect()->route('user.contests.index')->with('error', 'Конкурс не найден');
                
        } catch (\Exception $e) {
            // Любая другая ошибка
            \Log::error('Неизвестная ошибка при деактивации конкурса', [
                'contest_id' => $id,
                'user_id' => Auth::id(),
                'error' => $e->getMessage()
            ]);
            
            return redirect()->route('user.contests.index')->with('error', 'Произошла ошибка при деактивации конкурса');
        }
    }

    public function open($id){
        try{
            $contest = Contest::findOrFail($id);
            $this->authorize('activate-contest', $contest);
            if ($contest->open) return redirect()->back->with('error', 'Заявки на конкурс уже принимаются');
            $contest->open = true;
            $save = $contest->save();
            if (!$save) return redirect(route('user.contests.index'))->with('error', 'Не удалось открыть подачу заявок');
            return redirect()->back()->with('success', 'Подача заявок успешно открыта!');
        }catch (\Illuminate\Auth\Access\AuthorizationException $e) {
        // Ошибка прав доступа
            return redirect()->back()->with('error', 'У вас нет прав для открытия подачи заявок на этот конкурс');
                
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Конкурс не найден
            return redirect()->route('user.contests.index')->with('error', 'Конкурс не найден');
                
        } catch (\Exception $e) {
            // Любая другая ошибка
            \Log::error('Неизвестная ошибка при открытии подачи заявок', [
                'contest_id' => $id,
                'user_id' => Auth::id(),
                'error' => $e->getMessage()
            ]);
            
            return redirect()->route('user.contests.index')->with('error', 'Произошла ошибка открытии подачи заявок на конкурс');
        }
    }

    public function close($id){
        try{
            $contest = Contest::findOrFail($id);
            $this->authorize('activate-contest', $contest);
            if (!$contest->open) return redirect()->back->with('error', 'Подача заявок уже приостановлена');
            $contest->open = false;
            $save = $contest->save();
            if (!$save) return redirect(route('user.contests.index'))->with('error', 'Не удалось приостановить подачу заявок конкурс');
            return redirect()->back()->with('success', 'Подача заявок на конкурс закрыта');
        }catch (\Illuminate\Auth\Access\AuthorizationException $e) {
        // Ошибка прав доступа
            return redirect()->back()->with('error', 'У вас нет прав для приостановки подачи заявок на конкурс');
                
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Конкурс не найден
            return redirect()->route('user.contests.index')->with('error', 'Конкурс не найден');
                
        } catch (\Exception $e) {
            // Любая другая ошибка
            \Log::error('Неизвестная ошибка при завершении подачи заявок на конкурс', [
                'contest_id' => $id,
                'user_id' => Auth::id(),
                'error' => $e->getMessage()
            ]);
            
            return redirect()->route('user.contests.index')->with('error', 'Произошла ошибка при завершении подачи заявок на конкурс');
        }
    }
}
