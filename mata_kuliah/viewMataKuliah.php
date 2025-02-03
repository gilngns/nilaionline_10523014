<?php
include("../koneksi.php");

// Menampilkan daftar mata kuliah
$query = "SELECT * FROM mata_kuliah";
$result = mysqli_query($koneksi, $query);

// Cek apakah query berhasil dieksekusi
if (!$result) {
    die("Query error: " . mysqli_error($koneksi));
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Mata Kuliah</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: white;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
            color: black;
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
        }

        th, td {
            padding: 12px;
            text-align: center;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        td {
            background-color: #f9f9f9;
        }

        tr:nth-child(even) td {
            background-color: #f2f2f2;
        }

        .btn {
            padding: 8px 15px;
            margin: 5px;
            text-decoration: none;
            color: white;
            border-radius: 5px;
            font-weight: bold;
            display: inline-block;
        }

        .btn-warning {
            background-color: #ff9800;
        }

        .btn-danger {
            background-color: #f44336;
        }

        .btn-primary {
            background-color: #007bff;
        }

        .btn:hover {
            opacity: 0.8;
        }

        .add-button {
            display: block;
            width: 160px;
            margin: 0 auto 15px;
            padding: 10px;
            text-align: center;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            text-decoration: none;
        }

        .add-button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Daftar Mata Kuliah</h2>
    
    <a href="?adm=mata_kuliahAdd" class="add-button">Tambah Mata Kuliah</a>

    <table>
        <thead>
            <tr>
                <th>Kode Mata Kuliah</th>
                <th>Nama Mata Kuliah</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['kode_matkul']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['nama_matkul']) . "</td>";
                    echo "<td>
                            <a href='?adm=mata_kuliahEdit&kode_matkul=" . urlencode($row['kode_matkul']) . "' class='btn btn-warning'>Edit</a>
                            <a href='?adm=mata_kuliahDelete&kode_matkul=" . urlencode($row['kode_matkul']) . "' class='btn btn-danger' onclick=\"return confirm('Apakah Anda yakin ingin menghapus mata kuliah ini?')\">Delete</a>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='3'>Tidak ada mata kuliah yang tersedia.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>
