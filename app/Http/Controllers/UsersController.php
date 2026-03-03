<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    public function dashboard(){
        //здесь надо будет получить залогиненного пользователя
        $user = Auth::user();
        // dd($user);
        return view('user.dashboard', ['user' => $user]);
    }

    public function edit(){
        return view('user.profile.edit-profile', ['user' => Auth::user()]);
    }

    public function updateProfile(Request $request){
        $user = Auth::user();
        if (!$user) abort(403);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'full_name' => 'required|string|max:16255',
            'address' => 'required|string|max:16255',
            'phone' => 'required|string|max:255',
            'website' => 'required|string|max:255',
        ],[
            'name.required' => 'Имя обязательно для заполнения',
            'name.max' => 'Слишком длинное имя',
            'email.required' => 'Email обязателен для заполнения',
        ]);
        $user->update($validated);

        return redirect(route('dashboard'))->with('success', 'Профиль обновлён.');
    }
}
