<div class="d-none d-lg-block">
    <div class="row">
        @foreach($produk as $r)
        <div class="col-sm-3 mb-3 d-none d-lg-block">
            <div class="card-product">
                <a href="{{ url('produk/'.$r->id) }}" class="text-produk">
                    <img src="{{ asset('storage/gambar/' . $r->gambar) }}" class="img-fluid w-100">
                </a>
                <div class="clearfix mb-3"></div>
                <a href="{{ url('produk/'.$r->id) }}" class="text-produk">{{ $r->nama_produk }}</a>
                <h5 class="text-produk mt-1">Rp{{number_format($r->harga_jual)}},-</h5>
                <div class="clearfix"></div>
            </div>  
        </div>  
        @endforeach
    </div>
</div>