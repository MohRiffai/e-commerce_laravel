@extends('layouts.frontend_ecommerce')
@section('content')
    <div class="d-flex justify-content-center mt-3">
        <div class="card">
            <div class="card-body text-center d-flex flex-column justify-contrnt-center align-items-center ">
                <img src="{{ asset('gambarsidebar/cek.png') }}" alt="Pembayaran Berhasil" width="150" height="150">
                <h1 class="text-success">Pembayaran Berhasil</h1>
                <p class="text-success">Terimakasih telah melakukan pembayaran</p>
                <a href="{{ route('riwayat_transaksi.index') }}" class="btn btn-primary mt-3">Lihat Transaksi</a>
            </div>
        </div>
    </div>
@endsection