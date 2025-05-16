<?php
session_start();
$_SESSION = []; // Menghapus semua isi session
session_unset(); // Unset session
session_destroy(); // Hancurkan session
header("Location: /dealer_mobil/index.php");
exit;
?>
