/**
 * Fungsi untuk memformat input menjadi ribuan (titik)
 * dan menyimpan angka murni ke hidden input.
 * 
 * @param {HTMLElement} el - Element input yang sedang diketik
 * @param {string} hiddenId - ID dari input hidden untuk simpan angka murni
 */
function formatRupiah(el, hiddenId) {
    // 1. Ambil hanya angka
    let value = el.value.replace(/[^0-9]/g, '');
    
    // 2. Update input hidden dengan angka murni untuk database
    document.getElementById(hiddenId).value = value;
    
    
    // 3. Update tampilan input dengan titik pemisah ribuan
    el.value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');



}

