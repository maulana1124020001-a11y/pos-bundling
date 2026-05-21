document.addEventListener('DOMContentLoaded', function() {
    // input search
    const search = document.getElementById('search');

    // select kategori
    const kategori = document.getElementById('filter-kategori');

    // semua card
    const cards = document.querySelectorAll('.menu-card');

    // function filter
    function filterMenu() {
        // ambil search
        let keyword = search.value.toLowerCase();

        // ambil kategori
        let kategoriValue = kategori.value.toLowerCase();

        // looping card
        cards.forEach(card => {
            // nama menu
            let nama = card.dataset.nama;

            // kategori menu
            let kategoriMenu = card.dataset.kategori;

            // cek search
            let cocokSearch = nama.includes(keyword);

            // cek kategori
            let cocokKategori = kategoriValue == '' || kategoriMenu == kategoriValue;

            // tampil / sembunyi
            if (cocokSearch && cocokKategori) {
                card.parentElement.style.display = ''; // Menggunakan kosong agar grid Bootstrap tetap aman
            } else {
                card.parentElement.style.display = 'none';
            }
        });
    }

    // saat mengetik
    if (search) {
        search.addEventListener('keyup', filterMenu);
    }

    // saat pilih kategori
    if (kategori) {
        kategori.addEventListener('change', filterMenu);
    }
});