<?php

namespace App\Repositories;

use App\Models\Article;
use App\Models\Comment;

class CommentRepository
{
    /**
     * @var Comment
     */
    private $comment;

    /**
     * @param Comment $comment
     *
     * @return CommentRepository
     */
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    /**
     * @param Article $article
     * @param integer $prePage = 10
     * @param integer $page = 1
     */
    public static function paginate(Article $article, $prePage = 10, $page = 1)
    {
        return $article->comments()->paginate($prePage, ["*"], "p", $page);
    }

    /**
     * @param Article $article
     * @param string $username
     * @param string $description
     *
     * @return Comment
     */
    public static function create(Article $article, $username, $description)
    {
        $comment = new Comment();
        $comment->description = $description;
        $comment->username = $username;
        $comment->article_id = $article->id;

        $comment->save();

        return $comment;
    }

    /**
     * @return Comment
     */
    public function update($attributs = [])
    {
        if (isset($attributs['description'])) {
            $this->comment->description = $attributs['description'];
        }

        $this->comment->save();

        return $this->comment;
    }


    public function delete()
    {
        $this->comment->delete();
    }
}
