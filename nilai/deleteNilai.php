<?php
include("../koneksi.php");

if (isset($_GET['nim']) && isset($_GET['nip'])) {
    $nim = $_GET['nim'];
    $nip = $_GET['nip'];

    $queryDelete = "DELETE FROM nilai WHERE nim = '$nim' AND nip = '$nip'";

    if (mysqli_query($koneksi, $queryDelete)) {
        echo "<script>alert('Data berhasil dihapus'); window.location.href='?adm=nilai';</script>";
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
} else {
    echo "<script>alert('Data tidak valid'); window.location.href='?adm=nilai';</script>";
}
?>
