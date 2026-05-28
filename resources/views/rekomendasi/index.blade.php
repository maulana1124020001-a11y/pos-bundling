<!-- Notifikasi Sukses -->
@if(session('success'))
    <div style="color: green; margin-bottom: 15px; font-weight: bold;">
        {{ session('success') }}
    </div>
@endif

<table border="1" cellpadding="10">
    <thead>
        <tr>
            <th>No</th>
            <th>Rule</th>
            <th>Support</th>
            <th>Confidence</th>
            <th>Lift</th>
            <th>Aksi Buat Bundling</th> <!-- Tambah kolom baru -->
        </tr>
    </thead>
    <tbody>
        @foreach($associationRules as $index => $rule)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $rule['rule'] }}</td>
            <td>{{ $rule['support'] }}</td>
            <td>{{ $rule['confidence'] }}%</td>
            <td>{{ $rule['lift'] }}</td>
            <td>
                <!-- Form untuk mengirim data ke Controller -->
                <form action="{{ route('rekomendasi.simpan-bundling') }}" method="POST">
                    @csrf
                    <!-- ID Menu dikirim secara sembunyi (hidden) -->
                    <input type="hidden" name="menu_a_id" value="{{ $rule['item_a_id'] }}">
                    <input type="hidden" name="menu_b_id" value="{{ $rule['item_b_id'] }}">
                    
                    <!-- Kolom Input Nama Bundling -->
                    <input type="text" name="nama_bundling" placeholder="Masukkan nama paket..." required style="padding: 5px;">
                    
                    <button type="submit" style="background: green; color: white; padding: 5px 10px; border: none; cursor: pointer;">
                        Simpan Bundling
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>