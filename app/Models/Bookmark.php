<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Laravel\Scout\Searchable;

class Bookmark extends Model
{
    use HasFactory, Searchable;

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

    /**
     * Modify the query used to retrieve models when making all of the models searchable.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function makeAllSearchableUsing($query)
    {
        return $query->with('meta');
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        $array = $this->toArray();
        return ['title' => $array['title'], 'url' => $array['url']];
    }
}
