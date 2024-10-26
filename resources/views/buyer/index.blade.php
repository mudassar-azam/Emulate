@extends('layouts.app')
@section('content')
<div id="alert-success" class="alert alert-success" style="display: none;"></div>
<main class="main">
    <!-- Banner Section -->
    <section class="banner">
        <div class="banner-content">
            <h1>Rent or Own Iconic outfits from your favorite celebrities</h1>
            @auth
            <button class="cta-btn rounded-btn" onclick="window.location.href='{{ route('products.index') }}'">Purchase
                Now</button>
            @else
            <button class="cta-btn rounded-btn" onclick="openPopup('signin')">Purchase Now</button>
            @endauth

        </div>
        <div class="banner-image">

        </div>
    </section>

    <!-- images Section -->
    <section class="image-section">
        <div class="container">
            @foreach($users as $user)
            <div class="image-card">
                @if($user->settings && $user->settings->profile)
                <a href="{{route('seller.profile' , $user->id)}}"><img
                        src="{{ asset('sellers-profiles/' . $user->settings->profile) }}"></a>
                @else
                <a href="{{route('seller.profile' , $user->id)}}"> <img src="{{asset('default.jfif')}}"
                        alt="Image 1"></a>
                @endif
                <div class="overlay2">
                    <div class="overlay-content">
                        @if($user->name != null)
                        <a href="{{route('seller.profile' , $user->id)}}">
                            <h2>{{$user->name}}</h2>
                        </a>
                        @endif
                        @if($user->settings && $user->settings->introduction)
                        <a href="{{route('seller.profile' , $user->id)}}">
                            <p>{{ $user->settings->introduction }}</p>
                        </a>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>

    <!-- Team pepole image-box banner-->
    <section class="image-box-banner">
        <div class="image-box-container">
            @foreach($sellers as $seller)
            <div class="image-box">
                @if($seller->settings && $seller->settings->profile)
                <a href="{{route('seller.profile' , $seller->id)}}"><img
                        src="{{ asset('sellers-profiles/' . $seller->settings->profile) }}"></a>
                @else
                <a href="{{route('seller.profile' , $seller->id)}}"><img src="{{asset('default.jfif')}}"
                        alt="Image 1"></a>
                @endif
                <p>{{$seller->name}}</p>
            </div>
            @endforeach
        </div>
    </section>

    <section class="reserve-banner-section">
        <div class="banner-container">
            <div class="reserve-content">
                <h1>Exclusive Celebrity Apparel & Accessories At Your Fingertips</h1>
                @auth
                <button class="cta-btn rounded-btn"
                    onclick="window.location.href='{{ route('products.index') }}'">Purchase Now</button>
                @else
                <button class="cta-btn rounded-btn" onclick="openPopup('signin')">Purchase Now</button>
                @endauth
            </div>
        </div>
    </section>

    <section class="trending-container">
        <h2 class="trending-title">Trending Pieces</h2>
        <div class="product-slider" id="uniqueProductSlider">
            @foreach($items as $item)
            <div class="product-item">
                @php
                $firstImage = $item->itemImages->first();
                @endphp

                @if($firstImage)
                <a href="{{route('product.details' , $item->id)}}"><img
                        src="{{ asset('item-images/' . $firstImage->image_name) }}" style="height: 90%;width: 100%;"
                        class="product-image"></a>
                @else
                <a href="href=" {{route('product.details' , $item->id)}}""><img src="{{asset('default.jfif')}}"
                        style="height: 90%;width: 100%;" class="product-image"></a>
                @endif
                <a href="{{route('product.details' , $item->id)}}">
                    <p class="product-name">{{$item->name}}</p>
                </a>
                @if($item->item_type == 'for_rent')
                <a href="{{route('product.details' , $item->id)}}">
                    <p class="product-price">{{$item->rental_price}}$</p>
                </a>
                @else
                <a href="{{route('product.details' , $item->id)}}">
                    <p class="product-price">{{$item->sale_price}}$</p>
                </a>
                @endif
            </div>
            @endforeach
        </div>
        <div class="slider-controls">
            <button class="slider-btn" onclick="scrollSlider(-1)">&#10094;</button>
            <button class="slider-btn" onclick="scrollSlider(1)">&#10095;</button>
        </div>
    </section>

    <section class="faq-banner">
        <div class="faq-container">
            <h2 class="faq-title">FAQs</h2>

            <div class="faq-item" onclick="toggleFaq(this)">
                <h4>How are items protected?</h4>
                <p>Items are protected with insurance and safety measures during transportation.</p>
            </div>

            <div class="faq-item" onclick="toggleFaq(this)">
                <h4>What if my rental doesn't fit?</h4>
                <p>If your rental doesn't fit, you can request a size change or refund within 24 hours.</p>
            </div>

            <div class="faq-item" onclick="toggleFaq(this)">
                <h4>What is the cleaning policy?</h4>
                <p>We professionally clean every item before it's rented out to maintain high hygiene standards.</p>
            </div>

            <div class="faq-item" onclick="toggleFaq(this)">
                <h4>How does same-day delivery work?</h4>
                <p>Same-day delivery is available in select cities for orders placed before noon.</p>
            </div>

            <div class="faq-item" onclick="toggleFaq(this)">
                <h4>What if I return my rental late?</h4>
                <p>Late returns are subject to a late fee, which is outlined in your rental agreement.</p>
            </div>

        </div>
    </section>

</main>
@endsection