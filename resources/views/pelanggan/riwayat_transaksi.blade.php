<x-app-layout>
    @section('content')
        <x-slot name="header">
            <h2 class="font-semibold text-x1 text-gray-800 leading-tight text-justify">
                {{ __('Riwayat Transaksi') }}
            </h2>
        </x-slot>
        <div class="container mt-5">
            {{ alertbs_form($errors) }}
            <div class="card card-rounded mt-2">
                <div class="card-header text-white bg-success">
                    <h5 class="card-title pt-2"> <i class="fas fa-database me-1"></i> Riwayat Transaksi</h5>
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
                                        placeholder="Cari Transaksi..." aria-label="Search">
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="table-responsive mt-1">
                        <table class="table table-striped table-bordered" id="example1">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nomor Order</th>
                                    <th>Nomor Invoice</th>
                                    <th>Subtotal</th>
                                    <th>Total Bayar</th>
                                    <th>Konfirmasi Owner</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = $data->firstItem(); ?>
                                @forelse($data as $r)
                                    <tr>
                                        <td>{{ $no }}</td>
                                        <input type="hidden" name="transaksi_id" value="{{ $r->id }}">
                                        <td>{{ $r->order_id }}</td>
                                        <td>{{ $r->no_invoice }}</td>
                                        <td>Rp<?= number_format($r->subtotal) ?>,-</td>
                                        <td>Rp<?= number_format($r->total) ?>,-</td>
                                        <td style="background-color: {{ $r->status_owner === 'pending' ? 'yellow' : ($r->status_owner === 'success' ? 'green' : 'white') }}; color: {{ $r->status_owner === 'success' ? 'white' : 'black' }}; text-align: center;">
                                            {{ $r->status_owner }}
                                        </td>
                                        {{-- <td>{{ $r->status_owner }}</td> --}}
                                        <td style="background-color: {{ $r->status === 'pending' ? 'yellow' : ($r->status === 'success' ? 'green' : 'white') }}; color: {{ $r->status === 'success' ? 'white' : 'black ' }}">
                                            {{ $r->status }}
                                        </td>
                                        <td>{{ $r->created_at->format('d-m-Y') }}</td>
                                        <td>
                                            <div class="text-center">
                                                @if (empty($r->alamat))
                                                    <a href="{{ route('input.alamat', $r->id) }}"
                                                        class="btn btn-primary btn-sm me-1">Lengkapi Alamat</a>
                                                @elseif (empty($r->ongkir))
                                                    <a href="{{ route('cek.ongkir', $r->id) }}"
                                                        class="btn btn-success btn-sm me-1">Cek Ongkir</a>
                                                @elseif ($r->status_transaksi == 'BELUM LUNAS')
                                                    <a href='{{ route('transaction.show', $r->id) }}' class="btn btn-primary btn-sm me-1">Bayar</a>
                                                @elseif ($r->status_transaksi == 'LUNAS')
                                                    <a href='{{ route('invoice.show', $r->id) }}' class="btn btn-primary btn-sm me-1">Lihat Invoice</a>
                                                @endif

                                                @if ($r->status_transaksi == 'BELUM LUNAS')
                                                    <form onsubmit="return confirm('Data ingin di hapus ?')"
                                                        class='d-inline' action="{{ route('transaksi.destroy', $r->id) }}"
                                                        method="post">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" name="submit"
                                                            class="btn btn-danger btn-sm"><i
                                                                class="fa fa-times"></i></button>
                                                    </form>
                                                @endif
                                            </div>
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
        </div>
    @endsection
</x-app-layout>
