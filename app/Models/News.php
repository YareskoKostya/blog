<?php

namespace App\Models;

use App\Traits\Commentable;
use App\Traits\Mediable;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use Commentable;
    use Mediable;

    protected $fillable = [
        'title',
        'description',
        'body',
        'user_id',
        'category_id',
    ];

    protected $appends = [
        'comments_count'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public static function boot()
    {
        parent::boot();

        self::saving(function ($model) {
            $model->user_id = auth()->user()->getKey();
        });

        self::addGlobalScope('ordered', function ($builder) {
            $builder->latest('updated_at');
        });
    }
}
