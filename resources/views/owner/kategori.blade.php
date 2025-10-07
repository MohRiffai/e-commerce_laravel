<x-app-layout>
    @section('content')
        <x-slot name="header">
            <h2 class="font-semibold text-x1 text-gray-800 leading-tight text-justify">
                {{ __('Kategori') }}
            </h2>
        </x-slot>
        <div class="container mt-5">
            {{ alertbs_form($errors) }}
            <button type="button" class="btn btn-primary btn-md mb-2" data-bs-toggle="modal" data-bs-target="#modelIdPlus">
                <i class="fas fa-plus mr-1"></i> Kategori
            </button>
            <div class="card card-rounded mt-2">
                <div class="card-header text-white bg-success">
                    <h5 class="card-title pt-2"> <i class="fas fa-database me-1"></i> Data Kategori</h5>
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
                                        placeholder="Cari Kategori..." aria-label="Search">
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="table-responsive mt-1">
                        <table class="table table-striped table-bordered" id="example1">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = $data->firstItem(); ?>
                                @forelse($data as $r)
                                    <tr>
                                        <td>{{ $no }}</td>
                                        <td>{{ $r->name }}</td>
                                        <td>{{ $r->created_at }}</td>
                                        <td>
                                            <a href="javascript:void(0)" data-id="{{ $r->id }}"
                                                class="btn btn-warning btn-sm ubah" data-bs-toggle="modal" data-bs-target="#modelIdEdit"
                                                title="Edit">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <form onsubmit="return confirm('Data ingin di hapus ?')" class='d-inline'
                                                action="{{ route('kategori.destroy', $r->id) }}" method="post">
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
                            <h5 class="modal-title">Tambah Kategori</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="post" action="{{ route('kategori.store') }}">
                            @csrf
                            <div class="modal-body">
                                <div class="form-group">
                                    <div class="form-group mt-3">
                                        <label for="">Nama Kategori</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            required value="{{ old('name') }}" name="name" id="name"
                                            placeholder="">
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success">Save</button>
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
                    url: '{{ route('kategori.edit') }}',
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
    @endsection
</x-app-layout>
