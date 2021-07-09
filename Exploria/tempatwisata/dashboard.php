<?php
    require '../function.php';

    $tempat_wisata = query("SELECT * FROM tempat_wisata");
	
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width-device-width, initial-scale=1">

	<link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../style.css">
	<script src="https://kit.fontawesome.com/9009871c45.js" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


	<title>Dashboard | Daftar Tempat Wisata</title>
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
						<!-- <a class="nav-link bg-custom rounded-pill tebel-sedang shadow" id="btn-sign" href="dashboard.php">Tampilkan Database</a> -->
						<a class="nav-link active bg-active link-navbar tebel-sedang" href="dashboard.php">Dashboard</a>
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
        <div class="shadow mt-3 mb-5 border rounded-top">
            <!-- Nama Tempat Wisata -->
            <div class="bg-white col-sm-12 position-relative p-2 border-bottom">
                <h2 class="display-5 text-truncate judul1 mt-3 mb-3 ml-4">Dashboard</h1>
				</div>
			<div class="col-sm-12 position-relative bg-light border-bottom">
					<ul class="nav nav-pills">
						<li class="nav-item text-center">
							<a class="nav-link active bg-active link-navbar tebel-sedang" href="dashboard.php">Daftar Tempat Wisata</a>
							<div class="garis"></div>
						</li>
						<li class="nav-item">
							<a class="nav-link link-navbar tebel-sedang" href="summary.php">Summary</a>
						</li>
					</ul>
			</div>
			<div class="col-sm-7 position-relative p-4">
			<?php 
				$query_card = mysqli_query($conn, "SELECT id_tempat_wisata, AVG(nilai) as bintang, id_foto as foto, deskripsi, nama, nama_file
				FROM tempat_wisata JOIN ulasan USING(id_tempat_wisata) JOIN slideshow USING(id_tempat_wisata) JOIN foto USING(id_foto) WHERE id_foto > '39' GROUP BY id_tempat_wisata");
				
				//$result_card = mysqli_fetch_assoc($query_card);

				if(mysqli_num_rows($query_card) > 0){
					while($row = mysqli_fetch_array($query_card)){
						$wisataid = $row['id_tempat_wisata'];
						$rating = $row['bintang'];
						$fotoid = $row['foto'];
						$deskripsi = $row['deskripsi'];
						$namawisata = $row['nama'];
						$namafoto = $row['nama_file'];
			?>
			
				
				<div class="col-sm-12 position-relative border mb-4">
					<div class="card pull-left ml-0" style="width: 200px;">
						<img class="card-img-top ml-0" src="<?php echo $row['nama_file']; ?>" alt="Card image cap" height="125px">
					</div>
					<h4 class="display-5 text-truncate judul1 link-a 	pl-4 mt-3"><a class="display-5 text-truncate judul1 link-a" href="review.php?id=<?= $wisataid; ?>"> <?= $namawisata; ?> </a></h1>
					<h4 class="display-5 text-truncate pl-4 mt-2">⭐ <?= round($rating, 1, 0); ?></h1>
					<div class="d-flex justify-content-end">
						<ul class="nav nav-pills">
							<li class="nav-item">
								<a href="analytics.php?id=<?= $wisataid ?>" class="bg-custom badge badge-primary tebel-sedang shadow tengahin-tombol">Analytics &nbsp;&nbsp;</a>
							</li>
						</ul>
					</div>
					<div class="clearfix"></div>
					
					

					<!-- <div class="desc mt-4">
					</div> -->
				</div>
				<?php } } ?>
            </div>
        </div>
    </div>

	
    <script src="js/jquery-1.11.2.js"></script>
    <script src="js/bootstrap.min.js"></script>
	
</body>
</html>