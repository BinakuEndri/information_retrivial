<?php
namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function index()
{
    // Replace 'yourkey' with your actual API key
$apiKey = 'ba9fc822';
$baseUrl = 'http://www.omdbapi.com/';

// Build the URL with the API key and query
$url = $baseUrl . '?apikey=' . $apiKey;

// Initialize a cURL session
$ch = curl_init();

// Set the URL
curl_setopt($ch, CURLOPT_URL, $url);
// Return the response instead of outputting it
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

// Execute the cURL request
$response = curl_exec($ch);

// Check for errors
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
} else {
    // Decode the JSON response
    $data = json_decode($response, true);

    // Display the data
    if (isset($data['Error'])) {
        echo 'Error: ' . $data['Error'];
    } else {
        echo 'Title: ' . $data['Title'] . '<br>';
        echo 'Year: ' . $data['Year'] . '<br>';
        echo 'Director: ' . $data['Director'] . '<br>';
        echo 'Plot: ' . $data['Plot'] . '<br>';
    }
}

// Close the cURL session
curl_close($ch);

    // Fetch all movies from the database
    $movies = Movie::paginate(21);


    // Pass both variables to the view
    return view('movies', ['movies' => $movies, 'moviesSoon' => $data]);
}
    public function show($id)
    {
        $movie = Movie::with('actors')->find($id);

        if (!$movie) {
            return redirect()->route('movies')->with('error', 'Movie not found');
        }

        return view('movieDetails', ['movie' => $movie]);
    }
}
