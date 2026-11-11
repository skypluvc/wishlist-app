// ==========================================
// 1. VALIDASI FORM TAMBAH
// ==========================================
document.getElementById('formTambah').addEventListener('submit', function (e) {
    const nama = document.getElementById('nama').value.trim();
    const harga = document.getElementById('harga').value;

    if (nama.length < 3) {
        alert('Nama barang minimal 3 karakter!');
        e.preventDefault(); // Mencegah form terkirim
    } else if (harga <= 0) {
        alert('Harga harus lebih dari 0!');
        e.preventDefault();
    }
});

// ==========================================
// 2. FUNGSI MODAL EDIT
// ==========================================

// Buka Modal & Isi Otomatis Form
function bukaEdit(id, nama, harga) {
    document.getElementById('e_id').value = id;
    document.getElementById('e_nama').value = nama;
    document.getElementById('e_harga').value = harga;
    document.getElementById('modal').style.display = 'flex';
}

// Tutup Modal
function tutupModal() {
    document.getElementById('modal').style.display = 'none';
}