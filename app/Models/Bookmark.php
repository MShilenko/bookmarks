<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Bookmark extends Model
{
    use HasFactory;

    protected static function booted() 
    {
        static::updated(function($model) {
            Cache::tags(["bookmarks", "bookmark|{$model->id}"])->flush();
            flash('The bookmark was successfully updated!');
        });

        static::created(function($model) {
            Cache::tags(["bookmarks", "bookmark|{$model->id}"])->flush();
            flash('The bookmark was successfully created!');
        });

        static::deleted(function($model) {
            Cache::tags(["bookmarks", "bookmark|{$model->id}"])->flush();
            flash('Bookmark deleted!', 'warning');
        });
    }

    public function meta()
    {
        return $this->hasOne(Meta::class);
    }
}
