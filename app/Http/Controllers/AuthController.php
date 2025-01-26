<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\ResetPasswordMail;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    /**
     * Проверка существования пользователя по E-mail
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function checkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->first();

        return response()->json(['exists' => !!$user]);
    }

    /**
     * Отправка ссылки для восстановления пароля
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user) {
            // Имитация отправки письма
            return response()->json(['message' => 'Письмо восстановления отправлено на указанный E-mail адрес']);
        }

        return response()->json(['message' => 'Пользователь с таким E-mail не найден'], 404);
    }
}
