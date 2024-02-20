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

    /**
     * @param User $title
     * @param string $title
     * @param string $description
     *
     * @return Article
     */
    public static function create(User $author, $title, $description)
    {
        $article = new Article();
        $article->title = $title;
        $article->description = $description;

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

        return $this->article->save();
    }

    public static function delete(Article $article)
    {
        $article->delete();
    }
}
