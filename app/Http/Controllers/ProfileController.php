<?php

namespace App\Http\Controllers;

use App\Review;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Метод для получения данных профиля текущего пользователя
     *
     * @return Application|Factory|View
     */
    public function getUserProfile()
    {
        $user = Auth::user(); // Получаем текущего пользователя
        $reviews = Review::where('user_id', Auth::id())->latest()->get();
        return view('user.profile', compact('reviews', 'user'));
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'login' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->update([
            'login' => $request->login,
            'email' => $request->email,
        ]);

        return redirect()->route('profile')->with('success', 'Данные успешно обновлены!');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function changePassword(Request $request)
    {
        $request->validate([
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return redirect()->route('profile')->with('success', 'Пароль успешно изменен!');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function uploadPhoto(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();

        if ($request->hasFile('photo')) {

            if ($user->image) {
                Storage::disk('public')->delete($user->image);
            }

            $path = $request->file('photo')->store('profile-photos', 'public');
            $user->image = $path;
            $user->save();
        }

        return redirect()->route('profile')->with('success', 'Фото успешно обновлено!');
    }
}
