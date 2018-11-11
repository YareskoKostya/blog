<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $fillable = [
        'mediable_type',
        'mediable_id',
        'path',
        'collection',
        'size',
        'extension',
    ];

    public function mediable()
    {
        return $this->morphTo();
    }
}
