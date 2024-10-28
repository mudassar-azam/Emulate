@extends('layouts.app')
@section('content')
<main class="main">
    <div id="alert-danger" class="alert alert-danger" style="display: none;">
        <ul id="error-list"></ul>
    </div>
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
                    <a href="{{route('seller.profile' , $item->user->id)}}"><img src="{{asset('default.jfif')}}"
                            class="profile-img"></a>
                    @endif
                    <div style="display:flex;width: 50%;justify-content: space-between;align-items:center;">
                        <a href="{{route('seller.profile' , $item->user->id)}}"><span
                                class="seller-name">{{$item->user->name}}</span></a>
                        @auth
                            @if(auth()->user()->role == 'seller' || auth()->user()->role == 'admin')
                                <button onclick="openPopup('addnewitem')"><i class="fa-regular fa-pen-to-square"></i></button>
                            @endif
                        @endauth
                    </div>
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
                    <p class="retail">Sale Price : ${{$item->sale_price}}</p>
                </div>
                @auth
                <div class="product-actions" style="gap:2em">
                    @if($item->stock > 0)
                    <form action="{{route('buyer.order.now')}}" method="post">
                        @csrf
                        <input type="hidden" name="product_id" value="{{$item->id}}">
                        <button style="width:100%" class="buy-now-btn" type="submit">Buy Now</button>
                    </form>
                    @else
                    <button class="buy-now-btn">Out Of Stock</button>
                    @endif
                    <form action="{{route('cart.store')}}" method="post">
                        @csrf
                        <input type="hidden" name="ptoduct_id" value="{{$item->id}}">
                        <button id="add-to-cart" data-product-id="{{ $item->id }}" style="width: 100%;"
                            class="rent-btn">Add To Cart</button>
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
                    <p class="product-price">${{$product->sale_price}}</p>
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
<div id="addnewitem-popup" class="popup">
    <div class="container">
        <div class="d-flex justify-between"
            style="margin-bottom:40px;border-bottom:1px solid lightgray;padding:0.8rem 1rem;">
            <h2>Update Item</h2>
            <div><span style="font-weight: bold; cursor:pointer;" onclick="closePopup('addnewitem')">X</span></div>
        </div>
        <div class="sub-container">
            <form id="createItem" action="{{ route('item.update', $item->id) }}" method="post"
                enctype="multipart/form-data">
                @csrf
                <label for="name">Name</label>
                <input type="text" id="name" name="name" value="{{ $item->name }}">

                <label for="images">Photo</label>
                <input type="file" name="images[]" id="images" multiple="multiple">

                <label for="category">Select Category</label>
                <select name="category_id" id="category_id">
                    <option selected disabled>Select Item</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ $item->category_id == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                    @endforeach
                </select>

                <label for="item_type">Item Type</label>
                <select id="item_type" name="item_type" onchange="toggleFields()">
                    <option selected disabled>Select Type</option>
                    <option value="for_sale" {{ $item->item_type == 'for_sale' ? 'selected' : '' }}>For Sale</option>
                    <option value="for_rent" {{ $item->item_type == 'for_rent' ? 'selected' : '' }}>For Rent</option>
                </select>

                <div id="for-sale" style="display: {{ $item->item_type == 'for_sale' ? 'block' : 'none' }}">
                    <label for="sale_price">Sale Price</label>
                    <input type="number" id="sale_price" name="sale_price" value="{{ $item->sale_price }}"
                        placeholder="Sale Price">
                </div>

                <div id="for-rent" style="display: {{ $item->item_type == 'for_rent' ? 'block' : 'none' }}">
                    <label for="rental_price">Rental Price Per Day</label>
                    <input type="number" id="rental_price" name="rental_price" value="{{ $item->rental_price }}"
                        placeholder="Rental Price">
                    <label for="start_date">Start Date</label>
                    <input
                        style="width: 100%;padding: 6px;margin-bottom: 20px;border: 1px solid #ddd;border-radius: 5px;"
                        type="date" id="start_date" name="start_date" value="{{ $item->start_date }}">
                    <label for="end_date">End Date</label>
                    <input
                        style="width: 100%;padding: 6px;margin-bottom: 20px;border: 1px solid #ddd;border-radius: 5px;"
                        type="date" id="end_date" name="end_date" value="{{ $item->end_date }}">
                </div>

                <div id="for-stock">
                    <label for="stock">Stock</label>
                    <input type="number" id="stock" name="stock" value="{{ $item->stock }}">
                </div>

                <div id="description">
                    <label for="description">Description</label>
                    <input type="text" id="description" name="description" value="{{ $item->description }}">
                </div>

                <label for="size">Size</label>
                <select id="size" name="size">
                    <option value="L" {{ $item->size == 'L' ? 'selected' : '' }}>L</option>
                    <option value="M" {{ $item->size == 'M' ? 'selected' : '' }}>M</option>
                    <option value="S" {{ $item->size == 'S' ? 'selected' : '' }}>S</option>
                </select>

                <button type="submit" class="apply-btn">Update Item</button>
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
<script>
function toggleFields() {
    const itemType = document.getElementById('item_type').value;
    const forSaleDiv = document.getElementById('for-sale');
    const forRentDiv = document.getElementById('for-rent');

    forSaleDiv.style.display = 'none';
    forRentDiv.style.display = 'none';

    if (itemType === 'for_sale') {
        forSaleDiv.style.display = 'block';
    } else if (itemType === 'for_rent') {
        forRentDiv.style.display = 'block';
    }
}
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var myForm = document.getElementById('createItem');
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
                    errorAlert.style.display = 'none';
                    successAlert.textContent = data.message;
                    successAlert.style.display = 'block';
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                    setTimeout(function() {
                        successAlert.style.display = 'none';
                    }, 4000);
                    location.reload();
                } else {
                    errorList.innerHTML = '';
                    if (data.errors.length > 0) {
                        var li = document.createElement('li');
                        li.textContent = data.errors[0].message;
                        errorList.appendChild(li);
                        errorAlert.style.display = 'block';
                        successAlert.style.display = 'none';
                        var firstErrorField;
                        data.errors.forEach(function(error, index) {
                            var errorField = myForm.querySelector(
                                `[name="${error.field}"]`);
                            if (errorField) {
                                errorField.style.border = '1px solid red';
                                if (errorField.type === 'file') {
                                    errorField.classList.add('file-not-valid');
                                }
                                if (index === 0) {
                                    firstErrorField = errorField;
                                }
                            }
                        });

                        // Focus on the first invalid input field
                        if (firstErrorField) {
                            firstErrorField.focus();
                        }
                        setTimeout(function() {
                            errorAlert.style.display = 'none';
                        }, 3000);
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    });
    myForm.addEventListener('input', function(event) {
        if (event.target.tagName === 'INPUT' || event.target.tagName === 'TEXTAREA') {
            if (event.target.value.trim() !== '') {
                event.target.style.border = '';
                if (event.target.type === 'file') {
                    event.target.classList.remove('file-not-valid');
                }
            }
        }
    });
    myForm.addEventListener('change', function(event) {
        if (event.target.tagName === 'SELECT') {
            if (event.target.value.trim() !== '') {
                event.target.style.border = '';
                if (event.target.type === 'file') {
                    event.target.classList.remove('file-not-valid');
                }
            }
        }
    });
});
</script>
@endpush