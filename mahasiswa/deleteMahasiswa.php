<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


include('../koneksi.php');

if (isset($_GET['nim'])) {
    $nim = htmlspecialchars(mysqli_real_escape_string($koneksi, $_GET['nim']));

    $query = "DELETE FROM mahasiswa WHERE nim = '$nim'";

    if (mysqli_query($koneksi, $query)) {
        header("Location: ./?adm=mahasiswa");
        exit();
    } else {
        echo 'Error: ' . mysqli_error($koneksi);
    }
} else {
    echo 'NIM mahasiswa tidak ditemukan.';
}
?>
