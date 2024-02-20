<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateArticle;
use App\Http\Requests\UpdateArticle;
use App\Models\Article;
use App\Models\User;
use App\Repositories\ArticleRepository;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $page = $request->input('p', 1);
        return response()->json(ArticleRepository::paginate(page: $page), 200);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(CreateArticle $request)
    {
        $validated = $request->validated();
        $user = User::query()->findOrFail($request->user_id);
        $article = ArticleRepository::create(
            $user,
            $validated["title"],
            $validated["description"],
        );

        return response()->json($article, 200);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateArticle $request, $article_id)
    {
        $validated = $request->validated();
        $article = Article::findOrFail($article_id);
        $articleRepository = new ArticleRepository($article);

        $articleRepository->update($validated);

        return response()->json($article, 200);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, $article_id)
    {
        $article = Article::findOrFail($article_id);
        ArticleRepository::delete($article);
        return response()->json();
    }
}
