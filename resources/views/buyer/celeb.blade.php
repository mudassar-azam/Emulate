@extends('layouts.app')
@section('content')
<div id="alert-success" class="alert alert-success" style="display: none;"></div>

<main class="main">
    <style>
        .main {
            min-height: 70vh;
            /*display: flex;*/
            /*flex-direction:column;*/
            /*justify-content: center;*/
            /*align-items: center;*/
            padding: 20px;
        }

        .profile-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: space-between;
            width: 100%;
            max-width: 1200px;
        }

        .profile-item {
            list-style: none;
            flex: 0 0 18%; /* 4 items on larger screens */
            background: #f1f1f1;
            border-radius: 10px;
            box-shadow: 0 0 12px rgba(0, 0, 0, 0.15);
            padding: 20px;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            transition: transform 0.3s;
        }

        .profile-item:hover {
            transform: translateY(-5px);
        }

        .profile-item img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            margin-bottom: 15px;
            object-fit: cover;
            box-shadow: 0 0 8px rgba(0, 0, 0, 0.1);
        }

        .profile-item h3 {
            font-weight: 600;
            margin-bottom: 10px;
            font-size: 1.1em;
        }

        .profile-item p {
            font-size: 0.9em;
            opacity: 0.7;
        }

        @media (max-width: 1024px) {
            .profile-item {
                flex: 0 0 30%; /* 3 items on tablets */
            }
        }

        @media (max-width: 768px) {
            .profile-item {
                flex: 0 0 45%; /* 2 items on smaller tablets */
            }
        }

        @media (max-width: 480px) {
            .profile-item {
                flex: 0 0 100%; /* 1 item on mobile */
            }
        }
    </style>

    <div style="width: 100%; max-width: 1200px;">
        <div class="filter-bar" style="padding-bottom: 20px;">
            <div class="search-input">
                <input type="text" id="customSearchInput" class="search-bar" placeholder="Search.." onkeyup="filterProfiles()"/>
            </div>
        </div>
    </div>
    
    <!-- Dynamic Profile Section -->
    <ul class="profile-container" id="profileContainer">
        @foreach ($celebrities as $celebrity)
        <li class="profile-item">
            @if (!empty($celebrity->settings) && !empty($celebrity->settings->profile))
                <img src="{{ asset('sellers-profiles/' . $celebrity->settings->profile) }}" alt="user image">
            @else
                <img src="{{ asset('default-profile.png') }}" alt="default user image">
            @endif
            <h3 class="celebrity-name">{{ $celebrity->name }}</h3>
            <p>{{ $celebrity->settings->introduction ?? 'No introduction available' }}</p>
        </li>
        @endforeach
    </ul>

</main>

<script>
    function filterProfiles() {
        const input = document.getElementById('customSearchInput').value.toLowerCase();
        const profiles = document.querySelectorAll('#profileContainer .profile-item');

        profiles.forEach(profile => {
            const name = profile.querySelector('.celebrity-name').textContent.toLowerCase();
            if (name.includes(input)) {
                profile.style.display = ''; // Show matching profiles
            } else {
                profile.style.display = 'none'; // Hide non-matching profiles
            }
        });
    }
</script>
@endsection
