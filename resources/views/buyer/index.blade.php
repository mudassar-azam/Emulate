@extends('layouts.app')
@section('content')
<div id="alert-success" class="alert alert-success" style="display: none;"></div>
<main class="main">
    <!-- Banner Section -->
    <section class="banner">
        <div class="banner-content">
            <h1>Rent or Own Iconic outfits from your favorite creators</h1>
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
        
    <section class="image-section007">
        @foreach($sellers as $seller)
        <div class="image-container">
          @if($seller->settings && $seller->settings->profile)
            <a href="{{route('seller.profile' , $seller->id)}}">
                 <img src="{{ asset('sellers-profiles/' . $seller->settings->profile) }}" alt="Sample Image">
                    <div class="overlay">
                      <h1>{{$seller->name}}</h1>
                      <p>{{ $seller->settings->introduction }}</p>
                    </div>
            </a>
            @else
            <a href="{{route('seller.profile' , $seller->id)}}">
                <img src="{{asset('default.jfif')}}"alt="Image 1">
                <div class="overlay">
                  <p></p>
                </div>
            </a>
            @endif
        </div>
        @endforeach
</section>

    <section class="reserve-banner-section">
        <div class="banner-container">
            <div class="reserve-content">
                <h1>Exclusive Creators Apparel & Accessories At Your Fingertips</h1>
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
                    <p class="product-price">${{$item->rental_price}}</p>
                </a>
                @else
                <a href="{{route('product.details' , $item->id)}}">
                    <p class="product-price">${{$item->sale_price}}</p>
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
                <p style="text-align: left;">Items are protected with insurance and safety measures during transportation.</p>
            </div>

            <div class="faq-item" onclick="toggleFaq(this)">
                <h4>What if my rental doesn't fit?</h4>
                <p style="text-align: left;">If your rental doesn't fit, you can request a size change or refund within 24 hours.</p>
            </div>

            <div class="faq-item" onclick="toggleFaq(this)">
                <h4>What is the cleaning policy?</h4>
                <p style="text-align: left;">We professionally clean every item before it's rented out to maintain high hygiene standards.</p>
            </div>

            <div class="faq-item" onclick="toggleFaq(this)">
                <h4>How does same-day delivery work?</h4>
                <p style="text-align: left;">Same-day delivery is available in select cities for orders placed before noon.</p>
            </div>

            <div class="faq-item" onclick="toggleFaq(this)">
                <h4>What if I return my rental late?</h4>
                <p style="text-align: left;">Late returns are subject to a late fee, which is outlined in your rental agreement.</p>
            </div>

        </div>
    </section>

</main>
<script>


function scrollSlider(direction) {
  const slider = document.getElementById("uniqueProductSlider");
  const scrollAmount = direction * 220; // Adjust for item width + margin
  slider.scrollBy({ left: scrollAmount, behavior: "smooth" });
}
    
function toggleFaq(faq) {
  faq.classList.toggle("open");
}

</script>
@endsection