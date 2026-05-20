@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="row">

      
        <!-- KIRI = KERANJANG -->
       
        <div class="col-md-5">
            <div class="card shadow">

                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        Keranjang
                    </h5>
                </div>

                <!-- FORM TRANSAKSI -->             
                <form action="{{ route('transaksi.store') }}"method="POST"id="form-transaksi">
                    @csrf
                    <!-- TEMPAT JSON CART -->
                    <input type="hidden"name="menu"id="menu">

                    <div class="card-body">
  
                        <!-- =====================================
                            TABLE CART
                        ====================================== -->
                        <table class="table table-bordered">
                            <thead>

                                <tr>
                                    <th>Menu</th>
                                    <th>Jumlah</th>
                                    <th>Subtotal</th>
                                    <th>Hapus</th>
                                </tr>

                            </thead>

                            <tbody id="cart-table">

                            </tbody>

                        </table>

                    </div>

                    <!-- =====================================
                        FOOTER
                    ====================================== -->
                    <div class="card-footer">

                        <!-- TOTAL -->
                        <div class="form-group mb-3">

                            <label>Total Harga</label>

                            <input type="number" name="total_harga" id="total_harga" class="form-control" value="0" readonly >

                        </div>

                        <!-- UANG BAYAR -->
                        <div class="form-group mb-3">

                            <label>Uang Bayar</label>

                            <input type="number" name="uang_bayar"  id="uang_bayar" class="form-control" required>

                        </div>

                        <!-- KEMBALIAN -->
                        <div class="form-group mb-3">

                            <label>Kembalian </label>

                            <input  type="number" id="kembalian" class="form-control" value="0" readonly>

                        </div>

                        <!-- METODE PEMBAYARAN -->
                        <div class="form-group mb-3">

                            <label>Metode Pembayaran</label>

                            <select name="metode_pembayaran" class="form-control">

                                <option value="cash">Cash</option>

                                <option value="qris">QRIS</option>

                                <option value="transfer">  Transfer </option>

                            </select>

                        </div>
                        
                        <!-- CUSTOMER -->
                        <div class="form-group mb-3">

                            <label>Customer</label>

                            <div class="input-group">

                                <!-- SELECT CUSTOMER -->
                                <select name="customer_id" id="customer_id" class="form-control">

                                    <option value=""> -- umum -- </option>

                                    @foreach ($customers as $customer)

                                        <option value="{{ $customer->id }}">

                                            {{ $customer->nama }}
                                            {{ $customer->no_hp }}

                                        </option>

                                    @endforeach

                                </select>

                                <!-- BUTTON TAMBAH CUSTOMER -->
                                <button type="button"class="btn btn-primary" id="btnTambahCustomer" >
                                    +
                                </button>

                            </div>

                        </div>

                        <!-- BUTTON SUBMIT -->
                        <button type="submit" class="btn btn-success btn-block" >
                            PROSES TRANSAKSI
                        </button>

                    </div>

                </form>

            </div>

        </div>

       
        <!-- KANAN = MENU -->
        
        <div class="col-md-7" >

            <div class="row">

                @foreach($menus as $menu)

                <div class="col-md-4 mb-3">

                    <!-- CARD MENU -->
                    <div class="card shadow btn-add h-100" style="cursor:pointer"
                        data-id="{{ $menu->id }}"
                        data-nama="{{ $menu->nama }}"
                        data-harga="{{ $menu->harga_diskon }}" >

                        <!-- GAMBAR -->
                        <img src="{{ asset('images/' . $menu->gambar) }}" class="card-img-top" style="height:150px;">

                        <!-- BODY -->
                        <div class="card-body text-center"style="min-height:100px;" >

                            <!-- NAMA MENU -->
                            <h6> {{ $menu->nama }} </h6>

                            <!-- JIKA ADA DISKON -->
                            @if($menu->ada_diskon)

                                <small class="badge badge-success">

                                    <del> Rp {{ number_format($menu->harga) }} </del>

                                </small>

                                <br>
                                <small class="text-danger">

                                    Diskon

                                    @if($menu->diskon->tipe_diskon == 'Persen')

                                        {{ $menu->diskon->diskon_persen }}%

                                    @else

                                        Rp {{ number_format($menu->diskon->diskon_nominal) }}

                                    @endif

                                </small>
                                <br>

                                <span class="badge badge-danger">

                                    Rp {{ number_format($menu->harga_diskon) }}

                                </span>

                            @else

                                <!-- JIKA TIDAK ADA DISKON -->
                                <span class="badge badge-success">

                                    Rp {{ number_format($menu->harga) }}

                                </span>

                            @endif

                        </div>

                    </div>

                </div>

                @endforeach

            </div>

        </div>

    </div>

</div>




<!-- MODAL TAMBAH CUSTOMER -->

<div class="modal fade" id="modalCustomer">

    <div class="modal-dialog">

        <div class="modal-content">

            <!-- HEADER -->
            <div class="modal-header">

                <h5 class="modal-title"> Tambah Customer </h5>

            </div>

            <!-- BODY -->
            <div class="modal-body">

                <label class="mb-1">Nama Customer </label>

                <!-- INPUT NAMA -->
                <input 
                    type="text"id="inputNamaCustomer"
                    class="form-control" placeholder="Masukkan nama customer" >

                <!-- ERROR -->
                <small 
                    class="text-danger"
                    id="textErrorCustomer"
                >
                </small>

                <label class="mb-1"> No Hp </label>
                <input 
                    type="text"
                    id="inputNoHpCustomer"
                    class="form-control"
                    placeholder="Masukkan no hp customer">

            </div>



            <!-- FOOTER -->
            <div class="modal-footer">

                <!-- BUTTON BATAL -->
                <button 
                    type="button"
                    class="btn btn-secondary"
                    data-dismiss="modal"
                >
                    Batal
                </button>



                <!-- BUTTON SIMPAN -->
                <button 
                    type="button"
                    class="btn btn-success"
                    id="btnSimpanCustomer"
                >
                    Simpan
                </button>

            </div>

        </div>

    </div>

</div>





<!-- =====================================
    AJAX CUSTOMER
===================================== -->
<script>

document.addEventListener('DOMContentLoaded', function () {

    // =====================================
    // ELEMENT HTML
    // =====================================

    let tombolTambah =
        document.getElementById('btnTambahCustomer');

    let tombolSimpan =
        document.getElementById('btnSimpanCustomer');

    let inputNama =
        document.getElementById('inputNamaCustomer');
    
        let inputNohp = 
        document.getElementById('inputNoHpCustomer');

    let textError =
        document.getElementById('textErrorCustomer');

    let selectCustomer =
        document.getElementById('customer_id');



    // =====================================
    // BUKA MODAL
    // =====================================

    tombolTambah.addEventListener('click', function () {

        // kosongkan input
        inputNama.value = '';
            inputNohp.value = '';

        // kosongkan error
        textError.innerText = '';

        // buka modal bootstrap
        $('#modalCustomer').modal('show');

    });





    // =====================================
    // SIMPAN CUSTOMER
    // =====================================

    tombolSimpan.addEventListener('click', function () {

        // ambil nama customer
        let namaCustomer =
            inputNama.value;

            let noHpCustomer =
                inputNohp.value;



        // =====================================
        // VALIDASI
        // =====================================

        if (namaCustomer.trim() == '') {

            textError.innerText =
                'Nama customer wajib diisi';

            return;
        }



        // =====================================
        // FETCH AJAX
        // =====================================

        fetch('/customer/store-ajax', {

            method: 'POST',

            headers: {

                'Content-Type': 'application/json',

                'X-CSRF-TOKEN':
                    document.querySelector('meta[name="csrf-token"]').content
            },



            // data dikirim ke controller
            body: JSON.stringify({

                nama: namaCustomer
                    , no_hp: noHpCustomer

            })

        })



        // =====================================
        // RESPONSE BERHASIL
        // =====================================

        .then(response => response.json())

       .then(data => {

    // buat option baru
    let optionBaru =
        new Option(data.nama, data.id);


    // tambah ke select
    selectCustomer.add(optionBaru);

    // langsung pilih customer baru
    selectCustomer.value = data.id;



    // hilangkan fokus tombol
    tombolSimpan.blur();



    // tutup modal
    $('#modalCustomer').modal('hide');

})



        // =====================================
        // ERROR
        // =====================================

        .catch(error => {

            console.log(error);

        });

    });

});

</script>



<!-- FILE JS TRANSAKSI -->
<script src="{{ asset('js/transaksi.js') }}"></script>

@endsection