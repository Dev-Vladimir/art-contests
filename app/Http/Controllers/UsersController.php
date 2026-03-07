<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;

class UsersController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    public function dashboard($id = null){
        //здесь надо будет получить залогиненного пользователя
        $user = User::findOrFail($id ?? Auth::id());
        $this->authorize('view-user', $user);
        // dd($user->isAdmin());
        if ($user->isAdmin()){
            $users_list = User::where('role', '!=', 3)->get(['id', 'name']);
            // dd($users_list);
        }
        return $user->isAdmin() 
            ? view('admin.index', compact('user', 'users_list'))
            : view('user.dashboard', compact('user'));
    }

    public function edit($id = null){
        $user = User::findOrFail($id ?? Auth::id());
        $this->authorize('edit-user', $user);
        // dd($user);
        return view('user.profile.edit-profile', compact('user'));
    }

    public function updateProfile(Request $request, $id = null){
        $user = User::findOrFail($id ?? Auth::id());
        // dd($user->toArray());
        if (!$user) abort(403);
        $this->authorize('edit-user', $user);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'full_name' => 'required|string|max:16255',
            'address' => 'required|string|max:16255',
            'phone' => 'required|string|max:255',
            'website' => 'required|string|max:255',
        ],[
            'name.required' => 'Имя обязательно для заполнения',
            'name.max' => 'Слишком длинное имя',
        ]);
        $user->update($validated);

        return redirect(route('dashboard'))->with('success', 'Профиль обновлён.');
    }

    public function delete($id = null){
        $user = Auth::user();
        if ($user->isAdmin()){
            $user_delete = User::findOrFail($id);
            $this->authorize('delete-user', $user_delete);
            return view('admin.delete-account', compact('user_delete', 'user'));
        }else{
            $this->authorize('delete-user', $user);
            return view('user.delete-account', compact('user'));
        }
    }

    public function destroy($id = null){
        // Находим пользователя
        $user = User::findOrFail($id ?? Auth::id());
        
        // Проверяем права
        $this->authorize('delete-user', $user);
        
        $is_self_delete = ($user->id == Auth::id());
        $user_name = $user->name;
        
        DB::beginTransaction();
        
        try {
            // Получаем статистику
            $stats = [
                'forms' => $user->forms()->count(),
                'contests' => $user->contests()->count(),
            ];
            
            // Удаляем связанные данные и пользователя
            $user->forms()->delete();
            $user->contests()->delete();
            $user->delete();
            
            DB::commit();
            
            // Если удалил себя - разлогиниваем
            if ($is_self_delete) {
                Auth::logout();
                request()->session()->invalidate();
                request()->session()->regenerateToken();
                
                return redirect('/')->with('success', 
                    "Ваш аккаунт удален. Удалено форм: {$stats['forms']}, конкурсов: {$stats['contests']}");
            }
            
            // Если админ удалил другого
            return redirect()->route('dashboard')->with('success', 
                "Пользователь {$user_name} удален. Форм: {$stats['forms']}, конкурсов: {$stats['contests']}");
            
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Ошибка: ' . $e->getMessage());
        }
    }
}