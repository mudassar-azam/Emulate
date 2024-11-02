<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Emulate - Fashion Banner</title>
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/checkout.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/header.css')}}" />

    <link rel="stylesheet" href="{{asset('assets/css/orderDetail.css')}}" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer">
    </script>
    <script type='text/javascript' src='https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js'>
    </script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body>
    <header class="header">
        <div class="left-header">
            <div class="menu-btn">
                <svg class="hb" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 10 10" stroke="#eee" stroke-width=".6"
                    fill="rgba(0,0,0,0)" stroke-linecap="round" style="cursor: pointer">
                    <path d="M2,3L5,3L8,3M2,5L8,5M2,7L5,7L8,7">
                        <animate dur="0.2s" attributeName="d"
                            values="M2,3L5,3L8,3M2,5L8,5M2,7L5,7L8,7;M3,3L5,5L7,3M5,5L5,5M3,7L5,5L7,7" fill="freeze"
                            begin="start.begin" />
                        <animate dur="0.2s" attributeName="d"
                            values="M3,3L5,5L7,3M5,5L5,5M3,7L5,5L7,7;M2,3L5,3L8,3M2,5L8,5M2,7L5,7L8,7" fill="freeze"
                            begin="reverse.begin" />
                    </path>
                    <rect width="10" height="10" stroke="none">
                        <animate dur="2s" id="reverse" attributeName="width" begin="click" />
                    </rect>
                    <rect width="10" height="10" stroke="none">
                        <animate dur="0.001s" id="start" attributeName="width" values="10;0" fill="freeze"
                            begin="click" />
                        <animate dur="0.001s" attributeName="width" values="0;10" fill="freeze" begin="reverse.begin" />
                    </rect>
                </svg>
            </div>
            <div class="logo"><a href="/">Emulate</a></div>
            <nav>
                <ul class="nav-links">
                    <li><a href="{{route('products.index')}}">Products</a></li>
                    <li><a href="#">Creaters</a></li>
                    <li><a href="{{route('product.rent')}}">Rental</a></li>
                    <li><a href="{{route('product.buy')}}">Purchase</a></li>
                    <li><a href="#">About Us</a></li>
                    <li><i class="fa-solid fa-magnifying-glass"></i></li>
                </ul>
            </nav>
        </div>
        <div class="header-buttons" style="width: 10%;">
            @if(Auth::check())
                @if(auth()->user()->role == 'seller' || auth()->user()->role == 'admin')
                    <form id="logout-form" action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="sign-in-btn rounded-btn">Logout</button>
                    </form>
                @endif
            @else
            <button class="sign-in-btn rounded-btn" onclick="openPopup('signin')">Sign In</button>
            @endif
        </div>
    </header>
    <style>
        .back-btn {
            cursor: pointer;
        }
    </style>
    <main class="main" style="margin-top: 7em;">
        <div class="back-btn" onclick="goBack()">
            <i class="fa-solid fa-arrow-left"></i>
        </div>

        <div class="checkout-container" style="display: flex;gap: 8em;">
            <!-- Left Section: Ship To -->
            <form class="payment-form">

                <h3>Ship To</h3>

                <div style="display: flex;margin: 4% 0px;gap: 1em;">
                    <div>
                        <input type="text" name="fname" class="field" placeholder="First Name" required>
                    </div>

                    <div>
                        <input type="text" name="lname" class="field" placeholder="Last Name" required>
                    </div>
                </div>

                <div style="display: flex;margin: 4% 0px;gap: 1em;flex-direction:column">
                    <div>
                        <input style="width: 100%;" type="text" name="address" class="field" placeholder="Address"
                            required>
                    </div>

                    <div>
                        <input style="width: 100%;" type="text" name="suite" class="field"
                            placeholder="Apt/Unit/Suite(optional)">
                    </div>
                </div>

                <div style="display: flex;margin: 4% 0px;gap: 1em;">
                    <div>
                        <input type="text" name="city" class="field" placeholder="City" required>
                    </div>

                    <div>
                        <input type="text" name="state" class="field" placeholder="State" required>
                    </div>
                </div>

                <div style="display: flex;margin: 4% 0px;gap: 1em;">
                    <div>
                        <input type="text" name="zip" class="field" placeholder="Zip Code" required>
                    </div>

                    <div>
                        <input type="text" name="number" class="field" placeholder="Mobile Number" required>
                    </div>
                </div>

                <div style="margin:2% 0%">
                    <h3>Payment</h3>
                </div>

                <label>
                    <div id="card-element" class="field"></div>
                </label>
                @if($orders->count() >0 )
                <button type="submit" class="payment"><i class="fa fa-spinner fa-spin" style="display:none;"></i>Pay
                    Now</button>
                @endif
                <div class="outcome">
                    <div class="error"></div>
                    <div class="success"><span class="token"></span>
                    </div>
                </div>
            </form>

            @php
            $total = 0;
            @endphp

            <!-- Right Section: Your Rentals -->
            <div class="rentals-section">
                <h2>Your Items</h2>
                <div class="rental-items-container">
                    @foreach($orders as $order)
                    <div class="rental-item">
                        <div class="rental-details">
                            @php
                            $firstImage = $order->product->itemImages->first();
                            $total = $total + $order->total_payment;
                            @endphp

                            @if($firstImage)
                            <img src="{{ asset('item-images/' . $firstImage->image_name) }}">
                            @else
                            <img src="{{asset('default.jfif')}}" alt="Product Image">
                            @endif

                            <div class="rental-description">
                                <p>{{$order->product->name}}</p>
                                <p>{{$order->product->size}}</p>
                            </div>
                        </div>
                        <div class="rental-action">
                            <p class="rental-price">${{ $order->total_payment }}</p>
                            <span data-id="{{ $order->id }}" class="remove-item delete-order">🗑️</span>
                        </div>
                    </div>
                    @endforeach
                </div>

                @if($orders->count() > 0)
                <div class="promo-code">
                    <input type="text" placeholder="Promo Code">
                    <button class="apply-btn">APPLY</button>
                </div>
                @endif

                <div class="pricing-summary">
                    <p>Subtotal: <span>${{$total}}</span></p>
                    <p>Shipping: <span>$0</span></p>
                    <p>Tax: <span>$0</span></p>
                    <hr>
                    <p class="total-price">Total: <span>${{$total}}</span></p>
                    @php
                    session(['total_price' => $total]);
                    session(['orders' => $orders]);
                    @endphp
                </div>
            </div>
        </div>

    </main>
</body>

<script>
    function goBack() {
        window.history.back();
    }
</script>

<script src="https://js.stripe.com/v3/"></script>
<script type="text/javascript">
// Initialize Stripe with the publishable key
var stripe = Stripe(
    'pk_test_51Q64ki07Ru2Bf5p4qMDQmBHDKcGR6n1568YZPxTjbkdrhuxMxl09SV5chJDjc8tvFz9io7PF3kXK4XNBZMrQHF4o00OarlIHpp');

// Create Stripe Elements instance
var elements = stripe.elements({
    fonts: [{
        family: 'Open Sans',
        weight: 400,
        src: 'local("Open Sans"), local("OpenSans"), url(https://fonts.gstatic.com/s/opensans/v13/cJZKeOuBrn4kERxqtaUH3ZBw1xU1rKptJj_0jans920.woff2) format("woff2")',
        unicodeRange: 'U+0000-00FF, U+0131, U+0152-0153, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2212, U+2215',
    }, ]
});

// Create a card element and style it
var card = elements.create('card', {
    hidePostalCode: true,
    style: {
        base: {
            iconColor: '#F99A52',
            color: '#32315E',
            lineHeight: '48px',
            fontWeight: 400,
            fontFamily: '"Open Sans", "Helvetica Neue", "Helvetica", sans-serif',
            fontSize: '15px',
            '::placeholder': {
                color: '#CFD7DF',
            }
        }
    }
});

card.mount('#card-element');

card.on('change', function(event) {
    var errorElement = document.querySelector('.error');
    if (event.error) {
        errorElement.textContent = event.error.message;
        errorElement.classList.add('visible');
    } else {
        errorElement.textContent = '';
        errorElement.classList.remove('visible');
    }
});

// Handle form submission
document.querySelector('.payment-form').addEventListener('submit', function(e) {

    e.preventDefault();


    var form = document.querySelector('.payment-form');
    var errorElement = document.querySelector('.error');
    var successElement = document.querySelector('.success');

    // Clear previous success/error messages
    errorElement.textContent = '';
    errorElement.classList.remove('visible');
    successElement.textContent = '';
    successElement.classList.remove('visible');

    document.querySelector('.payment i').style.display = 'inline-block';

    document.querySelector('.payment').disabled = true;

    // Create a token
    stripe.createToken(card).then(function(result) {
        if (result.error) {
        
            errorElement.textContent = result.error.message;
            errorElement.classList.add('visible');

            document.querySelector('button').disabled = false;
            document.querySelector('button i').style.display = 'none';
        } else {
            successElement.textContent = 'Token created: ' + result.token.id;
            successElement.classList.add('visible');

            var formData = new FormData(form);
            var data = {
                token: result.token.id
            };

            // Append other form fields to the data object
            formData.forEach((value, key) => {
                if (key !== 'token') { // Avoid duplicate token entry
                    data[key] = value;
                }
            });

            var req = new XMLHttpRequest();
            req.open("POST", "/new-card", true); 
            req.setRequestHeader("Content-Type", "application/json"); 
            req.setRequestHeader("X-CSRF-TOKEN", '{{ csrf_token() }}'); 

            req.send(JSON.stringify(data));


            req.onreadystatechange = function() {
                if (req.readyState === 4) {
                    if (req.status === 200) {
                        window.open("/success", "_self");
                    } else {
                        window.open("/cancel", "_self");
                    }
                }
            };
        }
    });
});
</script>

<script>
$(document).ready(function() {
    $('.delete-order').click(function() {
        var orderId = $(this).data('id');
        if (confirm('Are you sure you want to delete this order?')) {
            $.ajax({
                url: '/destroyOrder/' + orderId,
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(response) {
                    alert('Order deleted successfully');
                    location.reload();
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
    });
});
</script>

<style type="text/css">
@font-face {
    font-family: 'Open Sans';
    font-weight: 400;
    src: local("Open Sans"), local("OpenSans"), url(https://fonts.gstatic.com/s/opensans/v13/cJZKeOuBrn4kERxqtaUH3ZBw1xU1rKptJj_0jans920.woff2) format("woff2");
    unicodeRange: U+0000-00FF, U+0131, U+0152-0153, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2212, U+2215;
}

* {
    font-family: "Open Sans", "Helvetica Neue", Helvetica, sans-serif;
    font-size: 15px;
    font-variant: normal;
    padding: 0;
    margin: 0;
}

html {
    height: 100%;
}

body {
    background: #F6F9FC;
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 100%;
}

form {
    width: 480px;
    margin: 20px 0;
}

label {
    position: relative;
    color: #6A7C94;
    font-weight: 400;
    height: 48px;
    line-height: 48px;
    margin-bottom: 10px;
    display: flex;
    flex-direction: row;
}

label>span {
    width: 115px;
}

.field {
    background: white;
    box-sizing: border-box;
    font-weight: 400;
    border: 1px solid #CFD7DF;
    border-radius: 2px;
    color: #32315E;
    outline: none;
    flex: 1;
    height: 48px;
    line-height: 48px;
    padding: 0 20px;
    cursor: text;
}

.field::-webkit-input-placeholder {
    color: #CFD7DF;
}

.field::-moz-placeholder {
    color: #CFD7DF;
}

.field:focus,
.field.StripeElement--focus {
    border-color: #F99A52;
}

.payment {
    float: left;
    display: block;
    background-color: black;
    color: white;
    border-radius: 24px;
    border: 0;
    margin-top: 20px;
    font-size: 17px;
    font-weight: 500;
    width: 100%;
    height: 48px;
    line-height: 48px;
    outline: none;
}

.payment:focus {
    background: #EF8C41;
}

.payment:active {
    background: #E17422;
}

.outcome {
    float: left;
    width: 100%;
    padding-top: 8px;
    min-height: 20px;
    text-align: center;
}

.success,
.error {
    display: none;
    font-size: 15px;
}

.success.visible,
.error.visible {
    display: inline;
}

.error {
    color: #E4584C;
}

.success {
    color: green;
    font-size: 20px;
}

.success .token {
    font-weight: 500;
    font-size: 20px;
}

.fa {
    margin-left: -12px;
    margin-right: 8px;
}
</style>