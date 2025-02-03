<?php

if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit();
}

$username = $_SESSION['username'];
?>

<h2>Selamat datang, <?php echo htmlspecialchars($username); ?></h2>
<i>Selamat Datang Di Website Aplikasi Nilai Online Universitas Komputer Indonesia. Aplikasi ini dirancang untuk membantu civitas akademik dalam mengelola nilai.</i>
