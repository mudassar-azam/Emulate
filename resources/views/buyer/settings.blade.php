@extends('layouts.app')
@section('content')
<style>
.table-container {
    width: 90%;
    margin: 20px auto;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    background-color: #fff;
}

.table-header {
    display: flex;
    align-items: center;
    padding: 10px;
    background-color: #f5f5f5;
    border-bottom: 1px solid #ddd;
}

.search-wrapper {
    flex: 1;
    display: flex;
    align-items: center;
}

.search-wrapper input {
    padding: 5px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 16px;
    margin-right: 10px;
}

.view-options {
    display: flex;
    align-items: center;
}

.view-options label {
    margin-right: 10px;
    font-size: 16px;
}

.view-options select {
    padding: 5px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 16px;
}

table {
    width: 100%;
    border-collapse: collapse;
}

th,
td {
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

th {
    background-color: #f0f0f0;
    cursor: pointer;
    position: relative;
}

th i {
    margin-left: 5px;
}

td {
    max-width: 300px;
    /* Increased maximum width for better visibility of long addresses */
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

td img {
    width: 50px;
    /* Square width */
    height: 50px;
    /* Square height */
    border-radius: 5px;
    /* Square corners */
    display: block;
    margin: 0 auto;
    /* Centering the image */
}
</style>
<main class="main">
    <div class="mp-back">
        <i class="fa-solid fa-arrow-left"></i>
    </div>
    <div class="mp-menubar ">
        <i class="fa-solid fa-bars"></i>
    </div>

    <!-- fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css"
        integrity="sha512-q3eWabyZPc1XTCmF+8/LuE1ozpg5xxn7iO89yfSOd5/oKvyqLngoNGsx8jq92Y8eXJ/IRxQbEC+FGSYxtk2oiw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <div class="mp-container">
        <div class="box">

            <div class="my-box-card">

                <input type="radio" name="tab" id="home">
                <input type="radio" name="tab" checked id="blog">
                <input type="radio" name="tab" id="help">
                <input type="radio" name="tab" id="code">
                <input type="radio" name="tab" id="about">
                <div class="list">
                    <label for="home" class="home">
                        <i class="fa-regular fa-square-check"></i>
                        <span class="topic">Order History</span>
                    </label>
                    <label for="blog" class="blog">
                        <i class="fa-regular fa-user"></i>
                        <span class="topic">Profile</span>
                    </label>
                    <label for="help" class="help">
                        <i class="fa-solid fa-gear"></i>
                        <span class="topic">Setting</span>
                    </label>
                    <label for="help" class="help">
                        <i class="fas fa-sign-out-alt"></i>
                        @if(auth()->user()->role == 'buyer')
                            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="sign-in-btn rounded-btn">Logout</button>
                            </form>
                        @endif
                    </label>

                    <div class="indicator"></div>
                </div>
                <div class="content">
                    <div class="home">
                        <div style="display:flex;align-items:center;justify-content:center;">
                            <h3>Your Orders</h3>
                        </div>
                        <div class="table-container">
                            <table id="employee-table">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Size</th>
                                        <th>Lease Terms</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Total Payment</th>
                                        <th>Payment Status</th>
                                        <th>Cancel</th>
                                    </tr>
                                </thead>
                                <tbody id="table-body">
                                    @foreach($orders as $order)
                                        @php
                                            $firstImage = $order->product->itemImages->first();
                                        @endphp
                                        <tr id="row_{{ $order->id }}">
                                            <td><img style="border-radius: 50%;height:100px;width: 100px;"src="{{ asset('item-images/' . $firstImage->image_name) }}"></td>
                                            <td>{{$order->product->name}}</td>
                                            <td>{{$order->product->size}}</td>
                                            <td>{{$order->lease_term ?? '-'}}</td>
                                            <td>{{$order->start_date  ?? '-'}}</td>
                                            <td>{{$order->end_date  ?? '-'}}</td>
                                            <td>{{$order->total_payment}}$</td>
                                            <td>{{$order->payment_status}}</td>
                                            <td><button  data-id="{{ $order->id }}"style="width: 100%;margin-left:0px;" class="apply-btn delete-order">Cancel</button></td>
                                        </tr>
                                    @endforeach    
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="blog">
                        <div class="container id-001 account-details id-002">
                            <h2>Account Details</h2>
                            <hr class="divider id-003">
                            <form class="form-section id-009 updateSettings" action="{{route('buyer.update.settings')}}"
                                method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="profile-section id-004">
                                    <div class="email-section id-006">
                                        <p class="email-text id-007">Email: <span>{{Auth::user()->email}}</span></p>
                                    </div>
                                </div>

                                <div class="form-group id-010">
                                    <input type="text" name="firstname" class="form-input id-011"
                                        placeholder="FIRST NAME" value="{{ $settings ? $settings->firstname : '' }}">
                                    <input type="text" name="lastname" class="form-input id-012" placeholder="LAST NAME"
                                        value="{{ $settings ? $settings->lastname : '' }}">
                                </div>

                                <div class="form-group id-013">
                                    <input type="date" name="dob" class="form-input id-014" placeholder="DATE OF BIRTH"
                                        value="{{ $settings ? $settings->dob : '' }}">
                                    <input type="text" name="gender" class="form-input id-015" placeholder="GENDER"
                                        value="{{ $settings ? $settings->gender : '' }}">
                                </div>
                                <div class="form-group id-016">
                                    <input type="email" name="email" class="form-input id-017" placeholder="Email"
                                        value="{{ Auth::user()->email }}">
                                </div>

                                <div style="display: flex;align-items: center;justify-content: center;">
                                    <button type="submit" class="change-button id-008">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="help">
                        <div class="sub-title">
                            Help Content
                        </div>
                        <hr>
                        <div class="txt">
                            <p>
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. In commodi animi vitae vel, et
                                ratione tenetur
                                nemo voluptatem, laboriosam culpa architecto ut minima deleniti. Earum perspiciatis
                                ullam voluptates
                                consequuntur rem.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@endsection

@push('scripts')

<script>
document.querySelector('.mp-menubar').addEventListener('click', function() {
    // Toggle the left property of the list
    const list = document.querySelector('.my-box-card .list');
    if (list.style.left === '0px') {
        list.style.left = '-100%'; // Slide out
    } else {
        list.style.left = '0'; // Slide in
    }

    // Toggle the icon between the bars and "x"
    const icon = document.querySelector('.mp-menubar i');
    if (icon.classList.contains('fa-bars')) {
        icon.classList.remove('fa-bars');
        // icon.textContent = 'x';  // Change to 'x'
        icon.classList.add('fa-xmark');
    } else {
        icon.classList.add('fa-solid', 'fa-bars'); // Restore bars icon

        icon.classList.remove('fa-xmark');
    }
});
</script>

<script>
    $(document).ready(function() {
        $('.delete-order').click(function() {
            var orderId = $(this).data('id');
            if (confirm('Are you sure you want to delete this order?')) {
                $.ajax({
                    url: '/deleteOrder/' + orderId,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $('#row_' + orderId).remove();
                        toastr.success('Order deleted', 'Success', {
                            positionClass: 'toast-top-right',
                            timeOut: 3000
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            }
        });
    });
</script>
@endpush