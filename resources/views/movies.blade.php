<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Web Application - Movies</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #1c1c1c;
            font-family: 'Roboto', sans-serif;
            margin: 0;
            color: #f5f5f5;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
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
        }
        .navbar a {
            color: #e0e0e0;
            text-decoration: none;
            font-size: 16px;
            margin-left: 20px;
            transition: color 0.3s;
        }
        .navbar a:hover {
            color: #ff5722;
        }
        .search-form {
            margin-bottom: 20px;
            display: flex;
            justify-content: center;
        }
        .search-form input {
            border: 1px solid #ff5722;
            border-radius: 4px 0 0 4px;
            padding: 10px;
            color: #fff;
            background-color: #333;
        }
        .search-form button {
            background-color: #ff5722;
            border: none;
            color: #fff;
            border-radius: 0 4px 4px 0;
            padding: 10px 20px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .search-form button:hover {
            background-color: #e64a19;
        }
        .movie-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 20px;
            padding: 20px;
            flex: 1;
        }
        .movie-box {
            background-color: #212121;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            transition: transform 0.3s, box-shadow 0.3s;
            cursor: pointer;
            display: flex;
            flex-direction: column;
        }
        .movie-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.4);
        }
        .movie-box img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-bottom: 1px solid #333;
        }
        .movie-details {
            padding: 15px;
        }
        .movie-details h2 {
            font-size: 20px;
            margin: 0 0 10px;
        }
        .movie-details p {
            margin: 0;
            font-size: 14px;
            color: #b0b0b0;
        }
        .pagination {
            display: flex;
            justify-content: center;
            margin: 20px auto;
            text-align: center;
        }
        .pagination .page-button {
            background-color: #121212;
            color: #e0e0e0;
            border: none;
            padding: 10px 15px;
            margin: 0 5px;
            cursor: pointer;
            border-radius: 5px;
            font-size: 16px;
            transition: background-color 0.3s;
        }
        .pagination .page-button:hover {
            background-color: #ff5722;
        }
        .pagination .page-dots {
            margin: 0 5px;
            color: #e0e0e0;
        }
        .pagination .page-input {
            width: 50px;
            padding: 5px;
            border: 1px solid #333;
            border-radius: 5px;
            background-color: #212121;
            color: #e0e0e0;
            font-size: 16px;
            text-align: center;
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

<div class="container mt-4">
    <form action="{{ route('movies.search') }}" method="GET" class="search-form">
        <input type="text" name="query" placeholder="Search for movies" aria-label="Search" value="{{ request()->input('query') }}">
        <button type="submit">Search</button>
    </form>

    <div class="movie-list">
        @forelse($movies as $movie)
        <div class="movie-box" onclick="goToMovieDetails('{{ $movie->movie_id }}')">
            @php
                $randomNumber = rand(1, 1000);
                $imageUrl = "https://picsum.photos/200/300?random={$movie->movie_id}_{$randomNumber}";
            @endphp
            <img src="{{ $imageUrl }}" alt="{{ $movie->title }} Poster">
            <div class="movie-details">
                <h2>{{ $movie->title }}</h2>
                <p>{{ $movie->release_year }}</p>
                <p>{{ $movie->genre }}</p>
                <p>{{ $movie->director }}</p>
            </div>
        </div>
        @empty
            <p>No movies found for the search query "{{ request()->input('query') }}"</p>
        @endforelse
    </div>

    @if ($movies->hasPages())
    <div class="pagination">
        @php
            $totalPages = $movies->lastPage();
            $currentPage = $movies->currentPage();
            $showButtons = 7;
            $half = floor($showButtons / 2);

            $start = max(1, $currentPage - $half);
            $end = min($totalPages, $currentPage + $half);

            if ($end - $start < $showButtons - 1) {
                if ($start > 1) {
                    $end = min($totalPages, $start + $showButtons - 2);
                } else {
                    $start = max(1, $end - $showButtons + 2);
                }
            }
        @endphp

        @if ($currentPage > 1)
            <button class="page-button" onclick="goToPage({{ $currentPage - 1 }})">«</button>
        @endif

        @if ($start > 1)
            <button class="page-button" onclick="goToPage(1)">1</button>
            @if ($start > 2)
                <span class="page-dots">...</span>
            @endif
        @endif

        @for ($i = $start; $i <= $end; $i++)
            @if ($i == $currentPage)
                <span class="page-button">{{ $i }}</span>
            @else
                <button class="page-button" onclick="goToPage({{ $i }})">{{ $i }}</button>
            @endif
        @endfor

        @if ($end < $totalPages)
            @if ($end < $totalPages - 1)
                <span class="page-dots">...</span>
            @endif
            <button class="page-button" onclick="goToPage({{ $totalPages }})">{{ $totalPages }}</button>
        @endif

        @if ($currentPage < $totalPages)
            <button class="page-button" onclick="goToPage({{ $currentPage + 1 }})">»</button>
        @endif
    </div>
    @endif
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    const movieDetailsUrl = @json(url('movie'));

    function goToMovieDetails(movieId) {
        window.location.href = `${movieDetailsUrl}/${movieId}`;
    }

    function goToPage(pageNumber) {
        const query = '{{ request()->input('query') }}';
        const url = new URL('{{ url('/movies') }}');
        url.searchParams.set('page', pageNumber);
        if (query) {
            url.searchParams.set('query', query);
        } else {
            url.searchParams.delete('query');
        }
        window.location.href = url.toString();
    }
</script>
</body>
</html>
