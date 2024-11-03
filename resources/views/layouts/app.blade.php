<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Emulate - Fashion Banner</title>
    <link rel="stylesheet" href="{{asset('assets/css/header.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/product.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/cart.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/singleProduct.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/checkout.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/profile.css')}}" />
    <link rel="stylesheet" href="./assets/css/myprofile.css" />

    <link rel="stylesheet" href="{{asset('assets/css/orderDetail.css')}}" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer">
    </script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src='https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js'></script>
    <script type='text/javascript' src='https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js'>
    </script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://js.stripe.com/v3/"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>



</head>

<body>
    @include('partial.header')

    <!-- Sidebar for Cart -->
    <div class="cart-sidebar" id="cartSidebar">
        <div class="cart-header">
            <button id="closeSidebar" class="close-btn">←</button>
            <span>Shopping Cart</span>
        </div>

        <div class="cart-items">

        </div>

        <div class="cart-summary">
            <hr>
            <div class="tax">
                <small>Total ,Taxes, shipping, discounts etc to be entered at checkout</small>
            </div>
        </div>

        <form class="confirmOrderForm" action="{{route('buyer.cart.confirm.order')}}" method="post">
            @csrf
            <button class="confirmOrderButton checkout-btn" type="button">Checkout</button>
        </form>

    </div>

    @yield('content')
    @include('partial.footer')
    @stack('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
    var ctx = document.getElementById('radar_chart').getContext('2d');
    var radarChart = new Chart(ctx, {
        type: 'radar',
        data: {
            labels: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
            datasets: [{
                label: 'Traffic Sources',
                data: [500, 1000, 750, 600, 800, 700, 900],
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: '#000000',
                pointBackgroundColor: '#000000'
            }]
        },
        options: {
            scale: {
                ticks: {
                    beginAtZero: true
                }
            }
        }
    });
    </script>

    <div class="overlay" id="overlay"></div>

    <script src="{{asset('assets/js/script.js')}}"></script>



    <!-- for wishlist  -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var myForm = document.getElementById('addToWishlist');
            var errorAlert = document.getElementById('alert-danger');
            var errorList = document.getElementById('error-list');
            var successAlert = document.getElementById('alert-success');
            var wishlistPopupContainer = document.querySelector('#wishlist-popup .popup-form');

            // Fetch and display wishlist items when the page loads
            fetch('/wishlist-items', {
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        data.items.forEach(item => appendWishlistItem(item));
                    }
                })
                .catch(error => console.error('Error fetching wishlist items:', error));

            // Handle form submission (adding item)
            myForm.addEventListener('submit', function(event) {
                event.preventDefault();
                var formData = new FormData(myForm);

                fetch(myForm.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            successAlert.textContent = data.message;
                            successAlert.style.display = 'block';
                            appendWishlistItem(data.item);

                            setTimeout(function() {
                                successAlert.style.display = 'none';
                            }, 2000);

                            setTimeout(function() {
                                window.location.reload();
                            }, 1000);
                        } else {

                            toastr.error('Product already in wishlist.', 'Error', {
                                positionClass: 'toast-top-right',
                                timeOut: 3000
                            });
                        }
                    })
                    .catch(error => console.error('Error adding wishlist item:', error));
            });

            // Append new wishlist item
            function appendWishlistItem(item) {
                var newItem = document.createElement('div');
                newItem.style.display = 'flex';
                newItem.style.alignItems = 'center';
                newItem.style.justifyContent = 'center';
                newItem.style.gap = '15rem';
                newItem.style.margin = '2em 3em';
                var itemContent = `
                            <div style="display:flex;align-items: center;justify-content: center;height: 13%; gap:10px;" >
                                <div>
                                    <a href="/wishlist-product-details/${item.name}">
                                        <img style="height: 60px;width: 100px;" src="/item-images/${item.image}">
                                    </a>
                                </div>
                                <div>
                                    <span>${item.name}</span>
                                </div>
                            </div>
                            <div>
                                <button class="remove-btn" data-item-id="${item.id}">Remove</button>
                            </div>
                        `;
                newItem.innerHTML = itemContent;

                wishlistPopupContainer.appendChild(newItem);

                var removeButton = newItem.querySelector('.remove-btn');
                removeButton.addEventListener('click', function() {
                    removeWishlistItem(item.id, newItem);
                });
            }

            function removeWishlistItem(itemId, itemElement) {
                fetch('/remove-wishlist-item', {
                        method: 'POST',
                        body: JSON.stringify({
                            id: itemId
                        }),
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            setTimeout(function() {
                                window.location.reload();
                            }, 1000);
                        } else {
                            alert('Error removing item');
                        }
                    })
                    .catch(error => console.error('Error removing wishlist item:', error));
            }

            // Handle form validation errors
            function handleErrors(errors) {
                errorList.innerHTML = '';
                if (errors.length > 0) {
                    var li = document.createElement('li');
                    li.textContent = errors[0].message;
                    errorList.appendChild(li);
                    errorAlert.style.display = 'block';
                    successAlert.style.display = 'none';

                    var firstErrorField;
                    errors.forEach(function(error, index) {
                        var errorField = myForm.querySelector(`[name="${error.field}"]`);
                        if (errorField) {
                            errorField.style.border = '1px solid red';
                            if (index === 0) {
                                firstErrorField = errorField;
                            }
                        }
                    });

                    if (firstErrorField) {
                        firstErrorField.focus();
                    }

                    setTimeout(function() {
                        errorAlert.style.display = 'none';
                    }, 3000);
                }
            }
        });
    </script>
    <!-- for wishlist end  -->

    <!-- for  cart  -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetchCartItems();
        });

        function fetchCartItems() {
            fetch('{{ url("/cart/items") }}', {
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(cartItems => {
                    const cartItemsContainer = document.querySelector('.cart-items');
                    cartItemsContainer.innerHTML = '';

                    cartItems.forEach(item => {
                        let imageUrl = item.product.item_images.length > 0 ?
                            `{{ asset('item-images/') }}/${item.product.item_images[0].image_name}` :
                            'default.jfif';
                        let priceHtml = '';
                        if (item.product.item_type === 'for_rent') {
                            priceHtml = `<p><b>Rent Price Per Day $${item.product.rental_price}</b></p>`;
                        } else {
                            priceHtml = `<p>Sale Price $${item.product.sale_price}</p>`;
                        }

                        const newItem = `
                                            <div class="cart-item" id="cart-item-${item.id}">
                                                <img src="${imageUrl}" alt="Product Image">
                                                <div class="product-details">
                                                    <h4>${item.product.name}</h4>
                                                    <div class="pricing">
                                                        ${priceHtml}
                                                    </div>
                                                </div>
                                                <button class="remove-from-cart" data-cart-id="${item.id}">Remove</button>
                                            </div>
                                            <hr>
                                        `;
                        cartItemsContainer.innerHTML += newItem;
                    });

                    document.querySelectorAll('.remove-from-cart').forEach(button => {
                        button.addEventListener('click', function() {
                            let cartId = this.getAttribute('data-cart-id');
                            removeCartItem(cartId)
                            window.location.reload();
                        });
                    });
                })
                .catch(error => {
                    console.error('Error fetching cart items:', error);
                });
        }

        function removeCartItem(cartId) {
            fetch(`{{ url('cart/remove') }}/${cartId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'removed') {
                        const successAlert = document.getElementById('alert-success');
                        successAlert.textContent = data.message;
                        successAlert.classList.remove('alert-info');
                        successAlert.classList.add('alert-success');
                        successAlert.style.display = 'block';
                        setTimeout(function() {
                            successAlert.style.display = 'none';
                        }, 2000);
                        document.getElementById(`cart-item-${cartId}`).remove();
                    }
                })
                .catch(error => {
                    console.error('Error removing from cart:', error);
                });
        }
    </script>

    <!-- for  cart end  -->


    <!-- to confirm order  -->
    <script>
        document.querySelector('.confirmOrderButton').addEventListener('click', function() {
            const form = document.querySelector('.confirmOrderForm');
            const formData = new FormData(form);

            fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.href = "{{ route('buyer.checkout') }}";
                    } else {
                        window.location.reload();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    toastr.error('An error occurred while confirming the order.', 'Error', {
                        positionClass: 'toast-top-right',
                        timeOut: 5000
                    });
                });
        });
    </script>



</body>

</html>