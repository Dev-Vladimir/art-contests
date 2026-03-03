<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Models\Form;
// use Illuminate\Container\Attributes\Auth;
use Illuminate\Support\Facades\Auth;

class FormsController extends Controller
{

    use AuthorizesRequests, ValidatesRequests;

    private function getUser(){
        return Auth::user();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = $this->getUser();
        $forms= Form::where('user_id', $user->id)->get();
        // dd($forms->toArray());
        if(!empty($forms)) $forms = $forms->toArray();
        return view('user.forms-index', ['user' => $user, 'forms' => $forms]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = $this->getUser();
        return view('user.form-create', ['route' => route('user.forms.store'), 'user' => $this->getUser()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->toArray());
        $user = $this->getUser();
        $form_settings = json_decode($request->form_builder_data);
        // dd($form_settings);
        $title = $form_settings->formName;

        Form::create([
            'title' => $title,
            'form_settings' => $request->form_builder_data,
            'user_id' => $user->id
        ]);
        return redirect(route('user.forms.index'))->with('message', 'Форма успешно добавлена!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // dd(Form::find($id));
        $form = Form::find($id);
        if (!$form) return abort(404);
        $this->authorize('edit-form', $form);
        return view('user.form-create', ['route' => route('user.forms.update', ['id' => $id]), 'user' => $this->getUser(), 'form_data' => $form->form_settings]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $form = Form::find($id);
        $user = $this->getUser();
        $form_settings = json_decode($request->form_builder_data);
        // dd($form_settings);
        $title = $form_settings->formName;
        $form->update([
            'title' => $title,
            'form_settings' => $request->form_builder_data,
            'user_id' => $user->id
        ]);
        $form->save;
        return redirect(route('user.forms.index'))->with('message', 'Форма успешко добавлена!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $form = Form::findOrFail($id);
            
            $this->authorize('delete-form', $form);
            // dd($form);
            $form->delete();
            
            return redirect()->route('user.forms.index')
                ->with('success', 'Форма успешно удалена');
                
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('user.forms.index')
                ->with('error', 'Форма не найдена');
                
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            return redirect()->route('user.forms.index')
                ->with('error', 'У вас нет прав для удаления этой формы');
                
        } catch (\Exception $e) {
            return redirect()->route('user.forms.index')
                ->with('error', 'Ошибка при удалении: ' . $e->getMessage());
        }
    }
}