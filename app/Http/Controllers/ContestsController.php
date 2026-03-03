<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Contest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Models\User;
use App\Models\Form;


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
        $valiated = $request->validate([
            'title' => 'required|max:12500',
            'form_id' => 'required',
        ],[
            'title.required' => 'Название конкурса должно быть заполнено',
            'title.max' => 'Слишком длинное название. Попробуйте придумать покороче',
            'form_id.required' => 'Вы не привязали форму к конкурсу'
        ]);
        $data = [
            'user_id' => $user->id,
            'title' => $request->title,
            'form_id' => $request->form_id,
            'is_active' => false,
        ];
        if (isset($request->groups)) $data['groups'] = implode('|', $request->groups);
        if (isset($request->nominations)) $data['groups'] = implode('|', $request->nominations);
        Contest::create($data);
        return redirect(route('user.contests.index'))->with('success', 'Конкурс успешно создан');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $contest = Contest::with('form')->findOrFail($id);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
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
}
