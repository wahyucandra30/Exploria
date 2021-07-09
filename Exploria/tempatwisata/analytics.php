<?php
    require '../function.php';

	// tangkep id
    $id = $_GET["id"];

    //query tempat wisata
    $result = mysqli_query($conn, "SELECT * FROM ulasan JOIN tempat_wisata USING(id_tempat_wisata) JOIN pengunjung USING(id_pengunjung) WHERE id_tempat_wisata = $id"); 
	$tempat_wisata = mysqli_fetch_assoc($result);

    
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



    <!-- Script Chart -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

	<!-- Kilasan -->
	<script type="text/javascript">
		drawGross();
		drawAVG();
		drawMinMax();
		drawRatingSummary();
		function drawGross()
		{
			<?php
				$ambil_kotor = mysqli_query($conn, "SELECT total_kunjungan, tiket_masuk, operasional, id_tempat_wisata 
				FROM catatan_kunjungan JOIN tempat_wisata USING(id_tempat_wisata) 
				WHERE id_tempat_wisata = $id");

				//$total_untung = 1;
				if(mysqli_num_rows($ambil_kotor) > 0){
					while($row = mysqli_fetch_array($ambil_kotor)){
						$tiket_masuk = $row['tiket_masuk'];
						$biaya_operasional = $row['operasional'];
						$total_kunjungan = $row['total_kunjungan'];
						$hasil_untung = ($tiket_masuk * $total_kunjungan);  
						$total_untung += $hasil_untung;
			?>

			['<?php echo $total_untung; ?>'],
			
			<?php 	
				}
			}
			?>
		}
		function drawAvg()
		{
			<?php
				$ambil_rerata = mysqli_query($conn, "SELECT AVG(total_kunjungan) as rerata, id_tempat_wisata FROM catatan_kunjungan
				WHERE id_tempat_wisata = $id");

				if(mysqli_num_rows($ambil_rerata) > 0){
					while($row = mysqli_fetch_array($ambil_rerata)){
						$aver = $row['rerata'];
			?>

			['<?php echo $aver; ?>'],
			
			<?php 	
				}
			}
			?>
		}

		function drawMinMax()
		{
			<?php
				$ambil_minmax = mysqli_query($conn, "SELECT MIN(total_kunjungan) as minimal, MAX(total_kunjungan) as maksimal, id_tempat_wisata FROM catatan_kunjungan
				WHERE id_tempat_wisata = $id");

				if(mysqli_num_rows($ambil_minmax) > 0){
					while($row = mysqli_fetch_array($ambil_minmax)){
						$min = $row['minimal'];
						$max = $row['maksimal'];
			?>

			['<?php echo $min; ?>', <?php echo $max; ?>],
			
			<?php 	
				}
			}
			?>
		}
		function drawRatingSummary()
		{
			<?php
				$ambil_rsmr = mysqli_query($conn, "SELECT COUNT(id_ulasan) as jumlahulasan , AVG(nilai) as reratanilai, id_tempat_wisata FROM ulasan
				WHERE id_tempat_wisata = $id");

				if(mysqli_num_rows($ambil_rsmr) > 0){
					while($row = mysqli_fetch_array($ambil_rsmr)){
						$rcntr = $row['jumlahulasan'];
						$raver = $row['reratanilai'];
			?>

			['<?php echo $rcntr; ?>', <?php echo $raver; ?>],
			
			<?php 	
				}
			}
			?>
		}

	</script>

	<!-- Script Chart Pengunjung -->
    <script type="text/javascript">
	
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      
	  function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Tanggal', 'Jumlah Kunjungan'],
          <?php
			if(isset($_POST["inputtahun"])){
				$awal = $_POST['awal'];
				$akhir = $_POST['akhir'];
			}  
			else{
				$awal = "2021-06-01";
				$akhir = "2021-06-30";
			}
			
	        $ambil_data = mysqli_query($conn, "SELECT DATE_FORMAT(tanggal_catatan, '%d') as tanggal, total_kunjungan, id_tempat_wisata FROM catatan_kunjungan JOIN tempat_wisata USING(id_tempat_wisata) 
			WHERE id_tempat_wisata = $id AND (tanggal_catatan BETWEEN '$awal' AND '$akhir') ORDER BY tanggal_catatan ASC");

			if(mysqli_num_rows($ambil_data) > 0){
				while($row = mysqli_fetch_array($ambil_data)){
					$tanggal = $row['tanggal'];

					$jml_kunjungan = $row['total_kunjungan'];
          ?>

		  ['<?php echo $tanggal; ?>', <?php echo $jml_kunjungan; ?>],
		  
		  <?php 	
		  		}
			}
			?>
        ]);

        var options = {
          title: 'Data Banyaknya Pengunjung <?= $awal ?> Sampai Dengan <?= $akhir ?>',
          //curveType: 'function', //ilangi tanda // ning pojok kiri line iki nek rep gae chart e men isoh curve
		  chartArea:{left:75,top:50,width:"90%",height:"75%"},
          //legend: { position: 'bottom' },
		  legend: { position: "none" },
		  hAxis: 
			{
				title: 'Tanggal',
				minValue: 0
			},
			vAxis: 
			{
				title: 'Jumlah Pengunjung'
			}
        };

        var chart = new google.visualization.LineChart(document.getElementById('line_chart'));
        chart.draw(data, options);
      }
    </script>

 <!-- Script data keuntungan -->
<script type="text/javascript">
	
	google.charts.load('current', {'packages':['corechart']});
	google.charts.setOnLoadCallback(drawChart1);

	
	function drawChart1() {
	  var data = google.visualization.arrayToDataTable([
		['Bulan', 'Keuntungan', { role: 'style' }],
		<?php
		$keuntunganawal = "2021-01-01";
		$keuntunganakhir = "2021-06-30";
		  
		  $query_keuntungan = mysqli_query($conn, "SELECT tanggal_catatan, MONTH(tanggal_catatan) as bulan,SUM(total_kunjungan) as totKunjungan, tiket_masuk, operasional, id_tempat_wisata
		  FROM catatan_kunjungan JOIN tempat_wisata USING(id_tempat_wisata) 
		  WHERE id_tempat_wisata = $id
          GROUP BY MONTH(tanggal_catatan)
		  ORDER BY tanggal_catatan ASC");

		  if(mysqli_num_rows($query_keuntungan) > 0){
			  while($row = mysqli_fetch_array($query_keuntungan)){
				  $tanggal = $row['tanggal_catatan'];
				  if($row['bulan'] == 1)
				  {
					$bulan = "Januari";
				  }
				  if($row['bulan'] == 2)
				  {
					$bulan = "Februari";
				  }
				  if($row['bulan'] == 3)
				  {
					$bulan = "Maret";
				  }
				  if($row['bulan'] == 4)
				  {
					$bulan = "April";
				  }
				  if($row['bulan'] == 5)
				  {
					$bulan = "Mei";
				  }
				  if($row['bulan'] == 6)
				  {
					$bulan = "Juni";
				  }
				  $tiket_masuk = $row['tiket_masuk'];
				  $biaya_operasional = $row['operasional'];
				  $total_kunjungan = $row['totKunjungan'];
				  $hasil_untung = ($tiket_masuk * $total_kunjungan);
		?>

		['<?php echo $bulan; ?>', <?php echo $hasil_untung; echo "000"; ?>, 'stroke-color: #871B47; stroke-opacity: 0.6; stroke-width: 3; fill-color: #BC5679; fill-opacity: 0.2'],
		
		<?php 	
				
				}
		  }
		  ?>
	  ]);

	  var options = {
		//curveType: 'function', //ilangi tanda // ning pojok kiri line iki nek rep gae chart e men isoh curve
		chartArea:{left:75,top:50,width:"90%",height:"75%"},
		//legend: { position: 'bottom' },
		legend: { position: "none" },
		hAxis: 
		{
			title: 'Bulanan',
			minValue: 0
		},
		vAxis: 
		{
			title: 'Keuntungan'
		}
	  };

	  var chart = new google.visualization.ColumnChart(document.getElementById('curve_chart'));
	  chart.draw(data, options);
	}
  </script>

  <script type="text/javascript">
	google.charts.load('current', {packages: ['corechart', 'bar']});
	google.charts.setOnLoadCallback(drawMultSeries);

	function drawMultSeries() {
		var data = google.visualization.arrayToDataTable([
			['Rating', 'Jumlah Rating'],
			<?php 
				$query_rating = mysqli_query($conn, "SELECT nilai, COUNT(id_pengunjung) AS jumlah_rating FROM ulasan WHERE id_tempat_wisata = $id GROUP BY nilai ORDER BY nilai DESC");

				if(mysqli_num_rows($query_rating) > 0){
					while($row = mysqli_fetch_array($query_rating)){
						$nilai = $row['nilai'];
						$jumlah_rating = $row['jumlah_rating'];
					
			?>
			['<?php echo $nilai; ?>', <?php echo $jumlah_rating ?>],

			<?php 
					}
				}
			?>
		]);

		var options = {
			title: '',
			chartArea: {width: '50%'},
			hAxis: {
			title: 'Banyak Nilai Rating',
			minValue: 0
			},
			vAxis: {
			title: 'Rating'
			}
		};

		var chart = new google.visualization.BarChart(document.getElementById('chart_div'));
		chart.draw(data, options);
		}
  </script>


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
        <div class="shadow mt-3 mb-5 border rounded-top">
            <!-- Nama Tempat Wisata -->
            <div class="bg-light col-sm-12 position-relative p-2 border-bottom">
            <h4 class="ml-4 display-5 text-truncate"><strong>Analytics</strong> > <i><?= $tempat_wisata["nama"]; ?></i></h1>
                <!-- <div class="hr"></div> -->
				</div>

				<!-- Tombol Analytics, Review -->
				<div class="col-sm-12 mt-1 mb-2 pt-3 pb-3 border-bottom">
					<ul class="nav nav-pills">
						<li class="ml-3 nav-item text-center">
							<h2 ><?php echo "Rp " . number_format($total_untung, 3,'.','.') ?></h2>
							<h7 style="color: grey">Pendapatan Kotor</h7>
						</li>
						<li class="ml-4 nav-item text-center">
							<h2 ><?= round($aver) ?></h2>
							<h7 style="color: grey">Rerata Kunjungan</h7>
						</li>
						<li class="ml-5 nav-item text-center">
							<h2 ><?= $min ?></h2>
							<h7 style="color: grey">Minimal Kunjungan</h7>
						</li>
						<li class="ml-5 nav-item text-center">
							<h2 ><?= round($max) ?></h2>
							<h7 style="color: grey">Maksimal Kunjungan</h7>
						</li>
						<li class="ml-5 nav-item text-center">
							<h2 ><?= round($raver) ?></h2>
							<h7 style="color: grey">Rerata Nilai</h7>
						</li>
						<li class="ml-5 nav-item text-center">
							<h2 ><?= round($rcntr) ?></h2>
							<h7 style="color: grey">Jumlah Ulasan</h7>
						</li>
					</ul>
				</div>

                <!--Tampilkan Chart Jumlah Pengunjung Selama Waktu Tertentu-->
				<h3 class="ml-5 mb-3 display-5 text-truncate judul1">Data Jumlah Pengunjung</h3>
				<form action="" method="post" id="param-waktu" name="param-waktu" class="ml-5">
					<label for="" class="mr-2 font-weight-bold">Awal</label>
	  				<input type="date" name="awal" value="2021-06-01" class="mr-3 p-1 rounded">
					<label for="" class="mr-2 font-weight-bold">Akhir</label>
	  				<input type="date" name="akhir" value="2021-06-30" class="mr-3 p-1 rounded">
					<button type="submit" name="inputtahun">Submit</button>
				</form>
                <div class="container" id="line_chart" style="width: 1100px; height: 400px;"></div>

				<h3 class="ml-5 mb-3 mt-5 display-5 text-truncate judul1">Data Keuntungan</h3>
				<div class="container" id="curve_chart" style="width: 1100px; height: 400px;"></div>

				<h3 class="ml-5 mb-3 mt-5 display-5 text-truncate judul1">Data Nilai Rating</h3>
				<div class="container" id="chart_div" style="width: 1100px; height: 400px;"></div>

			</div>
       	</div>

    </div>
	<script type="text/javascript">
		document.getElementById("waktu-catatan").submit();
	</script>


	


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