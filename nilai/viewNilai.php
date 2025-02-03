<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include('../koneksi.php');

// Query untuk mengambil data nilai mahasiswa, dosen, dan mata kuliah
$query = "SELECT n.id, m.nama AS nama_mahasiswa, n.nilai_tugas, n.nilai_uts, n.nilai_uas, 
                 (0.2 * n.nilai_tugas) + (0.4 * n.nilai_uts) + (0.4 * n.nilai_uas) AS nilai_akhir, 
                 d.nama AS nama_dosen, mk.nama_matkul, n.nim, n.nip
          FROM nilai n
          LEFT JOIN mahasiswa m ON n.nim = m.nim
          LEFT JOIN dosen d ON d.nip = n.nip
          LEFT JOIN mata_kuliah mk ON mk.kode_matkul = n.kode_matkul";

$result = mysqli_query($koneksi, $query);

if (!$result) {
    die("Query error: " . mysqli_error($koneksi));
}
?>


<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Nilai Mahasiswa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            padding: 12px;
            text-align: center;
            border: 1px solid black;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        .btn {
            padding: 8px 12px;
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
            margin: 0 auto 20px;
            padding: 10px;
            text-align: center;
            background-color: #28a745;
            color: white;
            border-radius: 5px;
            font-size: 16px;
            text-decoration: none;
        }

        .add-button:hover {
            background-color: #218838;
        }
    </style>
</head>

<body>

        <h2 style="color: white;">Data Nilai Mahasiswa</h2>

        <?php if ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'dosen') { ?>
            <div class="add-button">
                <a href="./?adm=addNilai">Tambah Nilai</a>
            </div>
        <?php } ?>

        <table>
            <tr>
                <th>Nama Mahasiswa</th>
                <th>Nilai Tugas</th>
                <th>Nilai UTS</th>
                <th>Nilai UAS</th>
                <th>Nilai Akhir</th>
                <th>Nama Dosen</th>
                <th>Nama Mata Kuliah</th>
                <?php
                if ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'dosen') {
                ?>
                    <th>Aksi</th>
                <?php
                }
                ?>
            </tr>

            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                <tr>
                    <td><?= htmlspecialchars($row['nama_mahasiswa']) ?></td>
                    <td><?= htmlspecialchars($row['nilai_tugas']) ?></td>
                    <td><?= htmlspecialchars($row['nilai_uts']) ?></td>
                    <td><?= htmlspecialchars($row['nilai_uas']) ?></td>
                    <td><?= number_format($row['nilai_akhir'], 2) ?></td>
                    <td><?= htmlspecialchars($row['nama_dosen']) ?></td>
                    <td><?= htmlspecialchars($row['nama_matkul']) ?></td>
                    <?php
                    if ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'dosen') {
                    ?>
                        <td>
                            <a href="?adm=editNilai&action=edit&nim=<?= htmlspecialchars($row['nim']) ?>&nip=<?= htmlspecialchars($row['nip']) ?>" class="btn btn-warning">Edit</a>
                            <a href="?adm=deleteNilai&action=delete&nim=<?= htmlspecialchars($row['nim']) ?>&nip=<?= htmlspecialchars($row['nip']) ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus nilai ini?')">Hapus</a>
                        </td>
                    <?php
                    }
                    ?>
                </tr>
            <?php endwhile; ?>
        </table>

</body>

</html>