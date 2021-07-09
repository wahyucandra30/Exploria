<?php
    require '../function.php';

	// tangkep id
    $id = $_GET["id"];

	// Untuk query tempat wisata
	$result = mysqli_query($conn, "SELECT * FROM ulasan JOIN tempat_wisata USING(id_tempat_wisata) JOIN pengunjung USING(id_pengunjung) WHERE id_tempat_wisata = $id"); 
	$tempat_wisata = mysqli_fetch_assoc($result);

	//Query untuk Slideshow tempat wisata
	$foto = mysqli_query($conn, "SELECT id_foto, nama_file FROM foto JOIN slideshow USING(id_foto) WHERE id_tempat_wisata = $id");
	$foto_ambil = mysqli_fetch_array($foto);

	// Query untuk review
	$review = query("SELECT * FROM ulasan JOIN tempat_wisata USING(id_tempat_wisata) JOIN pengunjung USING(id_pengunjung) WHERE id_tempat_wisata = $id");
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width-device-width, initial-scale=1">

	<link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../style.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css">
	<script src="https://kit.fontawesome.com/9009871c45.js" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


	<title></title>
</head>
<body>

	<!-- Navbar -->
	<nav class="shadow-sm navbar navbar-expand-lg navbar-white bg-white fixed-top mt-0 pb-0 border-bottom" id="navbar">
		<div class="container">
			<a class="navbar-brand" href="#">
				<img src="../img/logo.png" height="35px">
			</a>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
				aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>	
			</button>
			<div class="collapse navbar-collapse justify-content-end" id="navbarNav">
				<ul class="nav nav-pills">
					<li class="nav-item">
						<a class="nav-link link-navbar tebel-sedang" href="../index.php">Home &nbsp;&nbsp;</a>
						<div class="garis"></div>
					</li>
					<li class="nav-item">
						<!-- <a class="nav-link bg-custom rounded-pill tebel-sedang shadow" id="btn-sign" href="tampilandatabase.php">Tampilkan Database</a> -->
						<a class="nav-link bg-active link-navbar tebel-sedang" href="dashboard.php">Dashboard</a>
					</li>
					<li class="nav-item">
						<a class="nav-link link-navbar tebel-sedang" href="#"><i class="fas fa-user"></i>Pegawai A &nbsp;&nbsp;</a>
					</li>
				</ul>
			</div>
		</div>
	</nav>

    <!-- Isi Konten -->
    <div class="container konten">
        <br>
        <br>
        <br>
        <div class="mt-5 mb-5">

            <!-- Nama Tempat Wisata -->
            <div class="col-sm-12 position-relative p-4">
            <h1 class="display-5 text-truncate judul1"><?= $tempat_wisata["nama"]; ?></h1>
                <div class="hr"></div>

				<div class="desc mt-4">
					<p><?= $tempat_wisata["deskripsi"]; ?></p>
				</div>
				

				<!-- Tombol Analytics, Review -->
				<div class="col-sm-12 mt-5 mb-5">
					<ul class="nav nav-pills">
						<li class="nav-item">
							<a href="analytics.php?id=<?= $id ?>" class="bg-custom rounded-pill tebel-sedang shadow tengahin-tombol">Analytics &nbsp;&nbsp;</a>
						</li>
						<li class="nav-item">
							<a href="review.php?id=<?= $id ?>" class="bg-custom rounded-pill tebel-sedang shadow tengahin-tombol">Review &nbsp;&nbsp;</a>
						</li>
					</ul>
				</div>
			</div>
       	</div>

    </div>


	

	<!-- Footer -->
	<div class="container bagian-footer">
		<div class="col-lg-12 position-relative p-4">
			<h1 class="text-truncate tebel-sedang judul-footer">Kontak Kami</h1>
		</div>
		<div class="col-lg-12 d-flex flex-row">
			<div class="d-flex flex-row">
				<div class="col-lg-12 desc-footer2">
					<ul>
						<li class="desc-footer">19523059@students.uii.ac.id</li>
						<li class="desc-footer">19523059@students.uii.ac.id</li>
						<li class="desc-footer">19523059@students.uii.ac.id</li>
						<li class="desc-footer">19523059@students.uii.ac.id</li>
						<li class="desc-footer">19523059@students.uii.ac.id</li>
					</ul>
				</div>
				<div class="col-lg-12 desc-footer2">
					<ul>
						<li class="desc-footer">19523059@students.uii.ac.id</li>
						<li class="desc-footer">19523059@students.uii.ac.id</li>
						<li class="desc-footer">19523059@students.uii.ac.id</li>
						<li class="desc-footer">19523059@students.uii.ac.id</li>
						<li class="desc-footer">19523059@students.uii.ac.id</li>
					</ul>
				</div>
			</div>
		</div>

	</div>
	<script src="../js/jquery-1.11.2.js"></script>
    <script src="../js/bootstrap.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.js"></script>
 
	<script>
 
 
    $(function () {
        $(".rateyo").rateYo().on("rateyo.init", function (e, data) {
            var rating = data.rating;
            $(this).parent().find('.score').text('score :'+ $(this).attr('data-rateyo-score'));
            $(this).parent().find('.result').text('rating :'+ rating);
            $(this).parent().find('input[name=rating]').val(rating); //add rating value to input field
        });
    });
 
	</script>
</body>
</html>