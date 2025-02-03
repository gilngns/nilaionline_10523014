<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: index.php");
    exit();
}

include('../koneksi.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kode_matkul = mysqli_real_escape_string($koneksi, $_POST['kode_matkul']);
    $nama_matkul = mysqli_real_escape_string($koneksi, $_POST['nama_matkul']);

    $query = "INSERT INTO mata_kuliah (kode_matkul, nama_matkul) VALUES ('$kode_matkul', '$nama_matkul')";

    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Mata kuliah berhasil ditambahkan!'); window.location='./?adm=mata_kuliah';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan mata kuliah.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Mata Kuliah</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 500px;
            margin: 30px auto;
            background-color: #fff;
            color: black;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            font-size: 14px;
            margin-bottom: 5px;
            display: block;
        }

        input {
            width: 100%;
            padding: 8px;
            margin: 10px 0 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 14px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #218838;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
        }

        .back-link a {
            text-decoration: none;
            color: #007bff;
        }

        .back-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <div class="container">
        <h2>Tambah Mata Kuliah</h2>
        <form action="" method="POST">
            <label for="kode_matkul">Kode Mata Kuliah:</label>
            <input type="text" id="kode_matkul" name="kode_matkul" required>

            <label for="nama_matkul">Nama Mata Kuliah:</label>
            <input type="text" id="nama_matkul" name="nama_matkul" required>

            <button type="submit">Tambah</button>
        </form>

        <div class="back-link">
            <a href="./?adm=mata_kuliah">← Kembali ke Daftar Mata Kuliah</a>
        </div>
    </div>

</body>

</html>