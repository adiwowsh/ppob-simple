@extends('layout')
@section('css')
    <style>
        /* Styling for the product details */
        .product-details {
            margin-top: 20px;
            padding: 20px;
            text-align: center;
            padding-bottom:20%;
        }

        .product-details img {
            max-width: 100%;
            height: auto;
            margin-bottom: 20px;
        }

        .product-details h2 {
            margin-bottom: 10px;
        }

        .product-details p {
            margin-bottom: 20px;
        }

        .product-details .buy-btn {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border-radius: 5px;
            text-decoration: none;
        }

        .product-details .buy-btn:hover {
            background-color: #0069d9;
        }
    </style>
@endsection
@section('content')
    <!-- Product Details -->
    <div class="container product-details">
        <div class="row">
            <div class="col-12">
                <img src="{{ url('assets/token-listrik.jpeg') }}" alt="Product Image">
                <h2>PLN Token</h2>
                <p>Harap cek ulang nomor meter sebelum eksekusi pembayaran dari saldo</p>
                <hr/>

                <div class="form-group">
                    <label for="meter">No Meter PLN</label>
                    <input type="text" id="meter" name="meter" class="form-control" placeholder="Nomor meter PLN" required>
                </div>
                <div class="form-group">
                    <label for="quantity">Pilih harga Token:</label>
                    <select id="quantity" name="quantity" class="form-control">
                        <option value="20000">20,000 (harga beli 17,000)</option>
                        <option value="50000">50,000 (harga beli 39,000)</option>
                        <option value="100000">100,000 (harga beli 78,000)</option>
                        <option value="200000">200,000 (harga beli 156,000)</option>
                        <option value="500000">500,000 (harga beli 390,000)</option>
                    </select>
                </div>
                <a href="#" class="buy-btn" data-toggle="modal" data-target="#buyModal"><i class="fa fa-shopping-cart"></i> Beli Sekarang</a>
            </div>
        </div>
    </div>
@endsection
