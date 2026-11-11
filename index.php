<?php
// ==========================================
// 1. KONEKSI DATABASE
// ==========================================
$conn = new mysqli("localhost", "root", "", "db_wishlist");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// ==========================================
// 2. PROSES CRUD (Create, Update, Delete)
// ==========================================

// A. TAMBAH DATA (Create)
if (isset($_POST['tambah'])) {
    $conn->query("INSERT INTO wishlist (nama_barang, harga) VALUES ('{$_POST['nama']}', '{$_POST['harga']}')");
    header("Location: index.php"); // Refresh halaman
    exit;
}

// B. HAPUS DATA (Delete)
if (isset($_GET['hapus'])) {
    $conn->query("DELETE FROM wishlist WHERE id = {$_GET['hapus']}");
    header("Location: index.php");
    exit;
}

// C. CENTANG STATUS BELI (Update)
if (isset($_GET['centang'])) {
    $conn->query("UPDATE wishlist SET status_beli = NOT status_beli WHERE id = {$_GET['centang']}");
    header("Location: index.php");
    exit;
}

// D. EDIT DATA (Update)
if (isset($_POST['edit'])) {
    $conn->query("UPDATE wishlist SET nama_barang='{$_POST['nama']}', harga='{$_POST['harga']}' WHERE id={$_POST['id']}");
    header("Location: index.php");
    exit;
}

// ==========================================
// 3. AMBIL DATA (Read)
// ==========================================
$data = $conn->query("SELECT * FROM wishlist ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Wishlist Saya</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<!-- ==========================================
     4. STRUKTUR HTML
     ========================================== -->
<div class="container">
    <h2>🎁 Wishlist Saya</h2>

    <!-- FORM TAMBAH BARANG -->
    <form method="POST" id="formTambah">
        <input type="text" name="nama" id="nama" placeholder="Nama barang impian..." required>
        <input type="number" name="harga" id="harga" placeholder="Harga (Rp)" required>
        <button type="submit" name="tambah">Tambah ke Wishlist</button>
    </form>

    <!-- DAFTAR BARANG -->
    <ul>
        <?php if ($data->num_rows == 0) : ?>
            <li class="kosong">Belum ada barang impian. Yuk, tambah! ✨</li>
        <?php else : ?>
            <?php while ($row = $data->fetch_assoc()) : ?>
                <!-- Jika status_beli == 1, tambahkan class 'sudah-beli' -->
                <li class="<?= $row['status_beli'] ? 'sudah-beli' : '' ?>">
                    
                    <!-- Tombol Centang -->
                    <a href="?centang=<?= $row['id'] ?>" class="check">
                        <?= $row['status_beli'] ? '✅' : '⬜' ?>
                    </a>

                    <!-- Info Barang -->
                    <div class="info">
                        <span class="nama"><?= htmlspecialchars($row['nama_barang']) ?></span>
                        <span class="harga">Rp <?= number_format($row['harga'], 0, ',', '.') ?></span>
                    </div>

                    <!-- Tombol Edit & Hapus -->
                    <div class="aksi">
                        <button type="button" class="edit" onclick="bukaEdit(<?= $row['id'] ?>, '<?= htmlspecialchars($row['nama_barang']) ?>', <?= $row['harga'] ?>)">Edit</button>
                        <a href="?hapus=<?= $row['id'] ?>" class="hapus" onclick="return confirm('Hapus barang ini?')">Hapus</a>
                    </div>

                </li>
            <?php endwhile; ?>
        <?php endif; ?>
    </ul>
</div>

<!-- ==========================================
     5. MODAL EDIT (Tersembunyi)
     ========================================== -->
<div id="modal" class="modal">
    <div class="modal-content">
        <h3>Edit Barang</h3>
        <form method="POST">
            <input type="hidden" name="id" id="e_id">
            <input type="text" name="nama" id="e_nama" required>
            <input type="number" name="harga" id="e_harga" required>
            <button type="submit" name="edit">Simpan Perubahan</button>
            <button type="button" class="btn-batal" onclick="tutupModal()">Batal</button>
        </form>
    </div>
</div>

<!-- Hubungkan ke file JS -->
<script src="script.js"></script>
</body>
</html>