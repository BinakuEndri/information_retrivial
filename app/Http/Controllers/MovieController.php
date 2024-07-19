<?php
namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');
        
        $movies = Movie::when($query, function ($queryBuilder, $query) {
            return $queryBuilder->where('title', 'like', "%$query%")
                                ->orWhere('genre', 'like', "%$query%")
                                ->orWhere('director', 'like', "%$query%")
                                ->orWhere('release_year', 'like', "%$query%");
        })->paginate(10);
    
        return view('movies', compact('movies'))->with('query', $query);
    }

    public function show($id)
    {
        $movie = Movie::with('actors')->find($id);

        if (!$movie) {
            return redirect()->route('movies')->with('error', 'Movie not found');
        }

        return view('movieDetails', ['movie' => $movie]);
    }
    
    public function search(Request $request)
    {
        $query = $request->input('query');
        
        // Filter results based on title, genre, director, or release year
        if ($query) {
            $movies = Movie::where('title', 'like', "%$query%")
                            ->orWhere('genre', 'like', "%$query%")
                            ->orWhere('director', 'like', "%$query%")
                            ->orWhere('release_year', 'like', "%$query%")
                            ->paginate(10);
        } else {
            $movies = Movie::paginate(10);
        }
    
        return view('movies', compact('movies'))->with('query', $query);
    }
}
