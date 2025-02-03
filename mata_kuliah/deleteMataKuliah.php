<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: ../index.php"); 
    exit();
}

include('../koneksi.php');
if (isset($_GET['kode_matkul'])) {
    $kode_matkul = htmlspecialchars(mysqli_real_escape_string($koneksi, $_GET['kode_matkul']));

    $query = "DELETE FROM mata_kuliah WHERE kode_matkul = '$kode_matkul'";

    if (mysqli_query($koneksi, $query)) {
        header("Location: ./?adm=mata_kuliah");
        exit();
    } else {
        echo 'Error: ' . mysqli_error($koneksi);
    }
} else {
    echo 'Mata Kuliah tidak ditemukan.';
}
?>
