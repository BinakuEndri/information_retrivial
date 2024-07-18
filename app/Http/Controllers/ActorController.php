<?php

namespace App\Http\Controllers;

use App\Models\Actor;
use Illuminate\Http\Request;

class ActorController extends Controller
{
    public function index()
    {
        $actors = Actor::paginate(21);
        return view('actors', ['actors' => $actors]);
    }
    public function show($id)
    {
        $actor = Actor::find($id);

        if (!$actor) {
            return redirect()->route('actors')->with('error', 'Actor not found');
        }

        return view('actorDetails', ['actor' => $actor]);
    }
}