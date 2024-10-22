@extends('layouts.app')
@section('content')
<main class="main">
    <div id="alert-success" class="alert alert-success" style="display: none;"></div>
    <style>
    .back-btn {
        cursor: pointer;
    }

    .heart-icon {
        border-radius: 50%;
        padding: 5px;
    }
    </style>

    <div class="back-btn" onclick="goBack()">
        <i class="fa-solid fa-arrow-left"></i>
    </div>
    <div class="single-product-container">
        <div class="single-product-wrapper">
            <div class="product-images">
                <div class="card">
                    <div class="demo">
                        <ul id="lightSlider">
                            @foreach($item->itemImages as $image)
                            <li data-thumb="{{ asset('item-images/' . $image->image_name) }}">
                                <img src="{{ asset('item-images/' . $image->image_name) }}" />
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <!-- Right: Product Details -->
            <div class="product-right-details" style="gap: 3.5em;">
                <div class="product-header">
                    @if($item->user->settings && $item->user->settings->profile)
                        <a href="{{route('seller.profile' , $item->user->id)}}">
                            <img src="{{ asset('sellers-profiles/' . $item->user->settings->profile) }}" alt="Profile Image"
                            class="profile-img">
                        </a>
                    @else
                        <a href="{{route('seller.profile' , $item->user->id)}}"><img src="{{asset('default.jfif')}}" class="profile-img"></a>
                    @endif
                    <a href="{{route('seller.profile' , $item->user->id)}}"><span class="seller-name">{{$item->user->name}}</span></a>
                </div>
                <div class="d-flex justify-between align-center">
                    <h2>{{$item->name}}</h2>
                    @php
                    use Illuminate\Support\Facades\Auth;
                    use App\Models\Buyer\Wishlist;

                    $user = Auth::user();
                    $isInWishlist = false;

                    if ($user) {
                    $isInWishlist = Wishlist::where('user_id', $user->id)->where('name', $item->name)->exists();
                    }
                    @endphp
                    @auth
                    @if ($isInWishlist)
                    <button type="button" class="cart-btn">
                        <i class="fa-solid fa-heart heart-icon" style="color:black;"></i>
                    </button>
                    @else
                    <form id="addToWishlist" action="{{ route('add.wishlist') }}" method="post">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $item->id }}">
                        <button type="submit" class="cart-btn">
                            <i class="fa-regular fa-heart" style="color:black;"></i>
                        </button>
                    </form>
                    @endif
                    @endauth
                </div>

                <div>
                    <div><b>Size: </b><span>{{$item->size}}</span></div>
                </div>

                <div style="display:flex;gap:1em;">
                    <div><b>Description: </b>{{$item->description}}</div>
                </div>

                <div class="product-pricing">
                    <p class="retail">Sale Price : {{$item->sale_price}}$</p>
                </div>
                @auth
                    <div class="product-actions">
                        @if($item->stock > 0)
                            <button class="buy-now-btn" onclick="openPopup('buy')">Buy Now</button>
                        @else
                            <button class="buy-now-btn">Out Of Stock</button>
                        @endif
                        <form action="{{route('cart.store')}}" method="post">
                            @csrf
                            <input type="hidden" name="ptoduct_id" value="{{$item->id}}">
                            <button id="add-to-cart" data-product-id="{{ $item->id }}" style="width: 100%;" class="rent-btn">Add To Cart</button>
                        </form>
                    </div>
                @else
                    <button class="buy-now-btn" onclick="openPopup('signin')">Login ! To Buy Item</button>
                @endauth
            </div>
        </div>
        <style>
        .lSSlideOuter .lSPager.lSGallery img {
            height: 5em !important;
        }
        </style>
        <div class="product-section2">
            @foreach($item->itemImages as $image)
            <div class="box"><img src="{{ asset('item-images/' . $image->image_name) }}"
                    style="width: 100%;height: 100%;"></div>
            @endforeach
        </div>
        <div class="product-right-details special-bottom">
            <div class="product-header">
                <span class="seller-name">Information</span>
            </div>

            <div class="product-sizes">
                <div>Size: <span>{{$item->size}}</span></div>
            </div>
        </div>
    </div>
    <section class="trending-container" style="background:#ddd;">
        <h2 class="trending-title" style="text-align:left;padding-left:4rem;font-size:1rem;">You may also like</h2>
        <div class="product-slider" id="uniqueProductSlider">
            @foreach($products as $product)
                <div class="product-item">
                    @php
                        $firstImage = $product->itemImages->first();
                    @endphp

                    @if($firstImage)
                        <a href="{{route('product.buy.details' , $product->id)}}"><img style="height: 86%;width: 100%;"
                            src="{{ asset('item-images/' . $firstImage->image_name) }}" class="product-image"></a>
                    @else
                        <a href="{{route('product.buy.details' , $product->id)}}"><img src="{{asset('default.jfif')}}"
                            class="product-image"></a>
                    @endif
                    <a href="{{route('product.buy.details' , $product->id)}}">
                        <p class="product-name">{{$product->name}}</p>
                    </a>
                    <a href="{{route('product.buy.details' , $product->id)}}">
                        <p class="product-price">{{$product->sale_price}}$</p>
                    </a>
                </div>
            @endforeach
        </div>
        <div class="slider-controls">
            <button class="slider-btn" onclick="scrollSlider(-1)">&#10094;</button>
            <button class="slider-btn" onclick="scrollSlider(1)">&#10095;</button>
        </div>
    </section>
</main>

<!-- Buy popup -->
<div id="buy-popup" class="popup">
    <div class="container">
        <div class="d-flex justify-between"
            style="margin-bottom:40px;border-bottom:1px solid lightgray;padding:0.8rem 1rem;">
            <h2>Buy Now</h2>
            <a href="#">Need help?</a>
        </div>
        <div class="sub-container">
            <form id="buyNowForm" action="{{route('buyer.order.now')}}" method="post">
                @csrf
                <label for="zip">Delivery ZIP Code</label>
                <input type="text" id="zip" name="zip" placeholder="Enter ZIP Code">

                <label for="size">Size</label>
                <select id="size" name="size">
                    <option disabled>select size</option>
                    <option value="{{$item->size}}">{{$item->size}}</option>
                </select>

                <input type="hidden" name="product_id" value="{{$item->id}}">

                <button type="submit" class="apply-btn">Order</button>
            </form>
        </div>
    </div>
</div>



@endsection
@push('scripts')

<!-- to go back on previous page  -->
<script>
function goBack() {
    window.history.back();
}
</script>

<link rel='stylesheet' href='https://sachinchoolur.github.io/lightslider/dist/css/lightslider.css'>

<script src='https://sachinchoolur.github.io/lightslider/dist/js/lightslider.js'></script>
<script>
$('#lightSlider').lightSlider({
    gallery: true,
    item: 1,
    loop: true,
    slideMargin: 0,
    thumbItem: 6
});
</script>

<!-- for buy now  -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    var myForm = document.getElementById('buyNowForm');
    var errorAlert = document.getElementById('alert-danger');
    var errorList = document.getElementById('error-list');
    var successAlert = document.getElementById('alert-success');
    myForm.addEventListener('submit', function(event) {
        event.preventDefault();
        var formElements = myForm.querySelectorAll('input, select, textarea');
        formElements.forEach(function(element) {
            element.style.border = '';
            if (element.type === 'file') {
                element.classList.remove('file-not-valid');
            }
        });
        var formData = new FormData(myForm);
        fetch(myForm.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                        'content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    toastr.success('Thanks for placing your order. Proceed to checkout',
                        'Success', {
                            positionClass: 'toast-top-right',
                            timeOut: 3000
                        });
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                } else {
                    toastr.error('Already Sold', 'Success', {
                        positionClass: 'toast-top-right',
                        timeOut: 3000
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    });
});
</script>



@endpush