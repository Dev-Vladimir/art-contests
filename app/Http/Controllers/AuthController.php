<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\URL;

use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;




class AuthController extends Controller
{
    // Регистрация
    public function register()
    {
        return view('auth.register');
    }

    public function storeRegister(Request $request)
    {
        // dd($request->toArray());
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed',
            'full_name' => 'required|string|max:16255',
            'address' => 'required|string|max:16255',
            'phone' => 'required|string|max:255',
            'website' => 'required|string|max:255',
            'agreement' => 'required|accepted'
        ],[
            'name.required' => 'Имя обязательно для заполнения',
            'name.max' => 'Слишком длинное имя',
            'email.required' => 'Email обязателен для заполнения',
            'aggreement.required' => 'необходимо согласиться с политикой обработки данных',
            'aggreement.accepted' => 'необходимо согласиться с политикой обработки данных'
        ]);

        $user = User::create($validated);

        // Отправляем письмо для подтверждения email
        $user->sendEmailVerificationNotification();

        // Можно также залогинить пользователя, но часто просят подтвердить email сначала
        // Auth::login($user);

        return redirect()->route('verification.notice')
            ->with('success', 'Регистрация прошла успешно! Подтвердите ваш email.');
    }

    // Вход
    public function login()
    {
        return view('auth.login');
    }

    public function storeLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ],[
            '*' => 'Все поля обязательны для заполнения'
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            // Проверяем, подтверждён ли email (если нет, можно разлогинить или перенаправить на страницу верификации)
            if (is_null(Auth::user()->email_verified_at)) {
                Auth::logout();
                return redirect()->route('verification.notice')
                    ->withErrors(['email' => 'Необходимо подтвердить email.']);
            }

            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => 'Неверный email или пароль',
        ]);
    }

    // Выход
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    // *** МЕТОДЫ ВЕРИФИКАЦИИ ***

    // Страница с уведомлением о необходимости подтверждения email
    public function verifyNotice()
    {
        return view('auth.verify-notice');
    }

    // Обработка ссылки подтверждения из письма
    public function verify(Request $request, $id, $hash)
    {
        $user = User::findOrFail($id);

        // Проверяем хеш (должен совпадать с хешем email пользователя)
        if (! hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
            abort(403);
        }

        // Если email уже подтверждён, просто редиректим
        if (! is_null($user->email_verified_at)) {
            return redirect()->route('dashboard');
        }

        // Помечаем как подтверждённый
        $user->markEmailAsVerified();

        // Логиним пользователя (по желанию)
        Auth::login($user);

        return redirect()->route('dashboard')->with('success', 'Email успешно подтверждён!');
    }

    // Повторная отправка письма подтверждения
    public function resend(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        $user = User::where('email', $request->email)->first();

        if (is_null($user)) {
            return back()->withErrors(['email' => 'Пользователь не найден.']);
        }

        if (! is_null($user->email_verified_at)) {
            return redirect()->route('dashboard')->with('info', 'Email уже подтверждён.');
        }

        $user->sendEmailVerificationNotification();

        return back()->with('success', 'Письмо для подтверждения отправлено повторно.');
    }


    // ... остальные методы

    /**
     * Показать форму запроса ссылки на сброс пароля
     */
    public function forgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Отправить ссылку на сброс пароля
     */
    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['success' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    /**
     * Показать форму сброса пароля (с токеном)
     */
    public function resetPasswordForm(Request $request, $token)
    {
        // Передаём токен и email из запроса (email может быть в query или в сессии)
        // dd($request->query('email'));
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->email
        ]);
    }

    /**
     * Обработать сброс пароля
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => bcrypt($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('success', __($status))
            : back()->withErrors(['email' => [__($status)]]);
}
}