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
            <div class="d-flex" style="gap:10px;">
                <button class="subscribe-btn" onclick="window.location.href='{{ route('seller.orders') }}'">Orders</button>
                <button class="subscribe-btn" onclick="window.location.href='{{ route('seller.dashboard') }}'">Dashboard</button>
                <button class="subscribe-btn" onclick="openPopup('setting')">Settings</button>
                @if(Auth::user()->role == 'admin')
                    <button class="subscribe-btn" onclick="openPopup('mail')">Send Email</button>
                @endif    
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
                    <button class="add-new-item" onclick="openPopup('addnewitem')">Add New Item</button>
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
                    <button class="add-new-item" onclick="openPopup('addnewpost')">Add New Post</button>
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

<!-- add item model  -->
<div id="addnewitem-popup" class="popup">
    <div class="container">
        <div class="d-flex justify-between"
            style="margin-bottom:40px;border-bottom:1px solid lightgray;padding:0.8rem 1rem;">
            <h2>Add New Item</h2>
            <div><span style="font-weight: bold; cursor:pointer;" onclick="closePopup('addnewitem')">X</span></div>
        </div>
        <div class="sub-container">
            <form id="createItem" action="{{ route('item.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <label for="name">Name</label>
                <input type="text" id="name" name="name" placeholder="Name">

                <label for="images">Photo</label>
                <input type="file" name="images[]" id="images" multiple="multiple">

                <label for="category">Select Category</label>
                <select name="category_id" id="category_id">
                    <option selected disabled>Select Item</option>
                    @foreach($categories as $category)
                    <option value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach
                </select>

                <label for="item_type">Item Type</label>
                <select id="item_type" name="item_type">
                    <option selected disabled>Select Type</option>
                    <option value="for_sale">For Sale</option>
                    <option value="for_rent">For Rent</option>
                </select>

                <div id="for-sale" >
                    <label for="sale_price">Sale Price</label>
                    <input type="number" id="sale_price" name="sale_price" placeholder="Sale Price">
                </div>

                <div id="for-rent" >
                    <label for="rental_price">Rental Price Per Day</label>
                    <input type="number" id="rental_price" name="rental_price" placeholder="Rental Price">
                </div>

                <div id="for-stock" >
                    <label for="stock">Stock</label>
                    <input type="number" id="stock" name="stock" placeholder="Quantity Available">
                </div>

                <div id="description" >
                    <label for="description">Description</label>
                    <input type="text" id="description" name="description" placeholder="Description">
                </div>

                <label for="size">Fre Backup Size</label>
                <select id="size" name="size">
                    <option selected disabled>Select size</option>
                    <option value="IT44">IT 44 / US 8</option>
                    <option value="IT46">IT 46 / US 9</option>
                    <option value="IT48">IT 48 / US 10</option>
                </select>

                <button type="submit" class="apply-btn">Add Item</button>
            </form>
        </div>
    </div>
</div>

<!-- send mail popup  -->
<div id="mail-popup" class="popup">
    <div class="container">
        <div class="d-flex justify-between"
            style="margin-bottom:10px;border-bottom:1px solid lightgray;padding:0.8rem 1rem;">
            <h2>Send Mail</h2>
            <div><span style="font-weight: bold; cursor:pointer;" onclick="closePopup('mail')">X</span></div>
        </div>
        <div class="sub-container">
            <form id="sendEmail" action="{{ route('admin.sendEmail') }}" method="post" enctype="multipart/form-data">
                @csrf
                <label for="email">Email</label>
                <input type="email" name="email" required>
                <button type="submit" class="apply-btn">Send Mail</button>
            </form>

        </div>
    </div>
</div>

<!-- add post model  -->
<div id="addnewpost-popup" class="popup">
    <div class="container">
        <div class="d-flex justify-between"
            style="margin-bottom:40px;border-bottom:1px solid lightgray;padding:0.8rem 1rem;">
            <h2>Add New Post</h2>
            <div><span style="font-weight: bold; cursor:pointer;" onclick="closePopup('addnewpost')">X</span></div>
        </div>
        <div class="sub-container">
            <form id="createPost" action="{{ route('post.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <label for="post">Description</label>
                <textarea id="post" name="post" rows="3">
                </textarea>

                <label for="images">Photo</label>
                <input type="file" name="images[]" id="images" multiple="multiple">

                <label for="item">Link Sell Item</label>
                <select id="item_id" name="item_id">
                    <option selected disabled>Select Item</option>
                    @foreach($items as $item)
                    <option value="{{$item->id}}">{{$item->name}}</option>
                    @endforeach
                </select>

                <button type="submit" class="apply-btn">Add Post</button>
            </form>

        </div>
    </div>
</div>

<!-- Seller settings pop up -->
<div id="setting-popup" class="popup">
    <div class="container">
        <div class="d-flex justify-between"
            style="margin-bottom:40px;border-bottom:1px solid lightgray;padding:0.8rem 1rem;">
            <h2>Seller Settings</h2>
            <div><span style="font-weight: bold; cursor:pointer;" onclick="closePopup('setting')">X</span></div>
        </div>
        <form id="updateSettings" action="{{ route('update.seller.settings') }}" method="post">
            @csrf
            <div class="sub-container">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" placeholder="Name" value="{{$user->name}}">

                <label for="introduction">Bio</label>
                @if($user->settings && $user->settings->introduction)
                <textarea id="introduction" name="introduction" rows="3">{{ $user->settings->introduction }}</textarea>
                @else
                <textarea id="introduction" name="introduction" rows="3"></textarea>
                @endif

                <label for="profile_picture">Profile Picture</label>
                <input type="file" id="profile_picture" name="profile_picture">


                <label for="facebook_link">Facebook Link</label>
                <input type="text" id="facebook_link" name="facebook_link"
                    value="{{$user->settings->facebook_link ?? 'N/A'}}">


                <label for="youtube_link">Youtube Link</label>
                <input type="text" id="youtube_link" name="youtube_link"
                    value="{{$user->settings->youtube_link ?? 'N/A'}}">

                <label for="instagram_link">Instagram Link</label>
                <input type="text" id="instagram_link" name="instagram_link"
                    value="{{$user->settings->instagram_link ?? 'N/A'}}">

                <label for="twitter_link">Twitter Link</label>
                <input type="text" id="twitter_link" name="twitter_link"
                    value="{{$user->settings->twitter_link ?? 'N/A'}}">

                <button type="submit" class="apply-btn">Update</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')

<script>
    document.getElementById('customSearchInputSeller').addEventListener('input', function() {
        const query = this.value.toLowerCase();
        // Limit search to the items in the currently active tab
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

<!-- script for item  -->
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

<!-- script for post  -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var myForm = document.getElementById('createPost');
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

<!-- to send email  -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var myForm = document.getElementById('sendEmail');
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
                        closePopup('mail')
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

<!-- script to update settings  -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var myForm = document.getElementById('updateSettings');
        var errorAlert = document.getElementById('alert-danger');
        var errorList = document.getElementById('error-list');
        var successAlert = document.getElementById('alert-success');
        document.getElementById('images').addEventListener('change', function() {
            const fileNames = Array.from(this.files).map(file => file.name).join(', ');
            console.log('Selected files: ', fileNames); // Debugging output
            // You can display these names in a paragraph or div if you want to show them on the UI.
        });
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

<script>
    function closePopup(popupId) {
        const popup = document.getElementById(popupId + '-popup');
        if (popup) {
            popup.style.display = 'none'; 
        }
    }
</script>
@endpush