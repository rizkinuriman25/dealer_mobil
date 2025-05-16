<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dealer Mobil</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');
        /* Warna utama */
        :root {
            --primary-color: rgb(44, 79, 86);
            --text-light: #ffffff;
            --text-dark: #f8f9fa;
        }

        /* Reset default margin dan padding */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        /* Style untuk navbar */
        nav {
            background-color: var(--primary-color);
            padding: 15px;
            text-align: center;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        }

        nav a {
            color: var(--text-light);
            text-decoration: none;
            font-size: 1.2rem;
            margin: 0 15px;
            font-weight: bold;
            transition: color 0.3s ease;
        }

        nav a:hover {
            color: #ddd;
        }

        hr {
            border: none;
            height: 3px;
            background-color: var(--primary-color);
            margin: 10px 0;
        }
    </style>
</head>
<body>

<nav>
    <a href="index.php">Beranda</a> |
    <a href="partials/list.php">Cari Mobil</a> |
    <a href="about.php">Tentang</a> |
    <a href="kontak.php">Kontak</a> |
    <a href="../auth/login.php">Login</a>
</nav>
<hr>

</body>
</html>
