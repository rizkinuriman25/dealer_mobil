<?php
session_start();
require_once '../config/koneksi.php';

// Aktifkan error reporting untuk debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Cek apakah email ada di database
    $query = "SELECT id, nama, password, no_hp, alamat, role FROM users WHERE email = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $id, $nama, $hashed_password, $no_hp, $alamat, $role);
    mysqli_stmt_fetch($stmt);
    
    if ($id) {
        // Verifikasi password
        if (password_verify($password, $hashed_password)) {
            // Simpan user ke dalam session
            $_SESSION['user'] = [
                'id' => $id,
                'nama' => $nama,
                'email' => $email,
                'no_hp' => $no_hp,
                'alamat' => $alamat,
                'role' => $role
            ];

            // Set session flash untuk menampilkan popup
            $_SESSION['login_success'] = "Login Berhasil!";

            // Redirect berdasarkan role
            if ($role === 'admin') {
                header("Location: login.php?redirect=admin");
                exit;
            } elseif ($role === 'user') {
                header("Location: login.php?redirect=user");
                exit;
            } else {
                $error = "Role tidak dikenali!";
            }
        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "Email tidak ditemukan!";
    }

    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 350px;
        }
        h2 {
            color: #333;
            margin-bottom: 15px;
        }
        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        input {
            width: 100%; 
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            box-sizing: border-box;
        }
        button {
            width: 100%;
            padding: 10px;
            background: #007bff;
            border: none;
            color: white;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }
        button:hover {
            background: #0056b3;
        }
        p {
            margin-top: 15px;
        }
        a {
            text-decoration: none;
            color: #007bff;
        }
        a:hover {
            text-decoration: underline;
        }
        .swal2-popup {
    font-size: 14px !important; /* Ukuran teks lebih kecil */
    width: 300px !important; /* Lebar popup lebih kecil */
    padding: 15px !important;
}

.swal2-title {
    font-size: 18px !important; /* Ukuran judul lebih kecil */
}

.swal2-html-container {
    font-size: 14px !important; /* Ukuran teks deskripsi lebih kecil */
}

.swal2-confirm {
    font-size: 14px !important; /* Ukuran tombol lebih kecil */
    padding: 6px 12px !important;
}

    </style>
</head>
<body>

<div class="container">
    <h2>Login</h2>
    <?php if (isset($error)) echo "<p class='error' style='color:red;'>$error</p>"; ?>

    <form method="POST">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" name="login">Login</button>
    </form>
    <div class="forgot-password-link">
        <p><a href="forgot_password.php">Lupa Password?</a></p>
    </div>
    <p>Belum punya akun? <a href="register.php">Daftar</a></p>
</div>

<?php 
// Tampilkan popup setelah login berhasil
if (isset($_GET['redirect'])) {
    $redirect_page = $_GET['redirect'] === 'admin' ? "../backend/dashboard.php" : "../frontend/user/dashboard.php";
    echo "<script>
        Swal.fire({
            icon: 'success',
            title: 'Login Berhasil',
            text: 'Anda akan diarahkan ke dashboard.',
            confirmButtonColor: '#28a745',
            confirmButtonText: 'Oke'
        }).then(() => {
            window.location.href = '$redirect_page';
        });
    </script>";
}
?>

</body>
</html>
