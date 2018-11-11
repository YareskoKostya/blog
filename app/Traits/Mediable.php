<?php
/**
 * Created by PhpStorm.
 * User: Kostya
 * Date: 11.11.2018
 * Time: 07:54
 */

namespace App\Traits;

use App\Models\Media;

trait Mediable
{
    public function media()
    {
        return $this->morphMany(Media::class, 'mediable');
    }
}