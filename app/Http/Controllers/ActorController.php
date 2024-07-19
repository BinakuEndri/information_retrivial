<?php

namespace App\Http\Controllers;

use App\Models\Actor;
use Illuminate\Http\Request;

class ActorController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');

        $actors = Actor::when($query, function ($queryBuilder, $query) {
            return $queryBuilder->where('name', 'like', "%{$query}%")
                                ->orWhere('nationality', 'like', "%{$query}%");
        })->paginate(21);

        return view('actors', ['actors' => $actors]);
    }

    public function show($id)
    {
        $actor = Actor::find($id);

        if (!$actor) {
            return redirect()->route('actors.index')->with('error', 'Actor not found');
        }

        return view('actorDetails', ['actor' => $actor]);
    }
}
