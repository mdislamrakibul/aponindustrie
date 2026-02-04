@extends('layout.master')

@section('title', 'E-Commerce')


@section('content')

<style>
    .main-div {
        text-align: center;
        padding: 10px 0;
        /* background: #EBF0F5; */
    }

    .success-h1 {
        color: #88B04B;
        font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
        font-weight: 900;
        font-size: 40px;
        margin-bottom: 10px;
    }

    .error-h1 {
        color: #ed2a2a;
        font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
        font-weight: 900;
        font-size: 40px;
        margin-bottom: 10px;
    }

    p {
        color: #404F5E;
        font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
        font-size: 20px;
        margin: 0;
    }

    .checkmark {
        color: #9ABC66;
        font-size: 100px;
        line-height: 200px;
        margin-left: -15px;
    }

    .error {
        color: #ed2a2a;
        font-size: 100px;
        line-height: 200px;
        margin-left: -15px;
    }

    .card {
        background: white;
        margin-top: 10px !important;
        padding: 20px 60px;
        border-radius: 4px;
        box-shadow: 0 2px 3px #C8D0D8;
        display: inline-block;
        margin: 0 auto;
    }

    .confirm-green-box {
        width: 100%;
        height: 140px;
        background: #d7f5da;
        padding: 15px;
    }

    .confirm-red-box {
        width: 100%;
        height: 140px;
        background: #f5dfd7;
        padding: 15px;
    }
</style>
<div class="main-div">
    <div class="card">
        <div style="border-radius:200px; height:200px; width:200px; background: #F8FAF5; margin:0 auto;">
            @if ($order)
            <i class="checkmark">✓</i>
            @else
            <i class="error">x</i>
            @endif
        </div>


        @if ($order)
        <h1 class="success-h1">Success</h1>
        @else
        <h1 class="error-h1">Error</h1>
        @endif



        @if ($order)
        <div class="confirm-green-box">
            <br>
            <p>Your order <span style="font-weight: bold;font-size: 25px;">#siakdhfsa</span> has been successful!</p>
            <p>Thank you for choosing us. You will contact you shortly.</p>
        </div>
        @else
        <div class="confirm-red-box">
            <br>
            <p>We didn't find <span style="font-weight: bold;font-size: 25px;">#siakdhfsa.</span> Try Correct Order
                Number</p>
        </div>
        @endif


    </div>

</div>
@endsection
