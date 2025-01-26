<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Review;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ReviewController extends Controller
{
    /**
     * Метод для записи отзыва в бд
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Для отправки отзыва необходимо авторизоваться.'], 401);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'recommend' => 'nullable|boolean',
        ]);

        Review::create([
            'user_id' => Auth::id(),
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'recommend' => $request->input('recommend'),
        ]);

        return response()->json(['message' => 'Отзыв успешно добавлен!']);
    }

    /**
     * Метод для получения всех отзывов
     *
     * @return Application|Factory|View
     */
    public function getReviews()
    {
        $reviews = Review::with('user')->latest()->get();
        $totalReviews = $reviews->count();
        return view('common.comments', compact('reviews', 'totalReviews'));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function search($search)
    {

        // Поиск отзывов по заголовку или содержанию
        $reviews = Review::with('user')
            ->where('title', 'like', "%{$search}%")
            ->orWhere('content', 'like', "%{$search}%")
            ->get();

        // Возвращаем JSON-ответ
        return response()->json($reviews);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function sort($sort)
    {

        $reviews = Review::with('user')
            ->orderBy('created_at', $sort)
            ->get();

        return response()->json($reviews);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function getReviewById($id)
    {
        $review = Review::with('user')->findOrFail($id);
        return response()->json($review);
    }

    /**
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Для обновления отзыва необходимо авторизоваться.'], 401);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'recommend' => 'nullable|boolean',
        ]);

        $review = Review::findOrFail($id);

        if ($review->user_id !== Auth::id()) {
            return response()->json(['message' => 'Вы не можете обновлять этот отзыв.'], 403);
        }

        $review->update([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'recommend' => $request->input('recommend'),
        ]);

        return response()->json(['message' => 'Отзыв успешно обновлен!']);
    }
}
