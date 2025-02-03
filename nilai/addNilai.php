<?php
// Menghubungkan ke database
include("../koneksi.php");

// Proses penyimpanan data nilai
if (isset($_POST['submit'])) {
    $nim = $_POST['nim'];
    $nip = $_POST['nip'];
    $kode_matkul = $_POST['kode_matkul'];
    $nilai_tugas = $_POST['nilai_tugas'];
    $nilai_uts = $_POST['nilai_uts'];
    $nilai_uas = $_POST['nilai_uas'];

    // Menghitung nilai akhir (contoh: nilai akhir = (nilai_tugas + nilai_uts + nilai_uas) / 3)
    $nilai_akhir = ($nilai_tugas + $nilai_uts + $nilai_uas) / 3;

    // Query untuk menyimpan data nilai
    $query = "INSERT INTO nilai (nim, nip, kode_matkul, nilai_tugas, nilai_uts, nilai_uas, nilai_akhir)
              VALUES ('$nim', '$nip', '$kode_matkul', '$nilai_tugas', '$nilai_uts', '$nilai_uas', '$nilai_akhir')";

    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Data nilai berhasil disimpan'); window.location.href='?adm=nilai';</script>";
    } else {
        echo "<script>alert('Gagal menyimpan data nilai');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Nilai</title>
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
        input[type="number"],
        select {
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

    <h2>Input Nilai Mahasiswa</h2>
    <div class="form-container">
        <form action="" method="POST">
            <div>
                <label for="nim">NIM</label>
                <select name="nim" required>
                    <option value="">--Pilih Mahasiswa--</option>
                    <?php
                    // Menampilkan daftar mahasiswa
                    $mahasiswa_query = "SELECT * FROM mahasiswa";
                    $mahasiswa_result = mysqli_query($koneksi, $mahasiswa_query);
                    while ($mahasiswa = mysqli_fetch_assoc($mahasiswa_result)) {
                        echo "<option value='" . $mahasiswa['nim'] . "'>" . $mahasiswa['nama'] . "</option>";
                    }
                    ?>
                </select>
            </div>

            <div>
                <label for="nip">NIP Dosen</label>
                <select name="nip" required>
                    <option value="">--Pilih Dosen--</option>
                    <?php
                    // Menampilkan daftar dosen
                    $dosen_query = "SELECT * FROM dosen";
                    $dosen_result = mysqli_query($koneksi, $dosen_query);
                    while ($dosen = mysqli_fetch_assoc($dosen_result)) {
                        echo "<option value='" . $dosen['nip'] . "'>" . $dosen['nama'] . "</option>";
                    }
                    ?>
                </select>
            </div>

            <div>
                <label for="kode_matkul">Mata Kuliah</label>
                <select name="kode_matkul" required>
                    <option value="">--Pilih Mata Kuliah--</option>
                    <?php
                    // Menampilkan daftar mata kuliah
                    $matkul_query = "SELECT * FROM mata_kuliah";
                    $matkul_result = mysqli_query($koneksi, $matkul_query);
                    while ($matkul = mysqli_fetch_assoc($matkul_result)) {
                        echo "<option value='" . $matkul['kode_matkul'] . "'>" . $matkul['nama_matkul'] . "</option>";
                    }
                    ?>
                </select>
            </div>

            <div>
                <label for="nilai_tugas">Nilai Tugas</label>
                <input type="number" name="nilai_tugas" required />
            </div>
            <div>
                <label for="nilai_uts">Nilai UTS</label>
                <input type="number" name="nilai_uts" required />
            </div>
            <div>
                <label for="nilai_uas">Nilai UAS</label>
                <input type="number" name="nilai_uas" required />
            </div>

            <div>
                <button type="submit" name="submit">Simpan Nilai</button>
            </div>
            <div>
                <a href="?adm=nilai" class="cancel-link">Batal</a>
            </div>
        </form>
    </div>

</body>

</html>
