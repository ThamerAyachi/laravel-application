<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property int $stock
 * @property int $size
 *
 * @property User $user
 */
class Product extends Model
{
    use HasFactory;

    const SIZE_SMALL = 0;
    const SIZE_MEDIUM = 1;
    const SIZE_BIG = 2;

    const SIZES = [self::SIZE_SMALL, self::SIZE_MEDIUM, self::SIZE_BIG];

    protected $table = 'product';

    protected $fillable = [];

    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => ucfirst($value),
            set: fn(string $value) => strtolower($value),
        );
    }

    public function scopeIsPublished(Builder $builder)
    {
        return $builder->where('status', 'published');
    }
}
