@extends('layout')

@section('content')
    <!-- Product List -->
    <div class="container product-list">
        <div class="row">
            <div class="col-12 col-md-12">
                <h2>Topup saldo</h2>
                <p>Dapatkan keuntungan hingga jutaan rupiah per hari dengan menjadi agen PPOB kami {{ env('BRAND_NAME') }}</p>
                <p>
                    Saldo Anda saat ini <b>Rp{{ number_format($user->balance) }}</b>
                </p>
                <hr/>

                <h5 class="mt-4">Silahkan pilih paket agen sesuai keinginan anda di bawah ini:</h5>

                <div class="list mt-4">
                    <h6 class="mt-3">AGEN PERCOBAAN</h6>
                    <ul>
                        <li>Isi/beli saldo minimal Rp.300.000 tanpa bonus</li>
                        <li>Melayani Transaksi Pulsa All Operator</li>
                    </ul>
                </div>

                <div class="list mt-4">
                    <h6 class="mt-3">AGEN BIASA</h6>
                    <ul>
                        <li>Isi/beli saldo minimal Rp.500.000</li>
                        <li class="font-weight-bold">Bonus Rp.100.000</li>
                        <li>Melayani Transaksi Pulsa All Operator dan Token Listrik</li>
                    </ul>
                </div>

                <div class="list mt-4">
                    <h6 class="mt-3">AGEN MASTER 1</h6>
                    <ul>
                        <li>Isi/beli saldo minimal Rp.1.000.000</li>
                        <li class="font-weight-bold">Bonus Rp.250.000</li>
                        <li>Melayani Transaksi Pulsa All Operator, Paket Data, Token Listrik, dan Paket Telpon</li>
                    </ul>
                </div>

                <div class="list mt-4">
                    <h6 class="mt-3">AGEN MASTER DEALER</h6>
                    <ul>
                        <li>Isi/beli saldo minimal Rp.3.000.000</li>
                        <li class="font-weight-bold">Bonus Rp.780.000</li>
                        <li>Melayani Transaksi Komplik Pulsa All Operator, Paket Data, Token Listrik, Paket Telpon, dan Ada Apk Khusus Transaksi Agen Master Dealer</li>
                    </ul>
                    <p class="font-italic mt-3">Dapatkan bonus Hp vivo Y20. Promo ini berlaku untuk bulan ini saja.</p>
                </div>

                <p class="mt-4">Bonus deposit berlaku untuk setiap pembelian saldo. Terima kasih...</p>


                <h1 class="text-center mb-4">Tambah Saldo</h1>
                <form>
                    <div class="form-group">
                        <label for="saldo">Jumlah saldo:</label>
                        <input type="number" id="saldo" name="saldo" class="form-control"
                               placeholder="Masukan hanya angka cth. 300000" required>
                    </div>
                    <div class="text-center">
                        <a href="#" class="btn btn-primary" id="submitBtn"><i class="fa fa-whatsapp"></i>  Kirim</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script>
        $(document).ready(function () {
            $('#submitBtn').click(function (e) {
                e.preventDefault(); // Prevent the default form submission

                var saldoValue = $('#saldo').val();
                if (saldoValue === '') {
                    alert('Harap masukan saldo.');
                    return;
                }

                var encodedSaldoValue = encodeURIComponent('TOPUP#' + saldoValue);
                var whatsappLink = 'https://wa.me/{{ env('CS_WA_BOT') }}?text=' + encodedSaldoValue;

                // Open the link in a new blank tab/window
                window.open(whatsappLink, '_blank');
            });
        });
    </script>
@endsection
