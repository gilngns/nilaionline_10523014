<?php
session_start();
include('koneksi.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$username = addslashes($_POST['username']);
	$password = $_POST['password'];

	$query_admin = "SELECT * FROM admin WHERE username='$username' AND password=md5('$password')";
	$result_admin = mysqli_query($koneksi, $query_admin);

	if ($result_admin && mysqli_num_rows($result_admin) > 0) {
		$data = mysqli_fetch_assoc($result_admin);
		$_SESSION['user_id'] = $data['id'];
		$_SESSION['username'] = $data['username'];
		$_SESSION['role'] = 'admin';
		header("Location: admin/index.php");
		exit();
	} else {
		$query_mahasiswa = "SELECT * FROM mahasiswa WHERE nim='$username'";
		$result_mahasiswa = mysqli_query($koneksi, $query_mahasiswa);

		if ($result_mahasiswa && mysqli_num_rows($result_mahasiswa) > 0) {
			$data = mysqli_fetch_assoc($result_mahasiswa);
			if (password_verify($password, $data['password'])) {
				$_SESSION['user_id'] = $data['id'];
				$_SESSION['username'] = $data['nim'];
				$_SESSION['role'] = 'mahasiswa';
				header("Location: http://localhost/10523014_GilangNandaSaputra_nilaionline/admin/?adm=nilai");
				exit();
			} else {
				echo "<script>alert('Password salah!'); window.location='index.php';</script>";
			}
		} else {
			$query_dosen = "SELECT * FROM dosen WHERE nip='$username'";
			$result_dosen = mysqli_query($koneksi, $query_dosen);

			if ($result_dosen && mysqli_num_rows($result_dosen) > 0) {
				$data = mysqli_fetch_assoc($result_dosen);
				if (password_verify($password, $data['password'])) {
					$_SESSION['user_id'] = $data['id'];
					$_SESSION['username'] = $data['nip'];
					$_SESSION['role'] = 'dosen';
					header("Location: http://localhost/10523014_GilangNandaSaputra_nilaionline/admin/?adm=nilai");
					exit();
				} else {
					echo "<script>alert('Password salah!'); window.location='index.php';</script>";
				}
			} else {
				echo "<script>alert('Username tidak ditemukan!'); window.location='index.php';</script>";
			}
		}
	}
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>.: Sistem Informasi Nilai Online - Universitas Komputer Indonesia :.</title>
	<link rel="shortcut icon" type="image/x-icon" href="images/logoicon.ico" />
	<link href='http://fonts.googleapis.com/css?family=Droid+Sans:regular,bold' rel='stylesheet' type='text/css' />
	<link href='http://fonts.googleapis.com/css?family=Kreon:light,regular' rel='stylesheet' type='text/css' />
	<link rel="stylesheet" type="text/css" href="css/style-sheet.css" />
	<link rel="stylesheet" type="text/css" href="css/nivo-slider.css" />
</head>

<body>

	<header>
		<section class="logo"><a href="#"><img src="images/logo.png" /></a></section>
		<section class="title">Sistem Informasi Nilai Online <br /> <span>UNIVERSITAS KOMPUTER INDONESIA</span></section>
		<section class="clr">
			<center>Jl. Dipati Ukur No.112-116, Lebakgede, Kecamatan Coblong, Kota Bandung, Jawa Barat 40132</center>
		</section>
	</header>

	<section id="container">
		<div>
			<center>
				<section id="navigator">
					<ul class="menus">
						<h2>LOGIN GENERAL</h2>
					</ul>
				</section>
				<br /><br />

				<form method="post" action="" class="form-login">
					<table>
						<tr>
							<td><input type="text" name="username" placeholder="Username / NIM / NIP" required /></td>
						</tr>
						<tr>
							<td><input type="password" name="password" placeholder="Password" required /></td>
						</tr>
						<tr>
							<td><input id="submit" name="submit" type="submit" value="Login"></td>
						</tr>
					</table>
				</form>

			</center>
		</div>
		<section class="clr"></section>
	</section>

	<footer>
		<font color=#000> Copyright &copy; 2018 - Politeknik Pos BANDUNG <br />
			Developed By <a href="#" target="_new">YourName</a> </font>
	</footer>

</body>

</html>