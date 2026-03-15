<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerifyEmailChange;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;
use App\Models\Plan;
use App\Models\Subscription;




class AuthController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;
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

    public function editEmail(Request $request){
        $validated = $request->validate([
            'email' => 'required|max:255|unique:users',
        ], [
            'email.required' => 'email не заполнен',
            'email.max' => 'слишком длинная почта',
            'email.unique' => 'пользователь с такой почтой уже существует!'
        ]);
        
        $user = Auth::user();
        
        // Сохраняем новый email во временное поле
        $user->pending_email = $request->email;
        $user->email_verification_token = Str::random(60);
        $user->save();
        
        // Отправляем письмо для подтверждения
        Mail::to($request->email)->send(new VerifyEmailChange($user));
        
        return redirect()->route('dashboard')->with('success', 'Письмо с подтверждением отправлено на новый email');
    }
    /**
     * Подтверждение смены email
     */
    public function verifyEmailChange($token)
    {
        // Ищем пользователя с таким токеном
        $user = User::where('email_verification_token', $token)->first();
        
        if (!$user) {
            return redirect()->route('dashboard')
                ->with('error', 'Недействительная или устаревшая ссылка подтверждения');
        }
        
        // Проверяем, не истек ли срок действия токена (например, 24 часа)
        if ($user->updated_at->diffInHours(now()) > 24) {
            return redirect()->route('dashboard')
                ->with('error', 'Срок действия ссылки истек. Запросите смену email повторно');
        }
        
        // Обновляем email
        $user->email = $user->pending_email;
        $user->pending_email = null;
        $user->email_verification_token = null;
        $user->email_verified_at = now(); // Сразу подтверждаем новый email
        $user->save();
        
        // Если пользователь был залогинен, обновляем сессию (опционально)
        if (Auth::check() && Auth::id() === $user->id) {
            // Можно ничего не делать, или перенаправить
        }
        
        return redirect()->route('dashboard')
            ->with('success', 'Email успешно изменен и подтвержден!');
    }
    /**
     * Повторная отправка письма для подтверждения смены email
     */
    public function resendEmailChange(Request $request)
    {
        $user = Auth::user();
        
        if (!$user->pending_email) {
            return redirect()->route('dashboard')
                ->with('error', 'Нет ожидающей смены email');
        }
        
        // Генерируем новый токен
        $user->email_verification_token = Str::random(60);
        $user->save();
        
        // Отправляем письмо повторно
        Mail::to($user->pending_email)->send(new VerifyEmailChange($user));
        
        return redirect()->route('dashboard')
            ->with('success', 'Письмо с подтверждением отправлено повторно');
    }
}