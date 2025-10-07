@extends('layouts.frontend_ecommerce')
@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-sm-9 mx-auto">
                <!--product -->
                <div class="product">
                    <h4 class="mb-4"><b>{{ $title }}</b></h4>
                    <div class="row">
                        <div class="col-sm-4">
                            <img src="{{ asset('storage/gambar/' . $edit->gambar) }}" class="img-fluid w-100 mb-3">
                        </div>
                        <div class="col-sm-8 detail-produk">
                            <div class="row mt-3">
                                <div class="col-sm-4"><b>Kategori</b></div>
                                <div class="col-sm-8">
                                    <a class="text-produk" href="{{ url('kategori/' . $edit->id) }}">
                                        {{ $edit->name }}
                                    </a>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-sm-4"><b>Nama Produk</b></div>
                                <div class="col-sm-8"><?= $edit->nama_produk ?></div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-sm-4"><b>Harga jual</b></div>
                                <div class="col-sm-8 text-success">
                                    <h4><b>Rp<?= number_format($edit->harga_jual) ?>,-</b></h4>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-sm-4"><b>Berat</b></div>
                                <div class="col-sm-8"><?= $edit->berat ?> Gram</div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-sm-4"><b>Stok</b></div>
                                <div class="col-sm-8">Tersisa <?= $edit->stok ?> pack</div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-sm-4"><b>Deskripsi</b></div>
                                <div class="col-sm-8"><?= $edit->deskripsi ?></div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-sm-4"><b></b></div>
                                <div class="col-sm-8">
                                    @if ($edit->stok > 0)
                                        {{-- <form action="{{ route('cart.add', $edit->id) }}" method="post" class="d-inline">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $edit->id }}">
                                            <input type="hidden" name="gambar" value="{{ asset('storage/gambar/' . $edit->gambar) }}">
                                            <input type="hidden" name="nama_produk" value="{{ $edit->nama_produk }}">
                                            <input type="hidden" name="harga_produk" value="{{ $edit->harga_jual }}">
                                            <input type="hidden" name="berat" value="{{ $edit->berat }}">
                                            <button type="submit" class="btn btn-success btn-md">
                                                <i class="fas fa-money-bill-wave"></i> Beli Sekarang
                                            </button>
                                        </form> --}}
                                        <form action="{{ route('cart.add', $edit->id) }}" method="post" class="d-inline">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $edit->id }}">
                                            <input type="hidden" name="gambar"
                                                value="{{ asset('storage/gambar/' . $edit->gambar) }}">
                                            <input type="hidden" name="nama_produk" value="{{ $edit->nama_produk }}">
                                            <input type="hidden" name="harga_produk" value="{{ $edit->harga_jual }}">
                                            <input type="hidden" name="berat" value="{{ $edit->berat }}">
                                            <input type="hidden" name="stok" value="{{ $edit->stok }}">
                                            <button type="submit" class="btn btn-success btn-md">
                                                <i class="fas fa-shopping-cart"></i> Keranjang
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-white bg-secondary px-2 py-1 rounded">Stok Kosong</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('javascript')
@endsection
