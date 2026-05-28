// Array global untuk menampung item di keranjang belanja
let cart = [];

// Menunggu hingga seluruh elemen DOM (HTML) selesai dimuat oleh browser
document.addEventListener('DOMContentLoaded', () => {

    // ==========================================
    // 1. FITUR: TAMBAH MENU KE KERANJANG
    // ==========================================
    // Mencari semua tombol yang memiliki class '.btn-add' dan memberikan event click
    document.querySelectorAll('.btn-add').forEach(button => {
        button.addEventListener('click', function () {
            // Mengambil data produk langsung dari atribut data HTML tombol (e.g., data-id)
            const id = this.dataset.id;
            const nama = this.dataset.nama;
            const harga = parseInt(this.dataset.harga) || 0; // Mengubah string harga menjadi angka, default 0 jika gagal

            // Cek apakah item tersebut sudah pernah dimasukkan ke keranjang sebelumnya
            const existingMenu = cart.find(item => item.id == id);

            if (existingMenu) {
                existingMenu.jumlah++; // Jika sudah ada di keranjang, cukup naikkan kuantitasnya (jumlahnya)
            } else {
                cart.push({ id, nama, harga, jumlah: 1 }); // Jika belum ada, masukkan objek produk baru ke array
            }

            // Perbarui tampilan tabel keranjang belanja
            renderCart();
        });
    });

    // ==========================================
    // 2. FITUR: INPUT & FORMATTING UANG BAYAR
    // ==========================================
    const inputBayar = document.getElementById('uang_bayar');

    // Mendengarkan setiap ketikan user pada input uang bayar
    inputBayar.addEventListener('input', function () {
        // Hapus semua karakter non-angka (\D artinya selain digit) saat user mengetik
        const angkaMurni = this.value.replace(/\D/g, '');
        
        // Format ulang angkanya menjadi format Rupiah yang rapi (e.g., 50.000)
        this.value = formatRupiah(angkaMurni);
        
        // Hitung ulang uang kembalian secara real-time
        hitungKembalian();
    });

    // ==========================================
    // 3. FITUR: VALIDASI & SUBMIT TRANSAKSI
    // ==========================================
    // Menangani form saat tombol submit ditekan
    document.getElementById('form-transaksi').addEventListener('submit', function (e) {
        // Validasi 1: Jika keranjang masih kosong, batalkan submit form
        if (cart.length === 0) {
            e.preventDefault(); // Menghentikan form agar tidak melakukan reload/kirim data
            return alert('Keranjang masih kosong!');
        }

        // Mengambil angka murni (tanpa titik format rupiah) dari total dan bayar
        const total = getAngkaMurni('total_harga');
        const bayar = getAngkaMurni('uang_bayar');

        // Validasi 2: Jika uang yang dibayarkan kurang dari total belanja, batalkan submit
        if (bayar < total) {
            e.preventDefault(); // Menghentikan form agar tidak melakukan reload/kirim data
            return alert('Uang bayar masih kurang!');
        }

        // Konversi array keranjang belanja menjadi JSON String agar bisa dibaca oleh backend (PHP/Node.js/dll)
        document.getElementById('menu').value = JSON.stringify(cart);

        // Kembalikan nilai input menjadi angka murni (menghilangkan titik) sebelum dikirim ke server/database
        document.getElementById('total_harga').value = total;
        document.getElementById('uang_bayar').value = bayar;
    });
});

// ==========================================
// FUNGSI-FUNGSI UTALITAS (HELPER FUNCTIONS)
// ==========================================

/**
 * Fungsi mengubah angka mentah menjadi format Rupiah dengan pemisah ribuan titik
 * Contoh: 50000 -> "50.000"
 */
function formatRupiah(angka) {
    if (!angka) return '0';
    return new Intl.NumberFormat('id-ID').format(angka);
}

/**
 * Fungsi mengambil nilai dari input HTML dan membersihkan titiknya menjadi angka murni kembali
 * Contoh: "50.000" -> 50000
 */
function getAngkaMurni(idElemen) {
    const nilaiInput = document.getElementById(idElemen).value;
    return parseInt(nilaiInput.replace(/\./g, '')) || 0; // Menghapus semua karakter titik global (\./g)
}

/**
 * Fungsi menghitung selisih uang kembalian secara real-time berdasarkan input bayar dikurangi total
 */
function hitungKembalian() {
    const total = getAngkaMurni('total_harga');
    const bayar = getAngkaMurni('uang_bayar');

    // Menampilkan hasil pengurangan yang sudah diformat rupiah ke input kembalian
    document.getElementById('kembalian').value = formatRupiah(bayar - total);
}

/**
 * Fungsi memperbarui kuantitas pesanan langsung dari input angka di tabel keranjang
 */
function updatejumlah(index, jumlah) {
    let jumlahBaru = parseInt(jumlah);

    // Proteksi: Jika user menginput minus, kosong, atau bukan angka (NaN), paksa kembali ke angka 1
    if (jumlahBaru < 1 || isNaN(jumlahBaru)) {
        jumlahBaru = 1;
    }

    // Perbarui jumlah pada item di index array yang sesuai
    cart[index].jumlah = jumlahBaru;
    
    // Render ulang keranjang untuk memperbarui subtotal dan total harga keseluruhan
    renderCart();
}

/**
 * Fungsi menghapus satu baris menu berdasarkan posisi index-nya di dalam array 'cart'
 */
function removemenu(index) {
    cart.splice(index, 1); // Menghapus 1 elemen pada index terpilih
    renderCart();          // Render ulang keranjang setelah data dihapus
}

/**
 * Fungsi merender ulang seluruh isi HTML tabel keranjang belanja berdasarkan data terbaru dari array 'cart'
 */
function renderCart() {
    const tbody = document.getElementById('cart-table');
    let htmlContent = '';
    let totalHarga = 0;

    // Melakukan perulangan untuk setiap item yang ada di dalam keranjang
    cart.forEach((menu, index) => {
        const subtotal = menu.jumlah * menu.harga; // Menghitung subtotal per baris menu
        totalHarga += subtotal;                   // Akumulasi subtotal ke total harga belanja

        // Menyusun baris tabel HTML menggunakan Template Literals (``)
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

    // Memasukkan tumpukan baris HTML yang telah dibuat ke dalam elemen tbody tabel
    tbody.innerHTML = htmlContent;
    
    // Menampilkan total harga yang sudah diformat Rupiah ke input 'total_harga'
    document.getElementById('total_harga').value = formatRupiah(totalHarga);

    // Setiap kali isi keranjang atau jumlahnya berubah, hitung ulang nominal kembaliannya
    hitungKembalian();
}