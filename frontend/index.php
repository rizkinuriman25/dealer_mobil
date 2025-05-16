<?php
// Redirect ke halaman utama frontend jika diakses dari root
if ($_SERVER['REQUEST_URI'] == '/dealer_mobil/') {
    header("Location: frontend/index.php");
    exit;
}

// Menyertakan koneksi database dan header
include '../config/koneksi.php';
include 'partials/header.php';

// Ambil data mobil dari database
$query_mobil = "SELECT * FROM mobil ORDER BY id_mobil DESC LIMIT 6"; // Ambil 6 mobil terbaru
$result_mobil = mysqli_query($conn, $query_mobil);

if (!$result_mobil) {
    die("Query Error: " . mysqli_error($conn));
}
?>

<h1>Selamat Datang di Dealer Mobil</h1>
<p>Kami menyediakan berbagai pilihan mobil terbaru dan layanan purna jual terbaik untuk Anda.</p>

<div class="mobil-container">
    <?php while ($mobil = mysqli_fetch_assoc($result_mobil)) : ?>
        <div class="mobil-card">
            <img src="../uploads/<?= htmlspecialchars($mobil['gambar1']) ?>" alt="<?= htmlspecialchars($mobil['merk']) ?>">
            <h4><?= htmlspecialchars($mobil['merk']) ?> <?= htmlspecialchars($mobil['model']) ?> (<?= $mobil['tahun'] ?>)</h4>
            <p class="harga"><i class="bi bi-cash"></i> Rp <?= number_format($mobil['harga'], 0, ',', '.') ?></p>
            <span class="status <?= strtolower($mobil['status']) === 'tersedia' ? 'tersedia' : 'habis' ?>">
                <?= htmlspecialchars($mobil['status']) ?>
            </span><br>
            <a href="./partials/detail.php?id=<?= $mobil['id_mobil'] ?>" class="btn-detail">Lihat Detail</a>
        </div>
    <?php endwhile; ?>
</div>

<?php include 'partials/footer.php'; ?>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

<!-- CSS dengan gambar tampilan landscape -->
<style>
    /* Container daftar mobil */
    .mobil-container {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        justify-content: center;
    }

    /* Kartu mobil */
    .mobil-card {
        background-color: #ffffff;
        border-radius: 10px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        padding: 15px;
        text-align: center;
        width: 250px; /* Lebih lebar untuk tampilan landscape */
        transition: transform 0.2s;
    }

    .mobil-card:hover {
        transform: translateY(-5px);
    }

    /* Gambar mobil dalam format landscape */
    .mobil-card img {
        width: 100%; /* Gambar memenuhi lebar kartu */
        height: 150px; /* Atur tinggi agar tetap landscape */
        object-fit: cover; /* Pastikan gambar tetap proporsional */
        object-position: center; /* Fokuskan pada bagian tengah */
        background-color: #f0f0f0;
        border-radius: 8px;
        margin-bottom: 10px;
    }

    /* Judul mobil */
    .mobil-card h4 {
        margin: 10px 0 5px;
        font-size: 16px;
    }

    /* Harga mobil */
    .mobil-card .harga {
        font-weight: bold;
        color: darkgreen;
        margin: 5px 0;
    }

    /* Tombol lihat daftar mobil */
    .lihat-daftar-mobil {
        display: inline-block;
        background-color: rgb(44, 79, 86);
        color: #ffffff;
        text-decoration: none;
        font-weight: bold;
        padding: 10px 20px;
        border-radius: 5px;
        transition: 0.3s ease-in-out;
    }

    .lihat-daftar-mobil:hover {
        background-color: rgb(30, 60, 70);
    }

    /* Tombol lihat detail */
    .btn-detail {
        display: inline-block;
        margin-top: 10px;
        padding: 6px 12px;
        background-color: #2C4F56;
        color: #ffffff;
        text-decoration: none;
        border-radius: 6px;
        font-size: 14px;
        transition: background 0.3s ease;
    }

    .btn-detail:hover {
        background-color: #35595f;
    }

    /* Status mobil */
    .status {
        display: inline-block;
        padding: 5px 10px;
        border-radius: 5px;
        font-size: 13px;
        margin-top: 5px;
    }

    .status.tersedia {
        background-color: #d4edda;
        color: #155724;
    }

    .status.habis {
        background-color: #f8d7da;
        color: #721c24;
    }
</style>
