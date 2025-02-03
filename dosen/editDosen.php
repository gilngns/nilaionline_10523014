<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Memeriksa apakah user sudah login dan memiliki hak akses sebagai admin
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: ../index.php");
    exit();
}

include('../koneksi.php');

if (isset($_GET['nip'])) {
    $nip = htmlspecialchars(mysqli_real_escape_string($koneksi, $_GET['nip']));

    // Mengambil data dosen berdasarkan NIP
    $query = "SELECT * FROM dosen WHERE nip = '$nip'";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        $dosen = mysqli_fetch_assoc($result);
    } else {
        echo "Dosen tidak ditemukan.";
        exit();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nip_lama = htmlspecialchars(mysqli_real_escape_string($koneksi, $_POST['nip_lama'])); // NIP lama
    $nip_baru = htmlspecialchars(mysqli_real_escape_string($koneksi, $_POST['nip'])); // NIP baru yang dimasukkan
    $nama = htmlspecialchars(mysqli_real_escape_string($koneksi, $_POST['nama']));
    $kode_matkul = htmlspecialchars(mysqli_real_escape_string($koneksi, $_POST['kode_matkul']));

    // Jika password baru diisi, maka lakukan hashing dan update password
    if (!empty($_POST['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $query = "UPDATE dosen SET nip = '$nip_baru', nama = '$nama', kode_matkul = '$kode_matkul', password = '$password' WHERE nip = '$nip_lama'";
    } else {
        // Jika password tidak diubah, tidak perlu mengupdate kolom password
        $query = "UPDATE dosen SET nip = '$nip_baru', nama = '$nama', kode_matkul = '$kode_matkul' WHERE nip = '$nip_lama'";
    }

    // Menjalankan query update
    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Data dosen berhasil diperbarui!'); window.location='./?adm=dosen';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui data dosen.');</script>";
    }
}

// Mengambil daftar mata kuliah dari tabel mata_kuliah
$query = "SELECT * FROM mata_kuliah";
$mataKuliahResult = mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Dosen</title>
    <style>
        /* CSS yang telah Anda berikan */
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
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
        }

        input,
        select {
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
        <h2>Edit Data Dosen</h2>

        <form action="" method="POST">
            <input type="hidden" name="nip_lama" value="<?= htmlspecialchars($dosen['nip']) ?>"> <!-- NIP Lama yang disembunyikan -->

            <label for="nip">NIP:</label>
            <input type="text" id="nip" name="nip" value="<?= htmlspecialchars($dosen['nip']) ?>" required>

            <label for="nama">Nama Dosen:</label>
            <input type="text" id="nama" name="nama" value="<?= htmlspecialchars($dosen['nama']) ?>" required>

            <label for="kode_matkul">Kode Mata Kuliah:</label>
            <select id="kode_matkul" name="kode_matkul" required>
                <option value="">Pilih Mata Kuliah</option>
                <?php while ($row = mysqli_fetch_assoc($mataKuliahResult)): ?>
                    <option value="<?= htmlspecialchars($row['kode_matkul']) ?>" <?= $dosen['kode_matkul'] == $row['kode_matkul'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($row['nama_matkul']) ?>
                    </option>
                <?php endwhile; ?>
            </select>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="Masukkan password baru (kosongkan jika tidak diubah)">

            <div class="button-group">
                <button type="submit" class="btn btn-primary">Perbarui Data</button>
                <a href="./?adm=dosen" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>

</body>

</html>