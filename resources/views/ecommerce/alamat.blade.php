@extends('layouts.frontend_ecommerce')
@section('content')
    <div class="container mt-5">
        <h2>Masukkan Alamat</h2>
        <p class="text-danger">(*Pastikan alamat anda benar!)</p>
        <form action="{{ route('simpan.alamat') }}" method="POST">
            @csrf
            <input type="hidden" name="riwayat_transaksi_id" value="{{ $riwayatTransaksi->id }}">
            <div class="form-group mt-3">
                <label for="street">Jalan</label> <p class="text-danger">(*isi nama jalan, nama kelurahan, nama kecamatan*)</p>
                <input type="text" class="form-control @error('street') is-invalid @enderror" name="street" id="street" required value="{{ old('street') }}">
                @error('street')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group mt-3">
                <label for="destination">Kota Tujuan</label>
                <select class="form-select" name="destination" id="destination" required>
                    <option value="">Pilih Kota</option>
                    @foreach ($cities as $city)
                        <option value="{{ $city['city_id'] }}">{{ $city['city_name'] }}</option>
                    @endforeach
                </select>
                @error('destination')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group mt-3">
                <label for="courier">Jasa Pengiriman</label>
                <select class="form-select" name="courier" id="courier" required>
                    <option value="">Pilih Kurir</option>
                    <option value="jne">JNE</option>
                    <option value="pos">POS</option>
                    <option value="tiki">TIKI</option>
                </select>
                @error('courier')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-success btn-md mt-4">Simpan Alamat</button>
        </form>
    </div>
@endsection
