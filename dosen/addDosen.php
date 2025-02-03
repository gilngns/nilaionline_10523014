<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: ../index.php");
    exit();
}

include('../koneksi.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nip = htmlspecialchars(mysqli_real_escape_string($koneksi, $_POST['nip']));
    $nama = htmlspecialchars(mysqli_real_escape_string($koneksi, $_POST['nama']));
    $kode_matkul = htmlspecialchars(mysqli_real_escape_string($koneksi, $_POST['kode_matkul']));
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $query = "INSERT INTO dosen (nip, nama, kode_matkul, password) VALUES ('$nip', '$nama', '$kode_matkul', '$password')";

    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Dosen berhasil ditambahkan!'); window.location='./?adm=dosen';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan dosen.');</script>";
    }
}

$query = "SELECT * FROM mata_kuliah";
$mataKuliahResult = mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Dosen</title>
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

        input,
        select {
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
        <h2>Tambah Dosen</h2>

        <form action="" method="POST">
            <label for="nip">NIP:</label>
            <input type="text" id="nip" name="nip" required>

            <label for="nama">Nama Dosen:</label>
            <input type="text" id="nama" name="nama" required>

            <label for="kode_matkul">Kode Mata Kuliah:</label>
            <select id="kode_matkul" name="kode_matkul" required>
                <option value="">Pilih Mata Kuliah</option>
                <?php while ($row = mysqli_fetch_assoc($mataKuliahResult)): ?>
                    <option value="<?= htmlspecialchars($row['kode_matkul']) ?>"><?= htmlspecialchars($row['nama_matkul']) ?></option>
                <?php endwhile; ?>
            </select>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Tambah Dosen</button>
        </form>

        <div class="back-link">
            <a href="./?adm=dosen">Kembali ke Daftar Dosen</a>
        </div>
    </div>

</body>

</html>