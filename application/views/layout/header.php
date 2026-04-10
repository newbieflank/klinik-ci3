<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php echo $title; ?></title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

	<style>
		body {
			font-family: 'Poppins', sans-serif !important;
		}
	</style>
</head>

<body>
	<header>
		<nav class="navbar navbar-expand bg-white shadow-sm">
			<div class="container-fluid">
				<a class="navbar-brand d-flex align-items-center" href="#">
					<img src="<?= base_url("assets/logo2.png"); ?>" alt="Logo" height="32" class="me-3">
					<span style=" font-weight: bold;">Pet<span style="color: #81c784;">Cura</span></span>
				</a>

				<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>

				<div class="collapse navbar-collapse" id="navbarNav">
					<ul class="navbar-nav mx-auto">
						<li class="nav-item">
							<a class="nav-link font-weight-bold" href="#">Dashboard</a>
						</li>
						<li class="nav-item">
							<a class="nav-link active" href="#">Pegawai</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="#">Layanan</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="#">Produk</a>
						</li>
					</ul>

					<div class="d-none d-lg-flex" style="width: 100px;"></div>
				</div>
			</div>
		</nav>
	</header>