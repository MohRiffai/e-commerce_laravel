<?php $transactionId = request('id'); ?>
<x-app-layout>
    @section('content')
        <div class="container mt-4">
            <div class="alert alert-success">
                Transaksi berhasil!
            </div>
            <a href="{{ route('kasir.index') }}" class="btn btn-primary">Kembali ke Kasir</a>
            {{-- {{ dd($transactionId) }} --}}
            <a href="{{ route('transaksi_nota', ['id' => $transactionId]) }}" class="btn btn-primary">Cetak Nota</a>
        </div>
    @endsection
</x-app-layout>