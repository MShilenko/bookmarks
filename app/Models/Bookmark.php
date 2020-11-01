<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Bookmark extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'url', 'favicon', 'password_to_delete'];

    protected static function booted() 
    {
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
