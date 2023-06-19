@extends('layout')

@section('content')
    <!-- Product List -->
    <div class="container product-list">
        <div class="row">
            <div class="col-12 col-md-12">
                <h2>Account detail</h2>
                <table class="table table-bordered">
                    <tbody>
                    <tr>
                        <th>
                            Nama
                        </th>
                        <td>
                            {{ $user->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Email
                        </th>
                        <td>
                            {{ $user->email }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            No HP
                        </th>
                        <td>
                            {{ $user->phone }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Kota
                        </th>
                        <td>
                            {{ $user->city }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Saldo
                        </th>
                        <td>
                            Rp{{ number_format($user->balance, 0) }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Terdaftar pada
                        </th>
                        <td>
                            {{ $user->created_at }}
                        </td>
                    </tr>
                    </tbody>
                </table>

                <p>
                    Untuk merubah detail akun, silahkan hubungi CS admin kami
                </p>

                <a href="{{ 'https://wa.me/' . env('CS_WA') . '?text=' . urlencode('Halo admin, saya mau ubah data') }}" class="btn btn-primary">
                    <i class="fa fa-whatsapp"></i> Chat Admin {{ env('CS_WA') }}
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-12">
                <hr/>
                <h2>Transaksi pembelian</h2>
                <table class="table table-bordered">
                    <tbody>
                    <tr>
                        <th>
                            Anda belum memiliki transaksi apapun
                        </th>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
