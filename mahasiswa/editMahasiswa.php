<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


include('../koneksi.php');

if (isset($_GET['nim'])) {
    $nim_lama = htmlspecialchars(mysqli_real_escape_string($koneksi, $_GET['nim']));
    $query = "SELECT * FROM mahasiswa WHERE nim = '$nim_lama'";
    $result = mysqli_query($koneksi, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
    } else {
        echo "Mahasiswa tidak ditemukan!";
        exit();
    }
} else {
    echo "NIM tidak diberikan!";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nim_baru = htmlspecialchars(mysqli_real_escape_string($koneksi, $_POST['nim']));
    $nama = htmlspecialchars(mysqli_real_escape_string($koneksi, $_POST['nama']));
    $jk = htmlspecialchars(mysqli_real_escape_string($koneksi, $_POST['jk']));
    $jurusan = htmlspecialchars(mysqli_real_escape_string($koneksi, $_POST['jurusan']));

    if ($nim_baru !== $nim_lama) {
        $cek_nim = "SELECT nim FROM mahasiswa WHERE nim = '$nim_baru'";
        $cek_result = mysqli_query($koneksi, $cek_nim);

        if (mysqli_num_rows($cek_result) > 0) {
            echo "<script>alert('NIM sudah digunakan! Pilih NIM lain.');</script>";
        } else {
            $updateQuery = "UPDATE mahasiswa SET nim='$nim_baru', nama='$nama', jk='$jk', jurusan='$jurusan' WHERE nim='$nim_lama'";
            if (mysqli_query($koneksi, $updateQuery)) {
                header("Location: ./?adm=mahasiswa");
                exit();
            } else {
                echo "Error: " . mysqli_error($koneksi);
            }
        }
    } else {
        $updateQuery = "UPDATE mahasiswa SET nama='$nama', jk='$jk', jurusan='$jurusan' WHERE nim='$nim_lama'";
        if (mysqli_query($koneksi, $updateQuery)) {
            header("Location: ./?adm=mahasiswa");
            exit();
        } else {
            echo "Error: " . mysqli_error($koneksi);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Mahasiswa</title>
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
        <h2>Edit Mahasiswa</h2>
        <form method="POST">
            <label for="nim">NIM</label>
            <input type="text" id="nim" name="nim" value="<?php echo $row['nim']; ?>" required>

            <label for="nama">Nama</label>
            <input type="text" id="nama" name="nama" value="<?php echo $row['nama']; ?>" required>

            <label for="jk">Jenis Kelamin</label>
            <select id="jk" name="jk" required>
                <option value="L" <?php if ($row['jk'] == 'L') echo 'selected'; ?>>Laki-laki</option>
                <option value="P" <?php if ($row['jk'] == 'P') echo 'selected'; ?>>Perempuan</option>
            </select>

            <label for="jurusan">Jurusan</label>
            <input type="text" id="jurusan" name="jurusan" value="<?php echo $row['jurusan']; ?>" required>

            <div class="button-group">
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="./?adm=mahasiswa" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>

</body>

</html>