<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    const DRAFT = 0;
    const PUBLISHED = 1;
    const UNPUBLISHED = 2;

    const STATUSES = [self::DRAFT, self::PUBLISHED, self::UNPUBLISHED];

    const DEFAULT_STATUS = self::DRAFT;

    protected $table = "articles";

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
