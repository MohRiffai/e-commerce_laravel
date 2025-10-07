<div class="modal-header">
    <h5 class="modal-title">Edit Produk</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<form method="post" action="{{ route('produk.update', $edit->nama_produk) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="modal-body">
        <div class="form-group mt-3">
            <label for="">Nama Produk</label>
            <input type="text" class="form-control @error('nama_produk') is-invalid @enderror"
                value="{{ $edit->nama_produk }}" name="nama_produk" id="nama_produk" placeholder="">
        </div>
        <div class="form-group">
            <label for="">Kategori</label>
            <select class="form-select" name="id_kategori" required>
                @foreach ($kategori as $r)
                    <option value="{{ $r->id }}" {{ $edit->id_kategori == $r->id ? 'selected' : '' }}>
                        {{ $r->name }}
                    </option>
                @endforeach
            </select>
            @error('id_kategori')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group mt-3">
            <label for="">Berat</label>
            <input type="number" class="form-control @error('berat') is-invalid @enderror"
                value="{{ $edit->berat }}" name="berat" id="berat" placeholder="">
        </div>
        <div class="form-group mt-3">
            <label for="">Stok Online</label>
            <input type="number" class="form-control @error('stok') is-invalid @enderror"
                value="{{ $edit->stok }}" name="stok" id="stok" placeholder="">
        </div>
        <div class="form-group mt-3">
            <label for="">Stok Offline</label>
            <input type="number" class="form-control @error('stok_offline') is-invalid @enderror"
                value="{{ $edit->stok_offline }}" name="stok_offline" id="stok_offline" placeholder="">
        </div>
        <div class="form-group mt-3">
            <label for="">Deskripsi</label>
            @error('deskripsi')
                <p class="text-danger">{{ $message }}</p>
            @enderror
            <input id="deskripsi" type="hidden" name="deskripsi">
            <trix-editor input="deskripsi"></trix-editor>
        </div>
        <div class="form-group mt-3">
            <label for="">Harga jual</label>
            <input type="number" class="form-control @error('harga_jual') is-invalid @enderror"
                value="{{ $edit->harga_jual }}" name="harga_jual" id="harga_jual" placeholder="">
        </div>
        <div class="form-group mt-3">
            <label for="">Gambar <small class="text-danger ms-1">* Opsional</small></label>
            <input type="file" class="form-control @error('gambar') is-invalid @enderror" name="gambar" id="gambar" placeholder="">
            @error('gambar')
                <span class="text-danger">{{ $message }}</span>
            @enderror
            @if($edit->gambar)
                <a href="{{ asset('storage/gambar/' . $edit->gambar) }}" target="_blank">
                    <img src="{{ asset('storage/gambar/' . $edit->gambar) }}" class="img-fluid mt-3" style="width:80px;">
                </a>
            @endif
        </div>        
        <input type="hidden" value="{{ $edit->id }}" name="id">
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success">Save</button>
    </div>
</form>
<script>
    document.addEventListener('trix-file-accept', function(e) {
        e.preventDefault();
    })
</script>
<script>
    document.addEventListener("trix-initialize", function(event) {
        var trixElement = event.target;
        var content = `{!! addslashes($edit->deskripsi) !!}`; // Mengambil isi deskripsi dari variabel PHP

        trixElement.editor.loadHTML(content);
    });
</script>
