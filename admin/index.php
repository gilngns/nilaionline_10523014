<?php
session_start();

// Pastikan pengguna sudah login dan role ter-set
if (!isset($_SESSION['role'])) {
	header('Location: ../login.php');
	exit();
}

// Tentukan halaman yang diizinkan berdasarkan role
$allowed_pages = [];
switch ($_SESSION['role']) {
	case 'mahasiswa':
		$allowed_pages = ['nilai'];
		break;
	case 'dosen':
		$allowed_pages = ['mahasiswa', 'addMahasiswa', 'editMahasiswa', 'deleteMahasiswa', 'nilai', 'addNilai', 'editNilai', 'deleteNilai'];
		break;
	case 'admin':
		$allowed_pages = [
			'home',
			'mahasiswa',
			'addMahasiswa',
			'editMahasiswa',
			'deleteMahasiswa',
			'dosen',
			'addDosen',
			'editDosen',
			'deleteDosen',
			'nilai',
			'addNilai',
			'editNilai',
			'deleteNilai',
			'mata_kuliah',
			'mata_kuliahAdd',
			'mata_kuliahEdit',
			'mata_kuliahDelete'
		];
		break;
	default:
		session_destroy();
		header('Location: ../login.php');
		exit();
}

// Cek jika halaman yang diminta valid
if (!empty($_GET['adm']) && !in_array($_GET['adm'], $allowed_pages)) {
	header('Location: ./?adm=home');
	exit();
}

?>

<!DOCTYPE html>

<!-- Developed by Websquare Indonesia -->

<!--[if lt IE 7 ]> <html class="no-js ie6 ie" lang="en"> <![endif]-->
<!--[if IE 7 ]>    <html class="no-js ie7 ie" lang="en"> <![endif]-->
<!--[if IE 8 ]>    <html class="no-js ie8 ie" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html class="no-js" lang="en"> <!--<![endif]-->

<head>

	<title>.: Sistem Informasi Nilai Online - Universitas Komputer Indonesia :.</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link rel="shortcut icon" type="image/x-icon" href="../images/logoicon.ico" />
	<link href='http://fonts.googleapis.com/css?family=Droid+Sans:regular,bold' rel='stylesheet' type='text/css' />
	<link href='http://fonts.googleapis.com/css?family=Kreon:light,regular' rel='stylesheet' type='text/css' />
	<link rel="stylesheet" type="text/css" href="../css/style-sheet.css" />
	<!-- <link rel="stylesheet" type="text/css" href="css/style-sheet2.css" />-->
	<link rel="stylesheet" type="text/css" href="../css/nivo-slider.css" />
</head>

<body onLoad="initialize()">
	<header>
		<section class="logo"><a href="#"><img src="../images/logo.png" /></a></section>
		<section class="title">Sistem Informasi Nilai Online <br /> <span>POLITEKNIK POS BANDUNG</span></section>
		<section class="clr">
			<center>Jl.Sariasih No.54, Sarijadi, Sukasari, Kota Bandung, Jawa Barat 40151</center>
		</section>
	</header>

	<section id="navigator">
		<ul class="menus">
			<!-- Menu hanya untuk admin -->
			<?php if ($_SESSION['role'] == 'admin') { ?>
				<li><a href="./?adm=home">Home</a></li>
				<li><a href="./?adm=mata_kuliah">Mata Kuliah</a></li>
				<li><a href="./?adm=mahasiswa">Mahasiswa</a></li>
				<li><a href="./?adm=dosen">Dosen</a></li>
				<li><a href="./?adm=nilai">Nilai</a></li>
			<?php } ?>

			<!-- Menu hanya untuk dosen -->
			<?php if ($_SESSION['role'] == 'dosen') { ?>
				<li><a href="./?adm=mahasiswa">Mahasiswa</a></li>
				<li><a href="./?adm=nilai">Nilai</a></li>
			<?php } ?>

			<!-- Menu hanya untuk mahasiswa -->
			<?php if ($_SESSION['role'] == 'mahasiswa') { ?>
				<li><a href="./?adm=nilai">Nilai</a></li>
			<?php } ?>

			<!-- Link Logout -->
			<li><a href="../logout.php">Logout</a></li>
		</ul>
	</section>


	<section id="container">
		<br><br><br>
		<?php
		if (empty($_GET)) {
			include("home.php");
		} else {
			if ($_GET["adm"] == "home") {
				include("home.php");
			} elseif ($_GET["adm"] == "mahasiswa") {
				include("../mahasiswa/viewMahasiswa.php");
			} elseif ($_GET["adm"] == "addMahasiswa") {
				include("../mahasiswa/addMahasiswa.php");
			} elseif ($_GET["adm"] == "deleteMahasiswa") {
				include("../mahasiswa/deleteMahasiswa.php");
			} elseif ($_GET["adm"] == "editMahasiswa") {
				include("../mahasiswa/editMahasiswa.php");
			} elseif ($_GET["adm"] == "mata_kuliah") {
				include("../mata_kuliah/viewMataKuliah.php");
			} elseif ($_GET["adm"] == "mata_kuliahAdd") {
				include("../mata_kuliah/addMataKuliah.php");
			} elseif ($_GET["adm"] == "mata_kuliahEdit") {
				include("../mata_kuliah/editMataKuliah.php");
			} elseif ($_GET["adm"] == "mata_kuliahDelete") {
				include("../mata_kuliah/deleteMataKuliah.php");
			} elseif ($_GET["adm"] == "dosen") {
				include("../dosen/viewDosen.php");
			} elseif ($_GET["adm"] == "addDosen") {
				include("../dosen/addDosen.php");
			} elseif ($_GET["adm"] == "editDosen") {
				include("../dosen/editDosen.php");
			} elseif ($_GET["adm"] == "deleteDosen") {
				include("../dosen/deleteDosen.php");
			} elseif ($_GET["adm"] == "nilai") {
				include("../nilai/viewNilai.php");
			} elseif ($_GET["adm"] == "addNilai") {
				include("../nilai/addNilai.php");
			} elseif ($_GET["adm"] == "editNilai") {
				include("../nilai/editNilai.php");
			} elseif ($_GET["adm"] == "deleteNilai") {
				include("../nilai/deleteNilai.php");
			}
		}
		?>
		<br><br><br><br><br><br>
		<section class="clr"></section>
	</section>

	<footer>
		<font color=#000> Copyright &copy; 2023 - Universitas Komputer Indonesia <br />
			Developed By <a href="#" target="_new">YourName</a> </font>
	</footer>

</body>

</html>