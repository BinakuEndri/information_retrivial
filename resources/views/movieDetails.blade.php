<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Details</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #1c1c1c;
            font-family: 'Roboto', sans-serif;
            margin: 0;
            color: #f5f5f5;
            text-align: center;
            overflow-x: hidden;
        }
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #121212;
            padding: 10px 20px;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
            border-bottom: 2px solid #ff5722;
        }
        .navbar a {
            color: #e0e0e0;
            text-decoration: none;
            margin-left: 20px;
            font-size: 16px;
            transition: color 0.3s, border-bottom 0.3s;
            padding-bottom: 5px;
            border-bottom: 2px solid transparent;
        }
        .navbar a:hover, .navbar a.active {
            color: #ff5722;
            border-bottom: 2px solid #ff5722;
        }
        .movie-details {
            max-width: 800px;
            margin: 40px auto;
            background-color: #212121;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            text-align: left;
        }
        .movie-details img {
            width: 100%;
            height: 300px;
            object-fit: cover;
            border-bottom: 1px solid #333;
        }
        .movie-details h2 {
            font-size: 28px;
            margin-bottom: 15px;
        }
        .movie-details p {
            font-size: 18px;
            margin-bottom: 10px;
        }
        .movie-details .description {
            margin-top: 20px;
            font-size: 16px;
            color: #b0b0b0;
        }
        .actor-list {
            margin-top: 20px;
            display: flex;
            overflow-x: auto;
            padding: 10px 0;
            gap: 20px;
            scrollbar-width: thin;
            scrollbar-color: #ff5722 #121212;
        }
        .actor-box {
            background-color: #2c2c2c;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            flex: 0 0 auto;
            cursor: pointer;
            display: flex;
            flex-direction: column;
            width: 220px;
        }
        .actor-box img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-bottom: 1px solid #333;
        }
        .actor-box .actor-details {
            padding: 15px;
        }
        .actor-box .actor-details h2 {
            font-size: 20px;
            margin: 0 0 10px;
        }
        .actor-box .actor-details p {
            margin: 0;
            font-size: 14px;
            color: #b0b0b0;
        }
        .actor-list::-webkit-scrollbar {
            height: 4px;
        }
        .actor-list::-webkit-scrollbar-thumb {
            background-color: #ff5722;
            border-radius: 8px;
        }
        .actor-list::-webkit-scrollbar-track {
            background-color: #121212;
            border-radius: 8px;
        }
        ::-webkit-scrollbar {
            width: 4px;
        }
        ::-webkit-scrollbar-thumb {
            background-color: #ff5722;
            border-radius: 8px;
        }
        ::-webkit-scrollbar-track {
            background-color: #121212;
            border-radius: 8px;
        }
    </style>
</head>
<body>
<div class="navbar">
    <a href="{{ url('/movie') }}">Movies</a>
    <a href="{{ url('/actor') }}">Actors</a>
    <a href="{{ url('/review') }}">Reviews</a>
</div>

<div class="movie-details">
    @php
    $randomNumber = rand(1, 1000);
    $imageUrl = "https://picsum.photos/400/500?random={$movie->movie_id}_{$randomNumber}";
    @endphp
    <img src="{{ $imageUrl }}" alt="{{ $movie->title }} Poster">
    <h2>{{ $movie->title }}</h2>
    <p>Release Year: {{ $movie->release_year }}</p>
    <p>Genres: {{ $movie->genre }}</p>
    <p>Director: {{ $movie->director }}</p>
    <p>Rating: {{ $movie->rating }}</p>
    <p class="description">Description: {{ $movie->description }}</p>
</div>

<div class="movie-details">
    <div class="actor-list">
        @foreach($movie->actors as $actor)
        <div class="actor-box" onclick="goToActorDetails('{{ $actor->actor_id }}')">
            @php
                $randomNumber = rand(1, 1000);
                $imageUrl = "https://picsum.photos/200/300?random={$actor->actor_id}_{$randomNumber}";
            @endphp
            <img src="{{ $imageUrl }}" alt="{{ $actor->name }} Portrait">
            <div class="actor-details">
                <h2>{{ $actor->name }}</h2>
                <p>Birthdate: {{ $actor->birthdate }}</p>
                <p>Nationality: {{ $actor->nationality }}</p>
            </div>
        </div>
        @endforeach
    </div>
</div>

<script>
    const actorDetailsUrl = @json(url('actor'));
    function goToActorDetails(actorId) {
        window.location.href = `${actorDetailsUrl}/${actorId}`;
    }
</script>

</body>
</html>
