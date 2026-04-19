

<h3>Edit Kategori</h3>

<form action="{{ route('kategori.update', $kategori->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label>Nama Kategori</label>
        <input type="text" name="nama_kategori" 
               value="{{ $kategori->nama_kategori }}" 
               class="form-control">
    </div>

    <button class="btn btn-success">Update</button>
</form>

