<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Actor extends Model
{
    use HasFactory;

    protected $table = 'actors';
    protected $primaryKey = 'actor_id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = false;
    protected $fillable = [
        'name',
        'birthdate',
        'nationality',
    ];

    public function movies()
    {
        return $this->belongsToMany(Movie::class, 'movie_actors', 'actor_id', 'movie_id');
    }
}
