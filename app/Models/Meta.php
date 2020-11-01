<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meta extends Model
{
    use HasFactory;

    protected $table = 'meta';
    protected $fillable = ['title', 'description', 'keywords'];

    public function bookmark()
    {
        return $this->belongsTo(Bookmark::class);
    }
}
