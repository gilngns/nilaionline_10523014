<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: ../index.php");
    exit();
}

include('../koneksi.php');

// Mengambil data dosen beserta mata kuliah yang diajarkan
$query = "
    SELECT dosen.nip, dosen.nama, mata_kuliah.nama_matkul 
    FROM dosen 
    JOIN mata_kuliah ON dosen.kode_matkul = mata_kuliah.kode_matkul
";
$result = mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Dosen</title>
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
        }

        th,
        td {
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
            margin: 0 auto;
            margin-bottom: 15px;
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
        <h2>Daftar Dosen</h2>

        <a href="./?adm=addDosen" class="add-button">Tambah Dosen + </a>

        <table>
            <thead>
                <tr>
                    <th>NIP</th>
                    <th>Nama Dosen</th>
                    <th>Mata Kuliah</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['nip']) ?></td>
                        <td><?= htmlspecialchars($row['nama']) ?></td>
                        <td><?= htmlspecialchars($row['nama_matkul']) ?></td>
                        <td>
                            <a href="./?adm=editDosen&nip=<?= htmlspecialchars($row['nip']) ?>" class="btn btn-warning">Edit</a>
                            <a href="./?adm=deleteDosen&nip=<?= htmlspecialchars($row['nip']) ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus dosen ini?')">Hapus</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

</body>

</html>