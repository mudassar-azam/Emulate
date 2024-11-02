
@extends('layouts.app')
@section('content')
<div id="alert-success" class="alert alert-success" style="display: none;"></div>

<main class="main">
    <style>
        .profile001 {
            display: grid;
            place-content: center;
            min-height: 100%;
            padding: 0 20px 20px 20px;
        }

        .profile001 ul {
            position: relative;
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
        }

        .profile001 ul li {
            list-style: none;
            flex: 0 0 30%;
            aspect-ratio: 10/1;
            padding: 16px;
            background: linear-gradient(45deg, #000, #000, gray);
            border-radius: 10px;
            display: flex;
            gap: 20px;
            align-items: center;
            color: white;
            box-shadow: 0 0 12px rgba(0, 0, 0, .24);
            cursor: pointer;
        }

        .profile001 ul li img {
            max-width: 64px;
            border-radius: 50%;
        }

        .profile001 ul li .content h3 {
            font-weight: 600;
            margin-bottom: 6px;
            line-height: 1;
        }

        .profile001 ul li .content p {
            opacity: .6;
            line-height: 1;
        }

        @media (max-width: 768px) {
            .profile001 ul {
                justify-content: space-around;
            }
        }
    </style>

    <!-- Search Input -->
    <div style="padding:20px;">
        <div class="filter-bar">
            <div class="search-input">
                <input type="text" id="customSearchInput" class="search-bar" placeholder="Search.." />
                <!--<button onclick="searchCelebrities()">Search</button>-->
            </div>
        </div>
    </div>

    <!-- Dynamic Profile Section -->
  <div class="profile001">
    <ul id="celebritiesList">
        @foreach ($celebrities as $celebrity)
        <li>
            @if (!empty($celebrity->settings) && !empty($celebrity->settings->profile))
                <img src="{{ asset('sellers-profiles/' . $celebrity->settings->profile) }}" alt="user image">
            @endif
            <div class="content">
                <h3>{{ $celebrity->name }}</h3>
                <p>{{ $celebrity->settings->introduction ?? 'No introduction available' }}</p>
            </div>
        </li>
        @endforeach
    </ul>
</div>

    <!-- Pagination Links -->
    <!--<div class="pagination-links" style="text-align: center; padding-top: 20px;">-->
    <!--    {{ $celebrities->links() }}-->
    <!--</div>-->
</main>

<script>
    function searchCelebrities() {
        const searchInput = document.getElementById('customSearchInput').value;
        const url = new URL(window.location.href);
        url.searchParams.set('search', searchInput);
        window.location.href = url;
    }
</script>
@endsection
