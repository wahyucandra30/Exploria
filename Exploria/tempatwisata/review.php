<?php
    require '../function.php';

	// tangkep id
    $id = $_GET["id"];

	// Untuk query tempat wisata
	$result = mysqli_query($conn, "SELECT * FROM ulasan JOIN tempat_wisata USING(id_tempat_wisata) JOIN pengunjung USING(id_pengunjung) WHERE id_tempat_wisata = $id"); 
	$tempat_wisata = mysqli_fetch_assoc($result);
	$query_rerata = "SELECT AVG(nilai) AS rerata FROM ulasan WHERE id_tempat_wisata = $id";
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
        <div class="mt-5 mb-5">

            <!-- Nama Tempat Wisata -->
            <div class="col-sm-12 position-relative p-4">

				<!-- Slideshow foto -->
				
				<div id="carouselExampleControls" class="carousel slide bg-dark" data-ride="carousel">
				<div class="carousel-inner">
					<?php 
						$query_fotoAktif = "SELECT nama_file AS fileFoto FROM foto JOIN slideshow USING(id_foto) WHERE id_tempat_wisata = $id LIMIT 1";
						$fotoAktif_result = mysqli_query($conn, $query_fotoAktif);
						while($row = mysqli_fetch_assoc($fotoAktif_result)){
							$output_fotoAktif = $row['fileFoto'];
					?>

					<div class="carousel-item active" style="margin-left: 17%;">
						<img class="d-block" src="<?= $output_fotoAktif ?>" width="700px" height="400px"> 
					</div>
					<?php } ?>
					<?php 
						$query_foto = "SELECT nama_file AS fileFoto FROM foto JOIN slideshow USING(id_foto) WHERE id_tempat_wisata = $id 
						AND nama_file != (SELECT nama_file FROM foto JOIN slideshow USING(id_foto) WHERE id_tempat_wisata = $id LIMIT 1)";
						$foto_result = mysqli_query($conn, $query_foto);
						while($row = mysqli_fetch_assoc($foto_result)){
							$output_foto = $row['fileFoto'];
						?>
					<div class="carousel-item "style="margin-left: 17%;">
						<img class="d-block" src="<?= $output_foto ?>" width="700px" height="400px">
					</div>
					<?php } ?>
				</div>
				<a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
					<span class="carousel-control-prev-icon" style="left: 500px;" aria-hidden="true"></span>
					<span class="sr-only">Previous</span>
				</a>
				<a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
					<span class="carousel-control-next-icon" aria-hidden="true"></span>
					<span class="sr-only">Next</span>
				</a>
				</div>
				
				<!-- Nama Tempat -->
				<div class="col-sm-12 mt-3 mb-5 d-flex flex-row">
					<h1 class="display-5 text-truncate judul1 mt-4"><?= $tempat_wisata["nama"]; ?></h1>
					<!-- Tombol Analytics, Review -->
					<div class="d-flex justify-content-end">
						<ul class="nav nav-pills" style="margin-left: 70px;margin-top: 33px;">
							<li class="nav-item">
								<a href="analytics.php?id=<?= $id ?>" class="bg-custom badge badge-primary tebel-sedang shadow tengahin-tombol">Analytics &nbsp;&nbsp;</a>
							</li>
						</ul>
					</div>
				</div>
				
				<?php
					$rerata_result = mysqli_query($conn, $query_rerata);
					while($row = mysqli_fetch_assoc($rerata_result)){
						$output = $row['rerata'];
					}
				?>

				<div class="tengahin-tombol d-flex flex-row" style="margin-top: -30px;">
					<div class="rateyo tengahin-kata" id= "rating"
					data-rateyo-rating="5"
					data-rateyo-num-stars="1"
					data-rateyo-score="1">
					</div>
					<p style="margin-left: 14px; margin-top: 4px;"><b><?= round($output, 1, 0); ?></b></p>
				</div>

				<div class="desc mt-4">
					<p><strong>Harga Tiket:  </strong><i>Rp <?= $tempat_wisata["tiket_masuk"]; ?>,00</i></p>
				</div>
				<div class="desc mt-4">
					<p><?= $tempat_wisata["deskripsi"]; ?></p>
				</div>
				
				
				
				<!-- Review Tempat -->
				<h2 class="mt-5 display-5 text-truncate judul1">Hasil Review</h4>
				<?php $review = query("SELECT * FROM ulasan JOIN tempat_wisata USING(id_tempat_wisata) JOIN pengunjung USING(id_pengunjung) WHERE id_tempat_wisata = $id"); ?>
				<?php foreach ($review as $row) : ?>
				<div class="container batas mb-3">
					<div class="d-flex mt-2">
						<h4 class="display-6 text-truncate judul1"><?= $row["nama_depan"]; ?> <?= $row["nama_belakang"]; ?></h4>
						<h6 class="display-6 text-truncate judul1" style="margin-top: 9px; margin-left: 10px; color:#797979; font-size:13px;">(<?= $row["alamat_email"]; ?>)</h6>
					</div>
					<div class="rateyo" id= "rating"
        			data-rateyo-rating="<?= $row["nilai"]; ?>"
         			data-rateyo-num-stars="5"
         			data-rateyo-score="1">
         			</div>
					 <hr>
					<h6 class="display-6 text-truncate judul1 container" style="margin-top: -4px;"><?= $row["subjek_ulasan"]; ?></h6>
					<p class="container"><?= $row["isi_ulasan"]; ?></p>
				</div>
				<?php endforeach; ?>

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