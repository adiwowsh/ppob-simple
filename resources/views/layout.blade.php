<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', env('BRAND_NAME'))</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        /* Styling for the header and footer */
        header {
            background-color: #f8f9fa;
            padding: 10px 0;
            text-align: center;
        }

        .logo {
            font-size: 20px;
            font-weight: bold;
        }

        .footer {
            background-color: #f8f9fa;
            padding: 10px 0;
            display: flex;
            justify-content: space-around;
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            z-index: 999;
        }

        .footer .icon {
            color: #333;
        }

        .footer .icon.active {
            color: blue;
        }

        /* Styling for the slide menu */
        .slide-menu {
            width: 300px;
            height: 100vh;
            background-color: #f8f9fa;
            position: fixed;
            top: 0;
            left: -300px;
            transition: left 0.3s ease;
            z-index: 9999;
        }

        .slide-menu.open {
            left: 0;
        }

        .slide-menu-content {
            padding: 20px;
        }

        .slide-menu .close-btn {
            float: right;
            font-size: 24px;
            margin-top: -10px;
            cursor: pointer;
        }

        /* Styling for the carousel */
        .carousel-item {
            height: 400px; /* Set the desired height of the carousel */
        }

        .carousel-item img {
            object-fit: cover;
            height: 100%;
            width: 100%;
        }

        /* Styling for the product list */
        .product-list {
            margin-top: 20px;
            min-height: calc(100vh - 530px); /* Adjust the height as needed */
        }

        .product-card {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 20px;
            text-align: center;
        }

        .product-card img {
            max-width: 100%;
            height: auto;
        }

        .product-card h5 {
            margin-top: 10px;
            font-size: 16px;
        }
        .product-list{
            padding-bottom: 20%;
        }
    </style>
    @yield('css','')
</head>

<body>
<!-- Header -->
<header>
    <div class="container">
        <div class="row">
            <div class="col-2">
                <button class="menu-btn"><i class="fa fa-bars"></i></button>
            </div>
            <div class="col-8">
                <h1 class="logo"><a href="{{ url('') }}">{{ env('BRAND_NAME') }}</a> </h1>
            </div>
            <div class="col-2">
                <a href="#" class="cart-btn"><i class="fa fa-shopping-cart"></i></a>
            </div>
        </div>
    </div>
</header>

<!-- Slide Menu -->
<div class="slide-menu">
    <div class="slide-menu-content">
        <a href="#" class="close-btn"><i class="fa fa-times"></i></a>
        <ul class="list-group">
            <li class="list-group-item"><a href="{{ url('') }}">Home</a></li>
            <li class="list-group-item"><a href="{{ url('pulsa') }}">Pulsa</a></li>
            <li class="list-group-item"><a href="{{ url('pln-token') }}">PLN Token</a></li>
            <li class="list-group-item"><a href="{{ url('pln-pascabayar') }}">PLN Bulanan</a></li>
            <li class="list-group-item"><a href="{{ url('topup') }}">Topup</a></li>
            <li class="list-group-item"><a href="{{ url('account') }}">Account</a></li>
            @if(Auth::check())
                <li class="list-group-item"><a href="{{ url('logout') }}">Keluar</a></li>
            @endif
        </ul>
    </div>
</div>
@yield('content')

@include('parts.footer')
