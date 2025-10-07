@extends('layouts.frontend_ecommerce')
@section('content')

<!-- carausel -->
<div id="carouselId" class="carousel slide" data-bs-ride="carousel">
    <ol class="carousel-indicators">
        <li data-bs-target="#carouselId" data-bs-slide-to="0" class="active"></li>
        <li data-bs-target="#carouselId" data-bs-slide-to="1"></li>
    </ol>
    <div class="carousel-inner" role="listbox">
        <div class="carousel-item active">
            <img src="gambarsidebar/banner1.png" class="img-fluid w-100" id="gambar_slider" alt="First slide">
        </div>
        <div class="carousel-item">
            <img src="gambarsidebar/banner2.png" class="img-fluid w-100" id="gambar_slider" alt="Second slide">
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselId" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselId" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>
<div class="container mt-5">
    <div class="row">
        <div class="col-sm-15 mx-auto">
            <!--product -->
            <div>
                <h4 class="mb-4"><b>Produk Kami</b></h4>
                @include('ecommerce.produk_list')
            </div>
            {{-- {{ $produk->links() }} --}}
            <div class="pagination-links mt-4 d-flex justify-content-center">
                {{ $produk->links('pagination::bootstrap-4') }}
            </div>
            <!-- end product -->
            {{-- <div class="official mt-3">
                <div class="row">
                    <div class="official-content">
                        <h4><b>Zulaikha Frozen Food</b></h4>
                        <p>Kami adalah toko frozen food dengan berbagai variant produk halal yang berkualitas. Terus berkembang untuk memberikan pilihan terbaik bagi Anda</p>
                    </div>
                    <div class="col-sm-7">
                        <div class="official-content">
                            <h4><b>Toko Zulaikha</b></h4>
                            <p>Kami adalah toko frozen food dengan berbagai variant produk halal yang berkualitas. Terus berkembang untuk memberikan pilihan terbaik bagi Anda</p>
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <img src="{{ asset('assets/img/offline_store.jpeg') }}" class="img-fluid w-100">
                    </div>
                </div>
            </div> --}}
        </div>
    </div>
</div>
@endsection
@section('javascript')

@endsection