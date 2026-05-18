// =====================================
// GLOBAL
// =====================================
let cart = [];
let csrfToken = '';


// =====================================
// DOM READY
// =====================================
document.addEventListener('DOMContentLoaded', function () {

    // ambil csrf token
    csrfToken =
        document.querySelector('meta[name="csrf-token"]')
            ?.getAttribute('content') || '';

    console.log('csrf = ', csrfToken);


    // =================================
    // KLIK MENU -> MASUK KERANJANG
    // =================================
    // document.querySelectorAll('.btn-add-to-cart') berfungsi untuk memilih semua elemen dengan kelas .btn-add-to-cart, yang merupakan tombol untuk menambahkan menu ke keranjang.
    document.querySelectorAll('.btn-add-to-cart').forEach(card => {

        //berfungsi untuk menambahkan event listener pada setiap tombol .btn-add-to-cart yang telah dipilih sebelumnya. Event listener ini akan mengeksekusi fungsi setiap kali tombol diklik.
        card.addEventListener('click', function () {

            //mengambil data atribut id, nama, dan harga dari tombol yang diklik. Data ini digunakan untuk membuat item baru yang akan ditambahkan ke dalam cart.
            let id = this.dataset.id;
            let nama = this.dataset.nama;
            let harga = parseInt(this.dataset.harga);

            let item = cart.find(add => add.menu_id == id); //mencari apakah menu sudah ada di cart

            // jika sudah ada, jumlah ditambah 1
            if (item) {
                item.jumlah++;

                // jika belum ada, buat item baru
            } else {
                // cart.push berfungsi untuk menambahkan item baru ke dalam array cart
                cart.push({
                    menu_id: id,
                    nama: nama,
                    harga: harga,
                    jumlah: 1
                });

            }
            // setelah menambahkan item ke cart, panggil fungsi renderCart untuk menampilkan isi cart di tabel
            renderCart();

        });

    });


    // =================================
    // INPUT BAYAR
    // =================================
    const uangBayar = document.getElementById('uang_bayar');
    // Event listener ini akan memanggil fungsi hitungKembalian setiap kali ada perubahan pada nilai input uang_bayar, 
    // sehingga kembalian dapat dihitung secara otomatis saat pengguna memasukkan jumlah uang yang dibayarkan.
    if (uangBayar) {
        uangBayar.addEventListener('input', hitungKembalian);
    }
    function hitungKembalian() {
        // Mengambil nilai total harga dari input dengan id total_harga dan mengonversinya menjadi integer.
        // Jika nilai tidak valid atau kosong, maka akan dianggap sebagai 0. 
        let total =
            parseInt(
                document.getElementById('total_harga').value
            ) || 0;

        let bayar =
            parseInt(
                document.getElementById('uang_bayar').value
            ) || 0;

        document.getElementById('kembalian').value =
            bayar - total;

    }

    // =================================
    // FILTER NAMA & KATEGORI
    // =================================
    const filterKategori = document.getElementById('filter-kategori');
    const searchMenu = document.getElementById('search-menu');

    filterKategori.addEventListener('change', filterMenu);
    searchMenu.addEventListener('keyup', filterMenu);

    function filterMenu() {
        let keyword = searchMenu.value.toLowerCase();
        let kategori = filterKategori.value;

        document.querySelectorAll('.menu-item')
            .forEach(item => {

                let cocokNama =
                    item.dataset.nama.includes(keyword);
                let cocokKategori =
                    // jika kategori kosong, semua cocok. Jika tidak kosong, harus sama dengan data-kategori item.
                    kategori === '' ||
                    item.dataset.kategori === kategori;

                // Jika kata kunci nama COCOK dan pilihan kategori juga COCOK
                if (cocokNama && cocokKategori) {
                    // Tampilkan item menu di layar browser
                    item.style.display = 'block';
                }
                // Jika salah satu atau kedua kondisi di atas TIDAK cocok
                else {
                    // Sembunyikan item menu dari layar browser
                    item.style.display = 'none';

                }

            });

    }

    // =================================
    // BUTTON SIMPAN CUSTOMER
    // =================================
    const btnCustomer =
        document.getElementById('btn-simpan-customer');

    if (btnCustomer) {
        btnCustomer.addEventListener('click', simpanCustomer);
    }


    const formTransaksi =
        document.getElementById('form-transaksi');

    if (formTransaksi) {

        formTransaksi.addEventListener('submit', function (e) {

            // validasi cart kosong
            if (cart.length === 0) {

                e.preventDefault();

                alert('Keranjang kosong');

                return;
            }

            // kirim cart ke hidden input
            document.getElementById('items').value =
                JSON.stringify(cart);

        });

    }

});


// =====================================
// SIMPAN CUSTOMER (AJAX)
// =====================================
function simpanCustomer() {
    // mengambil nilai dari input dengan id cust_nama dan cust_no_hp, yang merupakan nama dan nomor telepon pelanggan yang akan disimpan. 
    // Nilai ini kemudian digunakan untuk membuat data yang akan dikirim melalui AJAX ke server untuk menyimpan informasi pelanggan baru.
    let nama =
        document.getElementById('cust_nama').value;

    let no_hp =
        document.getElementById('cust_no_hp').value;

    if (!nama) {

        alert('Nama wajib diisi');

        return;
    }
    // FormData adalah objek yang digunakan untuk menyimpan pasangan kunci-nilai yang akan dikirim melalui permintaan HTTP, biasanya digunakan untuk mengirim data formulir.
    let formData = new FormData();
    // formData.append berfungsi untuk menambahkan pasangan kunci-nilai ke objek FormData. Dalam kasus ini, nama, no_hp, dan _token (CSRF token) ditambahkan ke FormData untuk dikirim ke server saat menyimpan pelanggan baru melalui AJAX.
    formData.append('nama', nama);
    formData.append('no_hp', no_hp);
    formData.append('_token', csrfToken);

    // fetch berfungsi untuk melakukan permintaan HTTP ke server. Dalam kasus ini, fetch digunakan untuk mengirim data pelanggan baru 
    //  endpoint /customer/store-ajax menggunakan metode POST. Data yang dikirim adalah objek FormData yang telah dibuat sebelumnya.
    fetch('/customer/store-ajax', {

        method: 'POST',
        // credentials: 'same-origin' berfungsi untuk memastikan bahwa cookie dan header otentikasi lainnya dikirim bersama permintaan, yang diperlukan untuk menjaga keamanan saat melakukan permintaan AJAX ke server yang sama.
        credentials: 'same-origin',
        // fungsi ini digunakan untuk mengirim data pelanggan baru ke server melalui permintaan POST. Data yang dikirim adalah objek FormData yang berisi nama, nomor telepon, dan token CSRF. Setelah permintaan berhasil, 
        //  dari server akan diproses untuk menambahkan pelanggan baru ke dalam daftar pelanggan yang tersedia di form transaksi.
        body: formData

    })
        // then(res => res.json()) berfungsi untuk mengambil respons dari server setelah permintaan AJAX berhasil dan mengonversinya menjadi format JSON.
        .then(res => res.json())
        // then(data => { ... }) berfungsi untuk menangani data yang telah dikonversi menjadi JSON setelah respons dari server diterima. Dalam konteks ini, data yang diterima biasanya berisi informasi tentang pelanggan baru yang telah disimpan, seperti id, nama, dan nomor telepon. 
        // Data ini kemudian digunakan untuk memperbarui daftar pelanggan di form transaksi tanpa perlu memuat ulang halaman.
        .then(data => {
            // maksudnya adalah untuk menambahkan opsi baru ke dalam elemen select dengan id customer_id, yang merupakan dropdown untuk memilih pelanggan. 
            // Opsi baru ini akan berisi nama pelanggan yang baru saja disimpan, dan jika nomor telepon tersedia, itu juga akan ditampilkan di dalam tanda kurung. 
            // Setelah opsi ditambahkan, input untuk nama dan nomor telepon akan direset, modal akan ditutup, dan pesan sukses akan ditampilkan.
            let select =
                // 
                document.getElementById('customer_id');
            // Option adalah konstruktor yang digunakan untuk membuat elemen opsi baru dalam dropdown. Dalam kasus ini, 
            // opsi baru dibuat dengan teks yang berisi nama pelanggan dan nomor telepon (jika tersedia), 
            // nilai yang berisi id pelanggan, dan atribut selected yang diatur ke true untuk langsung memilih opsi tersebut setelah ditambahkan ke dropdown.   
            let option = new Option(
                // teks opsi akan menampilkan nama pelanggan dan nomor telepon (jika tersedia). Jika nomor telepon tidak tersedia, hanya nama pelanggan yang akan ditampilkan.
                data.nama +
                (data.no_hp ? ' (' + data.no_hp + ')' : ''),
                // nilai opsi akan diisi dengan id pelanggan yang baru saja disimpan, 
                // sehingga ketika opsi ini dipilih, id pelanggan dapat digunakan untuk mengidentifikasi pelanggan tersebut dalam transaksi.
                data.id,

                true,

                true
            );
            // fungsi select.append(option) digunakan untuk menambahkan opsi baru yang telah dibuat ke dalam elemen select dengan id customer_id.c
            select.append(option);


            document.getElementById('cust_nama').value = '';
            document.getElementById('cust_no_hp').value = '';

            // tutup modal
            $('#modalCustomer').modal('hide');

            alert('Customer berhasil ditambah');

        })

        .catch(err => {

            console.log(err);

            alert('Gagal simpan customer');

        });

}


// =====================================
// RENDER CART
// =====================================
function renderCart() {
    // document.getElementById('cart-table') berfungsi untuk memilih elemen dengan id cart-table, yang merupakan tbody dari tabel keranjang belanja. 
    // Elemen ini akan digunakan untuk menampilkan daftar item yang ada di cart beserta subtotal dan tombol hapusnya.
    let tbody =
        document.getElementById('cart-table');
    // variabel total digunakan untuk menyimpan total harga dari semua item yang ada di cart. Nilai awalnya diatur ke 0.
    let total = 0;
    // tbody.innerHTML = ''; berfungsi untuk mengosongkan isi dari tbody sebelum menambahkan item-item baru dari cart. 
    // Hal ini dilakukan agar setiap kali renderCart dipanggil, daftar item yang ditampilkan selalu diperbarui sesuai dengan isi cart saat ini.
    tbody.innerHTML = '';
    // cart.forEach berfungsi untuk melakukan iterasi atau perulangan pada setiap item yang ada di array cart.
    cart.forEach((item, index) => {
        // subtotal dihitung dengan mengalikan harga item dengan jumlah item yang ada di cart. Nilai subtotal ini kemudian ditambahkan ke total untuk mendapatkan total harga keseluruhan dari semua item di cart.
        let subtotal = item.harga * item.jumlah;

        total += subtotal;

        tbody.innerHTML += `
            <tr>
           
                <td>${item.nama}</td>
                
                <td>
                    <input
                        type="number"
                        min="1"
                        value="${item.jumlah}"
                        class="form-control form-control-sm"
                        
                        onchange="updateQty(${index}, this.value)">
                </td>

                <td>
                //
                    Rp ${subtotal.toLocaleString()}
                </td>

                <td>
                    <button
                        type="button"
                        class="btn btn-danger btn-sm"
                        onclick="removeItem(${index})">

                        x

                    </button>
                </td>

            </tr>
        `;

    });

    // update total
    document.getElementById('total_harga').value = total;

    // hitung kembalian
    hitungKembalian();

}


// =====================================
// UPDATE QTY
// =====================================
function updateQty(index, qty) {

    cart[index].jumlah = parseInt(qty);

    renderCart();

}


// =====================================
// REMOVE ITEM
// =====================================
function removeItem(index) {

    cart.splice(index, 1);

    renderCart();

}


// =====================================
// HITUNG KEMBALIAN
// =====================================



// =====================================
// FILTER MENU
// =====================================
