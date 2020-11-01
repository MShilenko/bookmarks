<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Meta extends Model
{
    use HasFactory, Searchable;

    protected $table = 'meta';
    protected $fillable = ['title', 'description', 'keywords'];

    public function bookmark()
    {
        return $this->belongsTo(Bookmark::class);
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        $array = $this->toArray();
        return ['title' => $array['title'], 'description' => $array['description']];
    }
}
