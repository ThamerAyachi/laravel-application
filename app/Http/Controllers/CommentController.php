<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateComment;
use App\Models\Article;
use App\Repositories\CommentRepository;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request, $article_id)
    {
        $article = Article::findOrFail($article_id);
        return response()->json(CommentRepository::paginate($article), 200);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(CreateComment $request, $article_id)
    {
        $validated = $request->validated();
        $article = Article::findOrFail($article_id);
        $comment = CommentRepository::create(
            $article,
            $validated['username'],
            $validated['description'],
        );

        return response()->json($comment, 200);
    }

}
