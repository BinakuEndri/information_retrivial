<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MovieActor extends Model
{
    protected $table = 'movie_actors';

    protected $primaryKey = ['movie_id', 'actor_id'];
    
    public $timestamps = false;
    
    public function movie()
    {
        return $this->belongsTo(Movie::class, 'movie_id');
    }

    public function actor()
    {
        return $this->belongsTo(Actor::class, 'actor_id');
    }
}
