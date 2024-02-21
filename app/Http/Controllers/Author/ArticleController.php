<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateArticle;
use App\Http\Requests\UpdateArticle;
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
        $user = auth()->user();
        $articles = ArticleRepository::paginateByAuthor($user, 10, $page);
        return response()->json($articles, 200);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(CreateArticle $request)
    {
        $validated = $request->validated();
        $article = ArticleRepository::create(
            auth()->user(),
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
        $user = auth()->user();

        $article = $user->articles()->findOrFail($article_id);

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
        $user = auth()->user();
        $article = $user->articles()->findOrFail($article_id);
        ArticleRepository::delete($article);
        return response()->json();
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function publish(Request $request, $article_id)
    {
        $user = auth()->user();
        $article = $user->articles()->findOrFail($article_id);
        $articleRepository = new ArticleRepository($article);
        $articleRepository->publish();
        return response()->json($article, 200);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function unpublish(Request $request, $article_id)
    {
        $user = auth()->user();
        $article = $user->articles()->findOrFail($article_id);
        $articleRepository = new ArticleRepository($article);
        $articleRepository->unpublish();
        return response()->json($article, 200);
    }
}
