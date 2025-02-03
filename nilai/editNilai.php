<?php
// Menghubungkan ke database
include("../koneksi.php");

// Cek jika ada parameter nim dan nip untuk edit
if (isset($_GET['nim']) && isset($_GET['nip'])) {
    $nim = $_GET['nim'];
    $nip = $_GET['nip'];

    // Query untuk mengambil data nilai berdasarkan nim dan nip
    $query = "SELECT m.nim, m.nama AS nama_mahasiswa, n.nilai_tugas, n.nilai_uts, n.nilai_uas, 
                 d.nama AS nama_dosen
              FROM nilai n
              LEFT JOIN mahasiswa m ON n.nim = m.nim
              LEFT JOIN dosen d ON d.nip = n.nip
              WHERE n.nim = '$nim' AND n.nip = '$nip'";

    $result = mysqli_query($koneksi, $query);
    $data = mysqli_fetch_assoc($result);

    if (!$data) {
        echo "Data tidak ditemukan!";
        exit;
    }
}

// Proses pengubahan data
if (isset($_POST['submit'])) {
    // Ambil data dari form
    $nilai_tugas = $_POST['nilai_tugas'];
    $nilai_uts = $_POST['nilai_uts'];
    $nilai_uas = $_POST['nilai_uas'];
    
    // Perhitungan nilai akhir
    $nilai_akhir = (0.2 * $nilai_tugas) + (0.4 * $nilai_uts) + (0.4 * $nilai_uas);

    // Query untuk update data nilai
    $queryUpdate = "UPDATE nilai SET nilai_tugas = '$nilai_tugas', nilai_uts = '$nilai_uts', 
                    nilai_uas = '$nilai_uas', nilai_akhir = '$nilai_akhir'
                    WHERE nim = '$nim' AND nip = '$nip'";

    if (mysqli_query($koneksi, $queryUpdate)) {
        echo "<script>alert('Data berhasil diupdate'); window.location.href='?adm=nilai';</script>";
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Nilai Mahasiswa</title>
    <style>
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-container {
            width: 50%;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        label {
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
        }

        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        .cancel-link {
            display: inline-block;
            padding: 10px 20px;
            background-color: #f44336;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 10px;
        }

        .cancel-link:hover {
            background-color: #e53935;
        }
    </style>
</head>

<body>

    <h2>Edit Nilai Mahasiswa</h2>
    <div class="form-container">
        <form method="POST" action="">
            <label for="nama_mahasiswa">Nama Mahasiswa:</label>
            <input type="text" id="nama_mahasiswa" name="nama_mahasiswa" value="<?php echo $data['nama_mahasiswa']; ?>" disabled>

            <label for="nama_dosen">Nama Dosen:</label>
            <input type="text" id="nama_dosen" name="nama_dosen" value="<?php echo $data['nama_dosen']; ?>" disabled>

            <label for="nilai_tugas">Nilai Tugas:</label>
            <input type="number" id="nilai_tugas" name="nilai_tugas" value="<?php echo $data['nilai_tugas']; ?>" required>

            <label for="nilai_uts">Nilai UTS:</label>
            <input type="number" id="nilai_uts" name="nilai_uts" value="<?php echo $data['nilai_uts']; ?>" required>

            <label for="nilai_uas">Nilai UAS:</label>
            <input type="number" id="nilai_uas" name="nilai_uas" value="<?php echo $data['nilai_uas']; ?>" required>

            <button type="submit" name="submit">Update Nilai</button>
            <a href="?adm=nilai" class="cancel-link">Batal</a>
        </form>
    </div>

</body>

</html>
