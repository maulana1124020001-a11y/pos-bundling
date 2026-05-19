
// array kosong untuk menyimpan semua menu yang dipilih
let cart = [];


// Menjalankan JavaScript setelah seluruh HTML selesai dimuat browser
document.addEventListener('DOMContentLoaded', function () {

    //==============
    // TAMBAH MENU 
    //==============

   
    document.querySelectorAll('.btn-add')  // ambil semua tombol yang punya class .btn-add
        
        .forEach(card => { // ulangi semua tombol satu per satu

            card.addEventListener('click', function () {  // jalankan saat tombol diklik
              
                let id = this.dataset.id;  // ambil data-id dari tombol              
                let nama = this.dataset.nama; // ambil nama menu dari tombol               
                let harga = parseInt(this.dataset.harga);   // ambil harga lalu ubah jadi angka integer // parseInt dipakai supaya "10000" menjadi 10000                                                                          
                let menu = cart.find(datamenu => datamenu.id == id);// cari apakah menu dengan id yang sama ,sudah ada di cart atau belum
                
                if (menu) { // jika menu sudah ada di cart
                    
                    menu.jumlah++; // jumlah ditambah 1
                }
                else {                  
                    cart.push({  //jika menu belum ,maka tambahkan object baru ke array cart                   
                        id: id, // simpan id menu                      
                        nama: nama,  // simpan nama menu                    
                        harga: harga,  // simpan harga menu                     
                        jumlah: 1 // jumlah awal selalu 1
                    });

                }

                // render ulang isi cart ke tabel HTML
                renderCart();

            });

        });


    //===============
    // INPUT BAYAR
    //==============

    document.getElementById('uang_bayar')  // mengambil elemen berdasarkan id uang_bayar 
            .addEventListener('input', hitungKembalian); // addEventListener untuk menjalankan fungsi hitungKembalian saat input diubah
            

    //=============
    // SUBMIT FORM
    //=============

    document.getElementById('form-transaksi') // mengambil elemen berdasarkan id form-transaksi
        .addEventListener('submit', function () { // jalankan saat form disubmit

            document.getElementById('menu').value = JSON.stringify(cart);// ubah array cart menjadi format JSON lalu simpan ke input hidden bernama menu 
        });

});


// ======================
// RENDER CART
// ======================

function renderCart() {

    
    let tbody = document.getElementById('cart-table'); // ambil tbody tabel cart

    
    let html = ''; // variable untuk menampung isi html tabel

    let total = 0;  // total harga awal = 0

    
    cart.forEach((menu, index) => { // ulangi semua data menu di cart

        let subtotal = menu.jumlah * menu.harga;

        total += subtotal; // subtotal ditambahkan ke total

        // tambahkan baris html tabel
        html += `
            <tr>

                <td>
                    ${menu.nama}
                </td>

                <td>

                    <!-- input jumlah -->
                    <!-- jika diubah maka updatejumlah() dijalankan -->
                    <input type="number" min="1" value="${menu.jumlah}" onchange="updatejumlah(${index}, this.value)" class="form-control">

                </td>

                <td>

                    <!-- tampil subtotal -->
                    ${subtotal}

                </td>

                <td>

                    <!-- tombol hapus menu jika tombol di clik maka akan menjlankan fungsion removemenu berdasarkan index -->
                    <button type="button" onclick="removemenu(${index})" ="btn btn-danger btn-sm">
                        X
                    </button>

                </td>

            </tr>
        `;

    });

    
    tbody.innerHTML = html; // masukkan semua html ke tbody tabel

    document.getElementById('total_harga').value = total; // tampilkan total harga ke input total_harga

    hitungKembalian();   // setelah total berubah jalankan fungsi hitung kembalian 
}


// ======================
// UPDATE JUMLAH
// ======================

function updatejumlah(index, jumlah) {
  
    jumlah = parseInt(jumlah); // ubah value input menjadi integer

    // jika jumlah kosong / kurang dari 1
    if (jumlah < 1 || isNaN(jumlah)) {

        // paksa menjadi 1
        jumlah = 1;

    }

    // update jumlah menu berdasarkan index array
    cart[index].jumlah = jumlah;

    // render ulang cart
    renderCart();
}


// ======================
// HAPUS MENU
// ======================

function removemenu(index) {
    // hapus data array berdasarkan index,hapus dari index berapa dan hapus 1 data
    cart.splice(index, 1);

    // render ulang cart
    renderCart();
}


// ======================
// HITUNG KEMBALIAN
// ======================

function hitungKembalian() {

    // ambil total harga dan parseInt untuk mengubah string menjadi angka, jika kosong maka total 0
    let total = parseInt(document.getElementById('total_harga').value) || 0;

    // ambil uang bayar jika kosong maka di tampilan uang_bayar 0
    let bayar = parseInt(document.getElementById('uang_bayar').value) || 0;

    // ambil elemen berdasarkan id kembalian dan nialinya bayar - total
    document.getElementById('kembalian').value = bayar - total;
}