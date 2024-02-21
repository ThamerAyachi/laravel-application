<?php

namespace App\Repositories;

use App\Models\Article;
use App\Models\User;

class ArticleRepository
{
    /**
     * @var Article
     */
    private $article;

    public function __construct(Article $article)
    {
        $this->article = $article;
    }

    public static function paginate($prePage = 10, $page = 1)
    {
        return Article::query()->with('comments')->paginate($prePage, ["*"], "p", $page);
    }

    public static function paginatePublished($prePage = 10, $page = 1)
    {
        return Article::query()
            ->where('status', Article::PUBLISHED)
            ->with('comments')
            ->paginate($prePage, ["*"], "p", $page);
    }

    public static function paginateByAuthor(User $user, $prePage = 10, $page = 1)
    {
        return $user
            ->articles()
            ->with('comments')
            ->paginate($prePage, ["*"], "p", $page);
    }

    /**
     * @param User $title
     * @param string $title
     * @param string $description
     *
     * @return Article
     */
    public static function create(User $author, $title, $description, $status = Article::DEFAULT_STATUS)
    {
        $article = new Article();
        $article->title = $title;
        $article->description = $description;
        $article->status = $status;

        $article->user_id = $author->id;

        $article->save();

        return $article;
    }

    /**
     * @return bool
     */
    public function update($attributs = [])
    {
        if (isset($attributs['title'])) {
            $this->article->title = $attributs['title'];
        }

        if (isset($attributs['description'])) {
            $this->article->description = $attributs['description'];
        }

        if (isset($attributs['status'])) {
            $this->article->status = $attributs['status'];
        }

        return $this->article->save();
    }


    public static function delete(Article $article)
    {
        $article->delete();
    }

    /**
     * @return bool
     */
    public function publish()
    {
        $this->article->status = Article::PUBLISHED;

        return $this->article->save();
    }

    /**
     * @return bool
     */
    public function unpublish()
    {
        $this->article->status = Article::UNPUBLISHED;

        return $this->article->save();
    }
}
