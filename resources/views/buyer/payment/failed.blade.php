@extends('layouts.app')
@section('content')

<style>
._success {
    padding: 15%;
    width: 100%;
    text-align: center;
    margin: 40px auto;
    border-bottom: solid 4px red;
}

._success i {
    font-size: 55px;
    color: #28a745;
}

._success h2 {
    margin-bottom: 12px;
    font-size: 40px;
    font-weight: 500;
    line-height: 1.2;
    margin-top: 10px;
}

._success p {
    margin-bottom: 0px;
    font-size: 18px;
    color: #495057;
    font-weight: 500;
}
</style>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="message-box _success">
                <i class="fa fa-times-circle text-danger" aria-hidden="true"></i>
                <h2> Your payment was Unsuccessful </h2>
                <p> Please try again. </p>
            </div>
        </div>
    </div>
</div>

@endsection