<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Web Application - Actors</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
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
            border-bottom: 2px solid #ff5722;
        }
        .navbar a {
            color: #e0e0e0;
            text-decoration: none;
            font-size: 16px;
            margin-left: 20px;
            transition: color 0.3s, border-bottom 0.3s;
            padding-bottom: 5px;
            border-bottom: 2px solid transparent;
        }
        .navbar a:hover, .navbar a.active {
            color: #ff5722;
            border-bottom: 2px solid #ff5722;
        }
        .actor-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 20px;
            padding: 20px;
            flex: 1;
        }
        .actor-box {
            background-color: #212121;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            transition: transform 0.3s, box-shadow 0.3s;
            cursor: pointer;
            display: flex;
            flex-direction: column;
            text-align: center;
        }
        .actor-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.4);
        }
        .actor-box img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-bottom: 1px solid #333;
        }
        .actor-details {
            padding: 15px;
        }
        .actor-details h2 {
            font-size: 20px;
            margin: 0 0 10px;
        }
        .actor-details p {
            margin: 0;
            font-size: 14px;
            color: #b0b0b0;
        }
        .pagination {
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
            width: 3px;
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

<div class="actor-list">
    @foreach($actors as $actor)
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

<div class="pagination">
    @php
        $totalPages = $actors->lastPage();
        $currentPage = $actors->currentPage();
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

<script>
    function goToActorDetails(actorId) {
        window.location.href = `{{ url('/actor') }}/${actorId}`;
    }

    function goToPage(pageNumber) {
        window.location.href = `{{ url('/actor') }}?page=${pageNumber}`;
    }
</script>

</body>
</html>
