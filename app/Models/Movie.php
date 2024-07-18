<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $table = 'movies';

    protected $primaryKey = 'movie_id';

    public $timestamps = false;

    protected $fillable = [
        'title',
        'release_year',
        'genre',
        'director',
        'rating',
        'description',
    ];

    protected $casts = [
        'rating' => 'float',
        'release_year' => 'integer',
    ];
    
    public function actors()
    {
        return $this->belongsToMany(Actor::class, 'movie_actors', 'movie_id', 'actor_id');
    }
}
