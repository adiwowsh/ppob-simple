<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ env('BRAND_NAME') }}</title>
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

        /* Styling for the register form */
        .register-form {
            margin: 20px auto;
            max-width: 400px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .register-form h2 {
            margin-bottom: 20px;
        }

        .register-form .form-group {
            margin-bottom: 20px;
        }

        .register-form .btn {
            width: 100%;
        }
        .error{
            color:red;
        }
    </style>
</head>

<body>
<!-- Header -->
<header>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="logo">{{ env('BRAND_NAME') }}</h1>
            </div>
        </div>
    </div>
</header>

<!-- Register Form -->
<div class="container">
    <div class="row">
        <div class="col-12">
            <img class="img-fluid" src="{{ url('assets/agent-pulsa.jpg') }}" alt="Image 2">
        </div>
        <div class="col-12">
            <h3>
                Dapatkan promo <b style="color:red">GRATIS</b> pendaftaran hanya untuk hari ini saja <em>(pendaftaran normal Rp350,000)</em>
            </h3>
        </div>
        <div class="col-12">
            <form class="register-form" method="POST" action="/register-post">
                @csrf
                <h2>DAFTAR</h2>
                @if($errors->has('register'))
                    <span class="error">{{ $errors->first('register') }}</span>
                    <br/>
                @endif
                <div class="form-group">
                    <label for="name">Nama</label>
                    @if($errors->has('name'))
                        <span class="error">{{ $errors->first('name') }}</span>
                    @endif
                    <input type="text" class="form-control" name="name" id="name" placeholder="Masukan nama">
                </div>
                <div class="form-group">
                    <label for="phone">No Whatsapp</label>
                    @if($errors->has('phone'))
                        <span class="error">{{ $errors->first('phone') }}</span>
                    @endif
                    <input type="text" class="form-control" name="phone" id="phone" placeholder="Masukan no wa">
                </div>
                <div class="form-group">
                    <label for="city">City</label>
                    @if($errors->has('city'))
                        <span class="error">{{ $errors->first('city') }}</span>
                    @endif
                    <input type="text" class="form-control" name="city" id="city" placeholder="Masukan kota">
                </div>
                <button type="submit" class="btn btn-primary">DAFTAR</button>
            </form>
        </div>
        <div class="col-12">
            Sudah terdaftar?
            <a href="{{ url('login') }}" class="btn btn-primary">Login</a>
            <a href="{{ url('') }}" class="btn btn-default">Kembali ke awal</a>
        </div>
    </div>
</div>

<!-- Footer -->
<footer>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <p>&copy; 2023 {{ env('BRAND_NAME') }}. All rights reserved.</p>
            </div>
        </div>
    </div>
</footer>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
