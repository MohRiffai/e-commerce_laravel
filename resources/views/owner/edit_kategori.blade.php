<div class="modal-header">
    <h5 class="modal-title">Edit Kategori</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<form method="post" action="{{ route('kategori.update', $edit->name) }}">
    @csrf
    @method('PUT')
    <div class="modal-body">
        <div class="form-group mt-3">
            <label for="">Nama Kategori</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror"
                value="{{ $edit->name }}" name="name" id="name" placeholder="">
            @error('name')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <input type="hidden" name="id" value="{{ $edit->id }}">
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success">Save</button>
    </div>
</form>

