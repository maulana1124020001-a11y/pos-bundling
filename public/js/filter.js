// 1. Menunggu seluruh struktur HTML selesai dimuat oleh browser sebelum menjalankan script
document.addEventListener('DOMContentLoaded', () => {

    // 2. Mengambil elemen input pencarian dan dropdown kategori berdasarkan ID masing-masing
    const search = document.getElementById('search');
    const kategori = document.getElementById('filter-kategori');

    // 3. Membuat fungsi utama untuk menyaring (filter) menu kuliner
    function filterMenu() {

        // a. Mengambil text yang diketik user & pilihan kategori, lalu disamakan menjadi huruf kecil (lowercase)
        const keyword = search.value.toLowerCase();
        const filter = kategori.value.toLowerCase();

        // b. Menyeleksi semua elemen pembungkus menu yang ada di halaman web
        const items = document.querySelectorAll('.menu-item-target');

        // c. Melakukan perulangan (looping) untuk memeriksa satu per satu item menu
        items.forEach(item => {

            // Ambil card di dalam item untuk membaca data spesifik menu tersebut
            const card = item.querySelector('.menu-card');

            // Ambil nilai dari atribut data-nama dan data-kategori pada HTML, ubah ke huruf kecil
            const nama = card.dataset.nama.toLowerCase();
            const kategoriMenu = card.dataset.kategori.toLowerCase();

            // d. KONDISI 1: Cek apakah nama menu mengandung kata kunci yang diketik user
            const cocokSearch = nama.includes(keyword);

            // e. KONDISI 2: Cek kesesuaian kategori. 
            // Jika dropdown kosong (pilih "Semua"), maka dianggap cocok. Jika dipilih spesifik, nilainya harus sama persis.
            const cocokKategori = filter === '' || kategoriMenu === filter;

            // f. EKSEKUSI: Jika KONDISI 1 dan KONDISI 2 keduanya bernilai BENAR (true),
            // tampilkan menu tersebut. Jika salah satu saja salah, sembunyikan menunya.
            item.style.display = cocokSearch && cocokKategori ? 'block' : 'none';

        });
    }

    search.addEventListener('keyup', filterMenu); 
    kategori.addEventListener('change', filterMenu);

});