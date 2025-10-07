<x-app-layout>
    @section('content')
        <x-slot name="header">
            <h2 class="font-semibold text-x1 text-gray-800 leading-tight text-justify">
                {{ __('Data Pelanggan') }}
            </h2>
        </x-slot>
        <div class="container mt-5">
            {{ alertbs_form($errors) }}
            <div class="card card-rounded mt-2">
                <div class="card-header text-white bg-success">
                    <h5 class="card-title pt-2"> <i class="fas fa-database me-1"></i> Data Pelanggan</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-4 ms-auto">
                            <form class="d-flex" action="" method="GET">
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-search"></i>
                                    </span>
                                    <input class="form-control" type="search" name="keywords" placeholder="Cari Pelanggan..."
                                        aria-label="Search">
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
                                    <th>E-mail</th>
                                    <th>Phone</th>
                                    <th>Bergabung Pada</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = $data->firstItem(); ?>
                                @forelse($data as $r)
                                    <tr>
                                        <td>{{ $no }}</td>
                                        <td>{{ $r->name }}</td>
                                        <td>{{ $r->email }}</td>
                                        <td>+62 {{ $r->phone }}</td>
                                        <td>{{ $r->created_at->format('d-m-Y') }}</td>
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
        @endsection
</x-app-layout>
