@extends('layout')

@section('content')

    <!-- Home Slider Banner -->
    <div id="bannerCarousel" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#bannerCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#bannerCarousel" data-slide-to="1"></li>
            <li data-target="#bannerCarousel" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="{{ url('assets/topup.jpg') }}" alt="Image 1">
            </div>
            <div class="carousel-item">
                <img src="{{ url('assets/agent-pulsa.jpg') }}" alt="Image 2">
            </div>
            <div class="carousel-item">
                <img src="{{ url('assets/daftar.jpg') }}" alt="Image 3">
            </div>
        </div>
        <a class="carousel-control-prev" href="#bannerCarousel" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#bannerCarousel" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>

    <!-- Product List -->
    <div class="container product-list">
        <div class="row">
            <div class="col-6 col-md-3">
                <div class="product-card">
                    <a href="{{ url('pulsa') }}">
                        <img src="{{ url('assets/pulsa.jpeg') }}" alt="Product 1">
                        <h5>Pulsa</h5>
                    </a>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="product-card">
                    <a href="{{ url('pln-token') }}">
                        <img src="{{ url('assets/token-listrik.jpeg') }}" alt="Product 2">
                        <h5>PLN Token</h5>
                    </a>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="product-card">
                    <a href="{{ url('pln-pascabayar') }}">
                        <img src="{{ url('assets/token-pascabayar.jpeg') }}" alt="Product 3">
                        <h5>PLN Pascabayar</h5>
                    </a>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="product-card">
                    <a href="{{ url('topup') }}">
                        <img src="{{ url('assets/topup-now.png') }}" alt="Product 4">
                        <h5>Topup</h5>
                    </a>
                </div>
            </div>
        </div>
    </div>

@endsection
