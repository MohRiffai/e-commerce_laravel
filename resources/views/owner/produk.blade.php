<x-app-layout>
    @section('content')
        {{-- Trix Editor --}}
        <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.0/dist/trix.css">
        <script type="text/javascript" src="https://unpkg.com/trix@2.0.0/dist/trix.umd.min.js"></script>
        {{-- Non aktifkan fitur upload file pada Trix Editor  --}}
        <style>
            trix-toolbar [data-trix-button-group="file-tools"] {
                display: none;
            }
        </style>
        <x-slot name="header">
            <h2 class="font-semibold text-x1 text-gray-800 leading-tight text-justify">
                {{ __('Produk') }}
            </h2>
        </x-slot>
        <div class="container mt-5">
            {{ alertbs_form($errors) }}
            <button type="button" class="btn btn-primary btn-md mb-2" data-bs-toggle="modal" data-bs-target="#modelIdPlus">
                <i class="fas fa-plus mr-1"></i> Produk
            </button>
            <div class="card card-rounded mt-2">
                <div class="card-header text-white bg-success">
                    <h5 class="card-title pt-2"> <i class="fas fa-database me-1"></i> Data Produk</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-4 ms-auto">
                            <form class="d-flex" action="" method="GET">
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-search"></i>
                                    </span>
                                    <input class="form-control" type="search" name="keywords"
                                        placeholder="Cari Produk..." aria-label="Search">
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="table-responsive mt-1">
                        <table class="table table-striped table-bordered" id="example1">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Gambar</th>
                                    <th>Nama Produk</th>
                                    <th>Berat (gram)</th>
                                    <th>Kategori</th>
                                    <th>Harga Jual</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = $data->firstItem(); ?>
                                @forelse($data as $r)
                                    <tr>
                                        <td>{{ $no }}</td>
                                        <td>
                                            <img src="{{ asset('storage/gambar/' . $r->gambar) }}" class="img-fluid"
                                                style="max-width: 80px;">
                                        </td>
                                        <td>{{ $r->nama_produk }}</td>
                                        <td>{{ $r->berat }}</td>
                                        <td>{{ $r->kategori->name }}</td>
                                        <td>{{ $r->harga_jual }}</td>
                                        <td>{{ $r->created_at }}</td>
                                        <td>
                                            <a href="javascript:void(0)" data-id="{{ $r->id }}"
                                                class="btn btn-warning btn-sm ubah" data-bs-toggle="modal"
                                                data-bs-target="#modelIdEdit" title="Edit">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <form onsubmit="return confirm('Data ingin di hapus ?')" class='d-inline'
                                                action="{{ route('produk.destroy', $r->id) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" name="submit" class="btn btn-danger btn-sm"><i
                                                        class="fa fa-times"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                    <?php $no++; ?>
                                @empty
                                    <tr>
                                        <td colspan="7"> Tidak Ada Data</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <br>
                    {{ $data->links() }}
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="modelIdPlus" data-bs-backdrop="static" tabindex="-1" role="dialog"
                aria-labelledby="modelTitleId" aria-hidden="true">
                <div class="modal-dialog modal-md" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Tambah Produk</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="post" action="{{ route('produk.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <div class="form-group">
                                    <div class="form-group mt-3">
                                        <label for="">Nama Produk</label>
                                        <input type="text"
                                            class="form-control @error('nama_produk') is-invalid @enderror" required
                                            value="{{ old('nama_produk') }}" name="nama_produk" id="nama_produk"
                                            placeholder="">
                                        @error('nama_produk')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="">Kategori</label>
                                    <select class="form-select" name="id_kategori" required>
                                        @foreach ($kategori as $r)
                                            <option value="{{ $r->id }}">{{ $r->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('id_kategori')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <div class="form-group mt-3">
                                        <label for="">Berat (gram)</label>
                                        <input type="number"
                                            class="form-control @error('berat') is-invalid @enderror" required
                                            value="{{ old('berat') }}" name="berat" id="berat"
                                            placeholder="">
                                        @error('berat')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-group mt-3">
                                        <label for="">Stok Online (pack)</label>
                                        <input type="number"
                                            class="form-control @error('stok') is-invalid @enderror" required
                                            value="{{ old('stok') }}" name="stok" id="stok"
                                            placeholder="">
                                        @error('stok')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-group mt-3">
                                        <label for="">Stok Offline (pack)</label>
                                        <input type="number"
                                            class="form-control @error('stok_offline') is-invalid @enderror" required
                                            value="{{ old('stok_offline') }}" name="stok_offline" id="stok_offline"
                                            placeholder="">
                                        @error('stok_offline')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group mt-3">
                                    <label for="">Deskripsi</label>
                                    @error('deskripsi')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                    <input id="deskripsiTambah" type="hidden" rows="5" required name="deskripsi"
                                        required name="deskripsi" placeholder="" {{ old('deskripsi') }}>
                                    <trix-editor input="deskripsiTambah"></trix-editor>
                                </div>
                                <div class="form-group mt-3">
                                    <label for="">Harga jual</label>
                                    <input type="number" class="form-control @error('harga_jual') is-invalid @enderror"
                                        required value="{{ old('harga_jual') }}" name="harga_jual" id="harga_jual"
                                        placeholder="">
                                    @error('harga_jual')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group mt-3">
                                    <label for="">Gambar</label>
                                    <input type="file" class="form-control @error('gambar') is-invalid @enderror"
                                        required value="{{ old('gambar') }}" name="gambar" id="gambar"
                                        placeholder="">
                                    @error('gambar')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success">Save</button>
                            </div>
                    </div>
                    </form>
                </div>

            </div>
        </div>
        </div>
        <div class="modal fade" id="modelIdEdit" data-bs-backdrop="static" tabindex="-1" role="dialog"
            aria-labelledby="modelTitleId" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content" id="edit-content">

                </div>
            </div>
        </div>
    @endsection
    @section('javascript')
    <script>
        $(document).ready(function(){
            $(document).on('click', '.ubah', function() {
                var id = $(this).attr('data-id');
                $('#modelIdEdit').modal('show');
                $.ajax({
                    url: '{{ route('produk.edit') }}',
                    type: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "id": id
                    },
                    timeout: 60000,
                    dataType: 'html',
                    success: function(html) {
                        $("#edit-content").html(html);
                    }
                });
            });
        });
    </script>
        <script>
            document.addEventListener('trix-file-accept', function(e) {
                e.preventDefault();
            })
        </script>
        <script>
            document.addEventListener("trix-initialize", function(event) {
                var trixElementTambah = document.getElementById('deskripsiTambah');
                var contentTambah = `{!! addslashes($data->get('deskripsi')) !!}`;
                trixElementTambah.editor.loadHTML(contentTambah);
            });
        </script>
    @endsection
</x-app-layout>
