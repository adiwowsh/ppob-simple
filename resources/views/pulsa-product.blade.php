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
                <img src="{{ url('assets/pulsa.jpeg') }}" alt="Product Image">
                <h2>Pulsa Elektronik</h2>
                <p>Dapat dijual ke semua provider nirkable di Indonesia</p>
                <table class="table">
                    <tr>
                        <th>
                            Telkomsel
                        </th>
                    </tr>
                    <tr>
                        <th>
                            XL / Axis
                        </th>
                    </tr>
                    <tr>
                        <th>
                            Indosat
                        </th>
                    </tr>
                    <tr>
                        <th>
                            Tri (3)
                        </th>
                    </tr>
                    <tr>
                        <th>
                            Smartfren
                        </th>
                    </tr>
                </table>

                <hr/>

                <div class="form-group">
                    <label for="phone">No HP Penerima</label>
                    <input type="text" id="phone" name="phone" class="form-control" placeholder="Nomor HP Penerima" required>
                </div>
                <div class="form-group">
                    <label for="quantity">Pilih harga pulsa:</label>
                    <select id="quantity" name="quantity" class="form-control">
                        <option value="5000">5,000 (harga beli 4,200)</option>
                        <option value="10000">10,000 (harga beli 8,700)</option>
                        <option value="15000">15,000 (harga beli 12,700)</option>
                        <option value="20000">20,000 (harga beli 17,800)</option>
                        <option value="50000">50,000 (harga beli 42,000)</option>
                        <option value="100000">100,000 (harga beli 87,000)</option>
                    </select>
                </div>
                <a href="#" class="buy-btn" data-toggle="modal" data-target="#buyModal"><i class="fa fa-shopping-cart"></i> Beli Sekarang</a>
            </div>
        </div>
    </div>
@endsection
