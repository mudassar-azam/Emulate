@extends('layouts.app')
@section('content')
<style>
.image-preview-container img {
    border: 1px solid #ddd;
    border-radius: 4px;
    padding: 5px;
    margin: 10px;
    max-width: 150px;
    max-height: 150px;
}
</style>
<div id="alert-danger" class="alert alert-danger" style="display: none;">
    <ul id="error-list"></ul>
</div>
<div id="alert-success" class="alert alert-success" style="display: none;"></div>
<main class="main">
    <div class="profile-section">
        <div class="profile-header">
            <div class="d-flex align-center">
                @if($user->settings && $user->settings->profile)
                <img src="{{ asset('sellers-profiles/' . $user->settings->profile) }}" alt="Profile Image"
                    class="profile-img">
                @else
                <img src="{{asset('default.jfif')}}" alt="Profile Image" class="profile-img">
                @endif
                <h1>{{$user->name}}</h1>
            </div>
        </div>
        <div class="profile-info">
            <div class="profile-details" style="width:100%;">
                <div class="d-flex justify-between">
                    @if($user->settings && $user->settings->introduction)
                    <p>{{ $user->settings->introduction }}</p>
                    @else
                    <p>There is no introduction of this celebrity present yet.</p>
                    @endif
                    <div class="subscriber-count">
                        <h2>{{$user->subscribers}}</h2>
                        <p>Subscribers</p>
                    </div>
                </div>
                <div class="social-icons">
                    @auth
                        @if($subscriber != null)
                            <button type="button" class="subscribe-btn">SUBSCRIBED</button>
                        @else
                            <form  action="{{route('seller.subscribe')}}" method="post">
                                @csrf
                                <input type="hidden" name="seller_id" value="{{$user->id}}">
                                <button type="submit" class="subscribe-btn">SUBSCRIBE</button>
                            </form>
                        @endif    
                    @endauth    
                    @if($user->settings && $user->settings->facebook_link)
                    <a href="{{$user->settings->facebook_link}}" target="_blank"><i
                            class="fa-brands fa-facebook"></i></a>
                    @endif
                    @if($user->settings && $user->settings->twitter_link)
                    <a href="{{$user->settings->twitter_link}}" target="_blank"><i class="fa-brands fa-twitter"></i></a>
                    @endif
                    @if($user->settings && $user->settings->instagram_link)
                    <a href="{{$user->settings->instagram_link}}" target="_blank"><i
                            class="fa-brands fa-instagram"></i></a>
                    @endif
                    @if($user->settings && $user->settings->youtube_link)
                    <a href="{{$user->settings->youtube_link}}" target="_blank"><i class="fa-brands fa-youtube"></i></a>
                    @endif
                </div>
            </div>
        </div>

        <div class="tabs">
            <button class="tab active" data-tab="tab1">Items For Rent Or Purchase</button>
            <button class="tab" data-tab="tab2">Post</button>
        </div>

        <div class="tab1-content active">
            <div class="search-section">
                <input type="text" id="customSearchInputSeller" placeholder="Search">
                <div class="d-flex" style="gap:10px;">
                    <p id="resultCount">{{ count($items) }} results</p>
                </div>
            </div>
            <div class="product-cards-container" style="width:100%;overflow:unset;">
                <div class="product-cards" id="productCards">
                    <div class="product-flex" id="uniqueProductflex">
                        @foreach($items as $item)
                        <div class="product-item" data-name="{{ strtolower($item->name) }}">
                            @php
                            $firstImage = $item->itemImages->first();
                            @endphp

                            @if($firstImage)
                            <img style="height: 80%;width: 60%;"
                                src="{{ asset('item-images/' . $firstImage->image_name) }}" class="product-image">
                            @else
                            <img src="{{asset('default.jfif')}}" class="product-image">
                            @endif
                            <p class="product-name">{{$item->name}}</p>
                            @if($item->item_type == 'for_rent')
                            <p class="product-price">{{$item->rental_price}}$</p>
                            @else
                            <p class="product-price">{{$item->sale_price}}$</p>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="tab2-content">
            <div class="search-section" style="justify-content: end;">
                <!-- <input type="text" placeholder="Search" id="customSearchPost"> -->
                <div class="d-flex" style="gap:10px;">
                    <p id="resultCountPost"></p>
                </div>
            </div>
            <div class="product-cards-container" style="width:100%;overflow:unset;">
                <div class="product-cards" id="productCards">
                    <div class="product-flex" id="uniqueProductflex">
                        @foreach($posts as $post)
                        @php
                            $firstImage = $post->postImages->first();
                        @endphp
                        <div class="product-item celeb-post" data-name="{{ strtolower($post->item->name) }}">
                            @if($firstImage)
                            <img style="height: 80%;width: 60%;"
                                src="{{ asset('post-images/' . $firstImage->image_name) }}" class="product-image">
                            @else
                            <img src="{{asset('default.jfif')}}" class="product-image">
                            @endif
                            @if($post->item->item_type == 'for_rental')
                                <p class="product-price">{{$post->item->rental_price}}$</p>
                            @else
                            <p class="product-price">{{$post->item->sale_price}}$</p>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@endsection

@push('scripts')

<script>
    document.getElementById('customSearchInputSeller').addEventListener('input', function() {
        const query = this.value.toLowerCase();
        const productItems = document.querySelectorAll('.tab1-content.active .product-item');
        let visibleCount = 0;

        productItems.forEach(function(item) {
            const productName = item.getAttribute('data-name').toLowerCase();

            if (productName.includes(query)) {
                item.style.display = 'block';
                visibleCount++;
            } else {
                item.style.display = 'none';
            }
        });

        document.getElementById('resultCount').textContent = `${visibleCount} results`;
    });
</script>

<!-- to redirect  -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- script for switching tabs  -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tabButtons = document.querySelectorAll('.tab');
        const tabContents = document.querySelectorAll('.tab1-content, .tab2-content');

        function switchTab(event) {
            // Remove 'active' class from all tabs
            tabButtons.forEach(button => button.classList.remove('active'));

            // Hide all tab contents
            tabContents.forEach(content => {
                content.style.display = 'none';
                content.style.opacity = 0;
            });

            // Add 'active' class to the clicked tab
            event.target.classList.add('active');

            // Get the value of 'data-tab' attribute to identify which tab to show
            const selectedTab = event.target.getAttribute('data-tab');

            // Select the corresponding tab content using the 'data-tab' value
            const contentToShow = document.querySelector(`.${selectedTab}-content`);
            if (contentToShow) {
                contentToShow.style.display = 'block';
                contentToShow.style.opacity = 1;
            }
        }

        // Attach click event listeners to all tab buttons
        tabButtons.forEach(button => button.addEventListener('click', switchTab));

        // Initialize the first tab as active on page load
        if (tabButtons.length > 0 && tabContents.length > 0) {
            tabButtons[0].classList.add('active');
            tabContents[0].style.display = 'block';
            tabContents[0].style.opacity = 1;
        }
    });
</script>


@endpush