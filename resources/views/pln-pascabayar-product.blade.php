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
                <img src="{{ url('assets/token-pascabayar.jpeg') }}" alt="Product Image">
                <h2>PLN Bulanan (Pascabayar)</h2>
                <p>Detail margin keuntungan berdasarkan nilai tagihan</p>
                <table class="table">
                    <tr>
                        <th>
                            Dibawah 500,000
                        </th>
                        <td>
                            7% margin/keuntungan
                        </td>
                    </tr>
                    <tr>
                        <th>
                            500,001 - 800,000
                        </th>
                        <td>
                            8% margin/keuntungan
                        </td>
                    </tr>
                    <tr>
                        <th>
                            800,001 - 1500,000
                        </th>
                        <td>
                            9% margin/keuntungan
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Diatas 1,500,000
                        </th>
                        <td>
                            10% margin/keuntungan
                        </td>
                    </tr>
                </table>
                <p>
                    Contoh perhitungan, jika meter si budi mendapatkan tagihan sebesar Rp850,000. maka margin keuntungan Anda adalah
                </p>
                <p>
                    850000x9%=<b>Rp76,500</b>
                </p>
                <p>Saldo Anda hanya berkurang sebesar 850000-76500=<b>Rp773,500</b></p>
                <hr/>

                <p>Harap cek ulang nomor meter sebelum eksekusi pembayaran dari saldo</p>
                <div class="form-group">
                    <label for="meter">No Meter Pascabayar PLN</label>
                    <input type="text" id="meter" name="meter" class="form-control" placeholder="Nomor meter PLN" required>
                </div>
                <a href="#" class="buy-btn" data-toggle="modal" data-target="#buyModal"><i class="fa fa-shopping-cart"></i> Cek Tagihan</a>
            </div>
        </div>
    </div>
@endsection
