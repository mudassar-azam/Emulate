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
        <h1 style="flex:1;text-align:center;">Requests</h1>
    </div>
    <div class="order-page">
        <div class="order-items">
            @foreach($requests as $request)
            <div class="order-item">
                <div class="order-details" style="gap:10px">
                    <div class="order-description">
                        <p class="item-name">{{$request->name}}</p>
                    </div>
                </div>
                <div class="order-details" style="gap:10px">
                    <div class="order-description">
                        <p class="item-name">{{$request->email}}</p>
                    </div>
                </div>
                @if($request->status == 'pending')
                    <div class="order-status">
                        <a href="{{route('request.approve' , $request->id)}}"><button class="subscribe-btn">Approve</button></a>
                    </div>
                @else
                    <div class="order-status">
                        <button type="button" class="subscribe-btn">Approved</button>
                    </div>
                @endif
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