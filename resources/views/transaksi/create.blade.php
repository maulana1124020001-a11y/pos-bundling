@extends('layouts.app')

@section('content')
<div class="container-fluid px-2 px-md-4">
    <div class="row">
        
        <!-- ================================================================== -->
        <!-- KIRI: ETALASE MENU (Menampilkan 4 Kolom Menu di Layar Komputer Lebar)-->
        <!-- ================================================================== -->
        <div class="col-12 col-lg-7 mb-4">
            
            <!-- FORM PENCARIAN & FILTER KATEGORI -->
            <div class="row row-cols-1 row-cols-sm-2 g-2 mb-3">
                <div class="col mb-2 mb-sm-0">
                    <input type="text" id="search" class="form-control" placeholder="Cari menu...">
                </div>
                <div class="col">
                    <select id="filter-kategori" class="form-control">
                        <option value="">Semua Kategori</option>
                        @foreach($kategoris as $k)
                            <option value="{{ strtolower($k->nama_kategori) }}">{{ $k->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- GRID DAFTAR MENU -->
            <!-- row-cols-xl-4 memastikan menu terbagi rapi menjadi 4 kolom di resolusi pc/komputer besar -->
            <div class="row row-cols-2 row-cols-sm-3 row-cols-md-3 row-cols-xl-4 g-2" id="menu-wrapper">
                @foreach($menus as $menu)
                <div class="col mb-3 menu-item-target">
                    
                    <!-- Class 'btn-add' disematkan di sini agar bisa ditangkap oleh click event di transaksi.js -->
                    <div class="card h-100 shadow-sm border-0 menu-card btn-add position-relative" style="cursor:pointer"
                        data-id="{{ $menu->id }}" 
                        data-nama="{{ $menu->nama }}"
                        data-kategori="{{ strtolower($menu->kategori->nama_kategori ?? '') }}" 
                        data-harga="{{ $menu->harga_diskon }}">

                        <!-- LABEL PANDUAN DISKON -->
                        @if($menu->ada_diskon)
                        <span class="badge badge-danger position-absolute" style="top:8px; left:8px; z-index:5; font-size: 75%;">
                            Diskon {{ $menu->diskon->tipe_diskon == 'Persen' ? $menu->diskon->diskon_persen . '%' : 'Rp ' . number_format($menu->diskon->diskon_nominal) }}
                        </span>
                        @endif

                        <!-- GAMBAR PRODUK -->
                        <img src="{{ asset('images/' . $menu->gambar) }}" class="card-img-top" style="height:110px; object-fit:cover;">

                        <!-- DETAIL TEKS MENU -->
                        <div class="card-body p-2 text-center d-flex flex-column justify-content-between" style="min-height: 90px;">
                            <span class="font-weight-bold d-block text-truncate small mb-1" title="{{ $menu->nama }}">{{ $menu->nama }}</span>
                            <div>
                                @if($menu->ada_diskon)
                                    <div class="text-muted" style="font-size: 75%;"><del>Rp {{ number_format($menu->harga) }}</del></div>
                                    <span class="text-danger font-weight-bold small">Rp {{ number_format($menu->harga_diskon) }}</span>
                                @else
                                    <span class="text-success font-weight-bold small">Rp {{ number_format($menu->harga) }}</span>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- ================================================================== -->
        <!-- KANAN: PANEL KERANJANG BELANJA & FORM PEMBAYARAN                  -->
        <!-- ================================================================== -->
        <div class="col-12 col-lg-5 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white p-3">
                    <h5 class="mb-0 font-weight-bold">Keranjang</h5>
                </div>

                <form action="{{ route('transaksi.store') }}" method="POST" id="form-transaksi">
                    @csrf
                    <!-- Data JSON belanjaan dari array cart akan disimpan ke input hidden ini saat submit -->
                    <input type="hidden" name="menu" id="menu">

                    <div class="card-body p-2 p-md-3">
                        <!-- TABEL DAFTAR BELANJA -->
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm mb-0 text-center">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="text-left">Menu</th>
                                        <th style="width: 25%">Qty</th>
                                        <th>Subtotal</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <!-- Elemen tbody ini akan diisi baris belanjaan secara dinamis oleh renderCart() -->
                                <tbody id="cart-table"></tbody>
                            </table>
                        </div>
                    </div>

                    <!-- FORM RINCIAN PEMBAYARAN -->
                    <div class="card-footer bg-white p-3 border-top-0">
                        <div class="form-group mb-2">
                            <label class="small font-weight-bold mb-1">Total Harga</label>
                            <input type="number" name="total_harga" id="total_harga" class="form-control form-control-lg font-weight-bold text-danger" value="0" readonly>
                        </div>

                        <div class="row row-cols-2 g-2">
                            <div class="col form-group mb-2">
                                <label class="small font-weight-bold mb-1">Uang Bayar</label>
                                <input type="number" name="uang_bayar" id="uang_bayar" class="form-control" required>
                            </div>
                            <div class="col form-group mb-2">
                                <label class="small font-weight-bold mb-1">Kembalian</label>
                                <input type="number" id="kembalian" class="form-control" value="0" readonly>
                            </div>
                        </div>

                        <div class="row row-cols-2 g-2 mb-3">
                            <div class="col form-group mb-0">
                                <label class="small font-weight-bold mb-1">Metode</label>
                                <select name="metode_pembayaran" class="form-control">
                                    <option value="cash">Cash</option>
                                    <option value="qris">QRIS</option>
                                    <option value="transfer">Transfer</option>
                                </select>
                            </div>
                            <div class="col form-group mb-0">
                                <label class="small font-weight-bold mb-1">Customer</label>
                                <div class="input-group">
                                    <select name="customer_id" id="customer_id" class="form-control">
                                        <option value="">-- Umum --</option>
                                        @foreach ($customers as $customer)
                                            <option value="{{ $customer->id }}">{{ $customer->nama }} ({{ $customer->no_hp }})</option>
                                        @endforeach
                                    </select>
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-primary" id="btnTambahCustomer">+</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success btn-block btn-lg font-weight-bold shadow-sm">
                            PROSES TRANSAKSI
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

<!-- ================================================================== -->
<!-- MODAL POPUP: TAMBAH CUSTOMER BARU (AJAX)                          -->
<!-- ================================================================== -->
<div class="modal fade" id="modalCustomer" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-light">
                <h5 class="modal-title font-weight-bold">Tambah Customer</h5>
            </div>
            <div class="modal-body">
                <div class="form-group mb-2">
                    <label class="small font-weight-bold mb-1">Nama Customer</label>
                    <input type="text" id="inputNamaCustomer" class="form-control" placeholder="Nama">
                    <small class="text-danger d-block mt-1" id="textErrorCustomer"></small>
                </div>
                <div class="form-group mb-0">
                    <label class="small font-weight-bold mb-1">No HP</label>
                    <input type="text" id="inputNoHpCustomer" class="form-control" placeholder="No HP">
                </div>
            </div>
            <div class="modal-footer bg-light p-2">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-sm btn-success" id="btnSimpanCustomer">Simpan</button>
            </div>
        </div>
    </div>
</div>

<!-- ================================================================== -->
<!-- SCRIPT 1: LOGIKA LIVE PENCARIAN & FILTER KATEGORI                 -->
<!-- ================================================================== -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search');
    const kategoriSelect = document.getElementById('filter-kategori');

    function filterMenu() {
        let keyword = searchInput.value.toLowerCase().trim();
        let kategoriValue = kategoriSelect.value.toLowerCase().trim();
        const items = document.querySelectorAll('.menu-item-target');

        items.forEach(item => {
            const card = item.querySelector('.menu-card');
            if (!card) return;

            // Mengambil nilai data langsung dari attribute DOM elemen card menu
            let namaMenu = card.getAttribute('data-nama') ? card.getAttribute('data-nama').toLowerCase() : '';
            let kategoriMenu = card.getAttribute('data-kategori') ? card.getAttribute('data-kategori').toLowerCase() : '';

            let cocokSearch = namaMenu.includes(keyword);
            let cocokKategori = kategoriValue === '' || kategoriMenu === kategoriValue;

            // Atur tampilan card menu berdasarkan hasil filter pencarian
            if (cocokSearch && cocokKategori) {
                item.style.setProperty('display', 'block', 'important');
            } else {
                item.style.setProperty('display', 'none', 'important');
            }
        });
    }

    if (searchInput) { searchInput.addEventListener('keyup', filterMenu); }
    if (kategoriSelect) { kategoriSelect.addEventListener('change', filterMenu); }
});
</script>

<!-- ================================================================== -->
<!-- SCRIPT 2: LOGIKA ASYNC LIVE ASYNC POPUP SIMPAN CUSTOMER            -->
<!-- ================================================================== -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    let tombolTambah = document.getElementById('btnTambahCustomer');
    let tombolSimpan = document.getElementById('btnSimpanCustomer');
    let inputNama = document.getElementById('inputNamaCustomer');
    let inputNohp = document.getElementById('inputNoHpCustomer');
    let textError = document.getElementById('textErrorCustomer');
    let selectCustomer = document.getElementById('customer_id');

    tombolTambah.addEventListener('click', function() {
        inputNama.value = ''; inputNohp.value = ''; textError.innerText = '';
        $('#modalCustomer').modal('show');
    });

    tombolSimpan.addEventListener('click', function() {
        let namaCustomer = inputNama.value.trim();
        let noHpCustomer = inputNohp.value.trim();

        if (namaCustomer == '') {
            textError.innerText = 'Nama customer wajib diisi';
            return;
        }

        fetch('/customer/store-ajax', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ nama: namaCustomer, no_hp: noHpCustomer })
        })
        .then(response => response.json())
        .then(data => {
            let optionBaru = new Option(data.nama, data.id);
            selectCustomer.add(optionBaru);
            selectCustomer.value = data.id;
            tombolSimpan.blur();
            $('#modalCustomer').modal('hide');
        })
        .catch(error => console.log(error));
    });
});
</script>

<!-- Memuat aset script transaksi utama setelah seluruh kerangka HTML siap -->
<script src="{{ asset('js/transaksi.js') }}"></script>
@endsection