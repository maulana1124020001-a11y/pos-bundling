// Array global untuk menampung item di keranjang belanja
let cart = [];

document.addEventListener('DOMContentLoaded', () => {

    // ==========================================
    // 1. FITUR: TAMBAH MENU KE KERANJANG
    // ==========================================
    document.querySelectorAll('.btn-add').forEach(button => {
        button.addEventListener('click', function () {
            // Mengambil data produk langsung dari atribut data HTML tombol
            const id = this.dataset.id;
            const nama = this.dataset.nama;
            const harga = parseInt(this.dataset.harga) || 0;

            // Cek apakah item tersebut sudah pernah dimasukkan ke keranjang
            const existingMenu = cart.find(item => item.id == id);

            if (existingMenu) {
                existingMenu.jumlah++; // Jika sudah ada, cukup naikkan jumlahnya
            } else {
                cart.push({ id, nama, harga, jumlah: 1 }); // Jika belum ada, buat objek baru
            }

            renderCart();
        });
    });

    // ==========================================
    // 2. FITUR: INPUT & FORMATTING UANG BAYAR
    // ==========================================
    const inputBayar = document.getElementById('uang_bayar');

    inputBayar.addEventListener('input', function () {
        // Hapus semua karakter non-angka saat user mengetik
        const angkaMurni = this.value.replace(/\D/g, '');
        // Format ulang angkanya menjadi format Rupiah yang rapi
        this.value = formatRupiah(angkaMurni);
        hitungKembalian();
    });

    // ==========================================
    // 3. FITUR: VALIDASI & SUBMIT TRANSAKSI
    // ==========================================
    document.getElementById('form-transaksi').addEventListener('submit', function (e) {
        if (cart.length === 0) {
            e.preventDefault();
            return alert('Keranjang masih kosong!');
        }

        const total = getAngkaMurni('total_harga');
        const bayar = getAngkaMurni('uang_bayar');

        if (bayar < total) {
            e.preventDefault();
            return alert('Uang bayar masih kurang!');
        }

        // Konversi array keranjang belanja menjadi JSON String untuk dikirim ke backend
        document.getElementById('menu').value = JSON.stringify(cart);

        // Kembalikan nilai input menjadi angka murni sebelum dikirim ke server/database
        document.getElementById('total_harga').value = total;
        document.getElementById('uang_bayar').value = bayar;
    });
});

// ==========================================
// FUNGSI-FUNGSI UTALITAS (HELPER FUNCTIONS)
// ==========================================

// Fungsi mengubah angka mentah menjadi format Rupiah ber-titik
function formatRupiah(angka) {
    if (!angka) return '0';
    return new Intl.NumberFormat('id-ID').format(angka);
}

// Fungsi mengambil nilai dari input HTML dan membersihkan titiknya menjadi angka murni
function getAngkaMurni(idElemen) {
    const nilaiInput = document.getElementById(idElemen).value;
    return parseInt(nilaiInput.replace(/\./g, '')) || 0;
}

// Fungsi menghitung selisih uang kembalian secara real-time
function hitungKembalian() {
    const total = getAngkaMurni('total_harga');
    const bayar = getAngkaMurni('uang_bayar');

    document.getElementById('kembalian').value = formatRupiah(bayar - total);
}

// Fungsi memperbarui jumlah pesanan langsung dari input angka di tabel
function updatejumlah(index, jumlah) {
    let jumlahBaru = parseInt(jumlah);

    // Proteksi: Jika diinput minus, kosong, atau bukan angka, paksa kembali ke angka 1
    if (jumlahBaru < 1 || isNaN(jumlahBaru)) {
        jumlahBaru = 1;
    }

    cart[index].jumlah = jumlahBaru;
    renderCart();
}

// Fungsi menghapus satu baris menu berdasarkan posisinya di array
function removemenu(index) {
    cart.splice(index, 1);
    renderCart();
}

// Fungsi merender ulang seluruh isi tabel keranjang belanja
function renderCart() {
    const tbody = document.getElementById('cart-table');
    let htmlContent = '';
    let totalHarga = 0;

    cart.forEach((menu, index) => {
        const subtotal = menu.jumlah * menu.harga;
        totalHarga += subtotal;

        // Menyusun baris tabel menggunakan Template Literals (``)
        htmlContent += `
            <tr>
                <td>${menu.nama}</td>
                <td>
                    <input type="number" min="1" value="${menu.jumlah}" 
                           onchange="updatejumlah(${index}, this.value)" class="form-control">
                </td>
                <td>${formatRupiah(subtotal)}</td>
                <td>
                    <button type="button" onclick="removemenu(${index})" class="btn btn-danger btn-sm">X</button>
                </td>
            </tr>
        `;
    });

    tbody.innerHTML = htmlContent;
    document.getElementById('total_harga').value = formatRupiah(totalHarga);

    // Setiap kali isi keranjang berubah, hitung ulang kembaliannya
    hitungKembalian();
}