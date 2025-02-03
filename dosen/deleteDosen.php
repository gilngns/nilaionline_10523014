<?php
session_start();

// Memeriksa apakah user sudah login dan memiliki hak akses sebagai admin
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: ../index.php");
    exit();
}

include('../koneksi.php');

if (isset($_GET['nip'])) {
    $nip = htmlspecialchars(mysqli_real_escape_string($koneksi, $_GET['nip']));

    // Menghapus data dosen berdasarkan NIP
    $query = "DELETE FROM dosen WHERE nip = '$nip'";

    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Data dosen berhasil dihapus!'); window.location='./?adm=dosen';</script>";
    } else {
        echo "<script>alert('Gagal menghapus data dosen.'); window.location='./?adm=dosen';</script>";
    }
} else {
    echo "<script>alert('NIP tidak ditemukan.'); window.location='./?adm=dosen';</script>";
}
?>
