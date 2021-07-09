<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width-device-width, initial-scale=1">

	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="style.css">
	<script src="https://kit.fontawesome.com/9009871c45.js" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

	<title>Welcome | Exploria</title>
</head>
<body>
	
	<!-- Navbar -->
	<nav class="shadow-sm navbar navbar-expand-lg navbar-white bg-white fixed-top mt-0 pb-0 border-bottom" id="navbar">
		<div class="container">
			<a class="navbar-brand" href="#">
				<img src="img/logo.png" height="35px">
			</a>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
				aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>	
			</button>
			<div class="collapse navbar-collapse justify-content-end" id="navbarNav">
				<ul class="nav nav-pills">
					<li class="nav-item mb-0">
						<a class="nav-link active bg-active link-navbar tebel-sedang" href="index.php">Home &nbsp;&nbsp;</a>
						<div class="garis"></div>
					</li>						
					</li>
					<li class="nav-item">
						<!-- <a class="nav-link bg-custom rounded-pill tebel-sedang shadow" id="btn-sign" href="dashboard.php">Tampilkan Database</a> -->
						<a class="nav-link link-navbar tebel-sedang" href="tempatwisata/dashboard.php">Dashboard</a>
					</li>
					<li class="nav-item">
						<a class="nav-link link-navbar tebel-sedang" href="#"><i class="fas fa-user"></i>Pegawai A &nbsp;&nbsp;</a>
					</li>
				</ul>
			</div>
		</div>
	</nav>

	<!-- Isi Konten -->
	<div class="container d-flex flex-row konten">
		<br><br><br>

		<div class="mt-5 mb-5">

			<!-- <div class="col-lg-12 gambar">
				<img src="vector-konten.png" width="100%">
			</div> -->

			<div class="col-sm-12 position-relative p-4 mt-5 mr-5">
				<br>
				<h1 class="display-1 text-truncate tebel-sedang judul1">Selamat</h1>
				<h1 class="display-1 text-truncate tebel-sedang judul2 mb-3">Datang</h1>
				<div class="hr"></div>

				<div class="desc mt-4">
					<p>EXPLORIA merupakan sistem informasi yang dibuat untuk membantu mengelola tempat wisata dengan diberikannya informasi mengenai penting untuk mengetahui kekurangan dan keunggulan tempat wisata tersebut</p>
				</div>
				<br>
			</div>
		</div>

		<!-- <div class="col-sm-12 position-relative p-4 mt-5 ml-5">
			<br>
			<br>
			<div class="position-absolute top-0 end-0 mt-5">
				<img src="img/alam.png" class="img">
			</div>
		</div>		 -->
	</div>
	
	<script src="js/jquery-1.11.2.js"></script>
    <script src="js/bootstrap.min.js"></script>

</body>
</html>