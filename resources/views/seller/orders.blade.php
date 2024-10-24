@extends('layouts.app')
@section('content')
<main class="main">
    <style>
    .back-btn {
        cursor: pointer;
    }
    </style>
    <div class="d-flex" style="padding-top:1rem;">
        <div class="back-btn" onclick="goBack()">
            <i class="fa-solid fa-arrow-left"></i>
        </div>
        <h1 style="flex:1;text-align:center;">Order</h1>
    </div>
    @php 
        $total = 0;
    @endphp
    <div class="order-page">
        <!-- Order items list -->
        <div class="order-items">
            @foreach($orders as $order)
            <div class="order-item">
                <div class="order-details" style="gap:10px">
                    @php
                    $firstImage = $order->product->itemImages->first();
                    $total = $total + $order->total_payment;
                    @endphp

                    @if($firstImage)
                    <img style="height: 100px; width: 100px;" src="{{ asset('item-images/' . $firstImage->image_name) }}">
                    @else
                    <img style="height: 100px; width: 100px;" src="{{asset('default.jfif')}}" alt="Product Image">
                    @endif
                    <div class="order-description">
                        <p class="item-name">{{$order->product->name}}</p>
                        <p class="item-description">Size: {{$order->product->size}}</p>
                    </div>
                </div>
                <div class="order-status">
                    <p class="price">${{ $order->total_payment }}</p>
                    <select class="status-select">
                        <option>IN TRANSIT</option>
                        <option>WAIT</option>
                    </select>
                </div>
            </div>
            @endforeach
        </div>
    </div>


</main>
@endsection
@push('scripts')
<script>
function goBack() {
    window.history.back();
}
</script>
@endpush