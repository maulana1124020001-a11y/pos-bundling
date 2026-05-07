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
    document.querySelectorAll('.btn-add-to-cart').forEach(card => {

        card.addEventListener('click', function () {

            let id = this.dataset.id;
            let nama = this.dataset.nama;
            let harga = parseInt(this.dataset.harga);

            let item = cart.find(x => x.menu_id == id);

            if (item) {

                item.jumlah++;

            } else {

                cart.push({
                    menu_id: id,
                    nama: nama,
                    harga: harga,
                    jumlah: 1
                });

            }

            renderCart();

        });

    });


    // =================================
    // INPUT BAYAR
    // =================================
    const uangBayar = document.getElementById('uang_bayar');

    if (uangBayar) {
        uangBayar.addEventListener('input', hitungKembalian);
    }


    // =================================
    // SEARCH MENU
    // =================================
    const searchMenu = document.getElementById('search-menu');

    if (searchMenu) {
        searchMenu.addEventListener('keyup', filterMenu);
    }


    // =================================
    // FILTER KATEGORI
    // =================================
    const filterKategori =
        document.getElementById('filter-kategori');

    if (filterKategori) {
        filterKategori.addEventListener('change', filterMenu);
    }


    // =================================
    // BUTTON SIMPAN CUSTOMER
    // =================================
    const btnCustomer =
        document.getElementById('btn-simpan-customer');

    if (btnCustomer) {
        btnCustomer.addEventListener('click', simpanCustomer);
    }


    // =================================
    // SUBMIT FORM TRANSAKSI
    // TANPA AJAX
    // =================================
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

    let nama =
        document.getElementById('cust_nama').value;

    let no_hp =
        document.getElementById('cust_no_hp').value;

    if (!nama) {

        alert('Nama wajib diisi');

        return;
    }

    let formData = new FormData();

    formData.append('nama', nama);
    formData.append('no_hp', no_hp);
    formData.append('_token', csrfToken);


    fetch('/customer/store-ajax', {

        method: 'POST',
        credentials: 'same-origin',
        body: formData

    })

        .then(res => res.json())

        .then(data => {

            let select =
                document.getElementById('customer_id');

            let option = new Option(

                data.nama +
                (data.no_hp ? ' (' + data.no_hp + ')' : ''),

                data.id,
                true,
                true
            );

            select.append(option);

            // reset input
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

    let tbody =
        document.getElementById('cart-table');

    let total = 0;

    tbody.innerHTML = '';

    cart.forEach((item, index) => {

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
function hitungKembalian() {

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


// =====================================
// FILTER MENU
// =====================================
function filterMenu() {

    let keyword =
        document.getElementById('search-menu')
            .value
            .toLowerCase();

    let kategori =
        document.getElementById('filter-kategori')
            .value;

    document.querySelectorAll('.menu-item')
        .forEach(item => {

            let nama = item.dataset.nama;

            let kat = item.dataset.kategori;

            let cocokNama =
                nama.includes(keyword);

            let cocokKategori =
                kategori === '' || kategori === kat;

            item.style.display =
                (cocokNama && cocokKategori)
                    ? 'block'
                    : 'none';

        });

}