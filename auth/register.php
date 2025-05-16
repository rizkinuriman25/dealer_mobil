<?php  
require_once '../config/koneksi.php';

if (isset($_POST['register'])) {
    $nik = $_POST['nik'];
    $tempat_lahir = $_POST['tempat_lahir'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $no_hp = $_POST['no_hp'];
    $alamat = $_POST['alamat'];
    $username = strtolower(str_replace(' ', '', $nama));
    $created_at = date("Y-m-d H:i:s");

    $cek = mysqli_prepare($conn, "SELECT id FROM users WHERE email = ? OR id IN (SELECT id_pelanggan FROM pelanggan WHERE nik = ?)");
    mysqli_stmt_bind_param($cek, "ss", $email, $nik);
    mysqli_stmt_execute($cek);
    mysqli_stmt_store_result($cek);

    if (mysqli_stmt_num_rows($cek) > 0) {
        $error = "Email atau NIK sudah terdaftar!";
    } else {
        $stmt = mysqli_prepare($conn, "INSERT INTO users (nama, email, password, no_hp, alamat, role, created_at, username) VALUES (?, ?, ?, ?, ?, 'user', ?, ?)");
        mysqli_stmt_bind_param($stmt, "sssssss", $nama, $email, $password, $no_hp, $alamat, $created_at, $username);
        mysqli_stmt_execute($stmt);

        $user_id = mysqli_insert_id($conn);
        $stmt_pelanggan = mysqli_prepare($conn, "INSERT INTO pelanggan (id_pelanggan, nama_pelanggan, nik, tempat_lahir, tanggal_lahir, jenis_kelamin) VALUES (?, ?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt_pelanggan, "isssss", $user_id, $nama, $nik, $tempat_lahir, $tanggal_lahir, $jenis_kelamin);
        mysqli_stmt_execute($stmt_pelanggan);

        header("Location: register.php?register=success");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Pengguna</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');
        :root {
            --primary-color: #0056b3;
            --secondary-color: rgb(6, 65, 128);
            --text-light: #ffffff;
            --border-radius: 8px;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body {
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background: #fff;
            padding: 25px;
            border-radius: var(--border-radius);
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }
        h2 { color: var(--primary-color); margin-bottom: 20px; }
        input, textarea, select {
            width: 100%;
            padding: 5px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: var(--border-radius);
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: var(--primary-color);
            color: var(--text-light);
            border: none;
            border-radius: var(--border-radius);
            font-size: 1rem;
            cursor: pointer;
            transition: 0.3s;
        }
        button:hover { background-color: var(--secondary-color); }
        .error { color: red; font-weight: bold; margin-bottom: 10px; }
    </style>
</head>
<body>

<div class="container">
    <h2>Registrasi Pengguna</h2>
    <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
    <form method="POST">
        <input type="text" name="nik" placeholder="NIK" required>
        <input type="text" name="tempat_lahir" placeholder="Tempat Lahir" required>
        <input type="date" name="tanggal_lahir" required>
        <select name="jenis_kelamin">
            <option value="L">Laki-laki</option>
            <option value="P">Perempuan</option>
        </select>
        <input type="text" name="nama" placeholder="Nama Lengkap" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="text" name="no_hp" placeholder="No HP">
        <textarea name="alamat" placeholder="Alamat"></textarea>
        <button type="submit" name="register">Daftar</button>
    </form>
    <p>Sudah punya akun? <a href="login.php">Login</a></p>
</div>

<?php if (isset($_GET['register']) && $_GET['register'] == 'success') { ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Registrasi Berhasil',
            text: 'Akun Anda telah terdaftar!',
            confirmButtonColor: '#28a745',
            confirmButtonText: 'Oke'
        }).then(() => {
            window.location.href = 'login.php';
        });
    </script>
<?php } ?>

</body>
</html>
