<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: index.php");
    exit();
}

include('../koneksi.php');

if (!isset($_GET['kode_matkul'])) {
    echo "<script>alert('ID tidak ditemukan!'); window.location='./?adm=mata_kuliah';</script>";
    exit();
}

$kode_matkul = $_GET['kode_matkul'];
$query = "SELECT * FROM mata_kuliah WHERE kode_matkul = '$kode_matkul'";
$result = mysqli_query($koneksi, $query);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    echo "<script>alert('Mata kuliah tidak ditemukan!'); window.location='./?adm=mata_kuliah';</script>";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form dan sanitasi input
    $kode_matkul_baru = mysqli_real_escape_string($koneksi, $_POST['kode_matkul']);
    $nama_matkul = mysqli_real_escape_string($koneksi, $_POST['nama_matkul']);

    // Update query untuk memperbarui data
    $updateQuery = "UPDATE mata_kuliah SET kode_matkul = '$kode_matkul_baru', nama_matkul = '$nama_matkul' WHERE kode_matkul = '$kode_matkul'";

    if (mysqli_query($koneksi, $updateQuery)) {
        echo "<script>alert('Mata kuliah berhasil diperbarui!'); window.location='./?adm=mata_kuliah';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui mata kuliah.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Mata Kuliah</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 500px;
            margin: 50px auto;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 10px;
            color: black;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
        }

        input {
            width: 95%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .button-group {
            display: flex;
            gap: 10px;
            justify-content: space-between;
        }

        .btn {
            flex: 1;
            padding: 10px;
            text-align: center;
            font-size: 16px;
            border: none;
            cursor: pointer;
            text-decoration: none;
        }

        .btn-primary {
            background-color: #007bff;
            color: white;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background-color: #545b62;
        }
    </style>
</head>

<body>

    <div class="container">
        <h2>Edit Mata Kuliah</h2>
        <form action="" method="POST">
            <label for="kode_matkul">Kode Mata Kuliah:</label>
            <input type="text" id="kode_matkul" name="kode_matkul" value="<?= htmlspecialchars($data['kode_matkul']) ?>" required>

            <label for="nama_matkul">Nama Mata Kuliah:</label>
            <input type="text" id="nama_matkul" name="nama_matkul" value="<?= htmlspecialchars($data['nama_matkul']) ?>" required>

            <div class="button-group">
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="./?adm=mata_kuliah" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>

</body>

</html>