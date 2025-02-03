<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


include('../koneksi.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nim = htmlspecialchars(mysqli_real_escape_string($koneksi, $_POST['nim']));
    $nama = htmlspecialchars(mysqli_real_escape_string($koneksi, $_POST['nama']));
    $jk = htmlspecialchars(mysqli_real_escape_string($koneksi, $_POST['jk']));
    $jurusan = htmlspecialchars(mysqli_real_escape_string($koneksi, $_POST['jurusan']));
    $password = htmlspecialchars(mysqli_real_escape_string($koneksi, $_POST['password']));

    // Using password_hash instead of md5
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $query = "INSERT INTO mahasiswa (nim, nama, jk, jurusan, password) 
              VALUES ('$nim', '$nama', '$jk', '$jurusan', '$hashed_password')";

    if (mysqli_query($koneksi, $query)) {
        header("Location: ./?adm=mahasiswa");
        exit();
    } else {
        echo 'Error: ' . mysqli_error($koneksi);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Mahasiswa</title>
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

        input, select {
            width: 95%;
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
        <h2>Tambah Mahasiswa</h2>

        <form method="POST">
            <label for="nim">NIM</label>
            <input type="text" id="nim" name="nim" required>

            <label for="nama">Nama</label>
            <input type="text" id="nama" name="nama" required>

            <label for="jk">Jenis Kelamin</label>
            <select id="jk" name="jk" required>
                <option value="L">Laki-Laki</option>
                <option value="P">Perempuan</option>
            </select>

            <label for="jurusan">Jurusan</label>
            <input type="text" id="jurusan" name="jurusan" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Tambah Mahasiswa</button>
        </form>

        <div class="back-link">
            <a href="./?adm=mahasiswa">Kembali ke Daftar Mahasiswa</a>
        </div>
    </div>

</body>
</html>
