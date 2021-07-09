<?php
    require '../function.php';

    $tempat_wisata = query("SELECT * FROM tempat_wisata");
	
?>

<!DOCTYPE html>
<html>
<head>
<script type="text/javascript">
	getOverall();

	function getOverall()
	{
		<?php

		$awal = "2021-01-01";
		$akhir = "2021-06-30";

		$query_overall = mysqli_query($conn, "SELECT SUM(total_kunjungan) as 'total_kunjungan' , SUM((total_kunjungan*tiket_masuk*1000)) as 'kotor'
		FROM tempat_wisata JOIN catatan_kunjungan c USING(id_tempat_wisata)
		WHERE c.tanggal_catatan BETWEEN '$awal' AND '$akhir'");

		if(mysqli_num_rows($query_overall) > 0)
		{
			while($row = mysqli_fetch_array($query_overall))
			{
				$gross = $row['kotor'];
				$visits = $row['total_kunjungan'];
		?>

		['<?php echo $gross; ?>', <?php echo $visits; ?>],
		
		<?php 	
			}
		}
		?>
	}
</script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
		google.charts.load('current', {'packages':['bar']});
		google.charts.load('current', {'packages':['line']});
		google.charts.setOnLoadCallback(drawChart);
		function drawChart() 
		{
			var button = document.getElementById('change-chart');
			var chartDiv = document.getElementById('chart_div');
			var data1 = google.visualization.arrayToDataTable([
				['Bulan', 'Taman Wisata Tirtoyoso', 'Goa Selomangleng', 'Pantai Parangtritis', 'Jatim Park 3', 'Dufan', 'Trans Studio Bandung', 'Gembira Loka'],
				['Januari', 30865000, 6965000, 44570000, 123130000, 151400000, 311350000, 28390000],
				['Februari', 27665000, 7790000, 44495000, 118480000, 104150000, 283400000, 24850000],
				['Maret', 29565000, 7940000, 48545000, 147430000, 152700000, 237100000, 34810000],
				['April', 32925000, 7880000, 51770000, 131590000, 136350000, 300250000, 24670000],
				['Mei', 34265000, 7475000, 48520000, 128380000, 139500000, 268100000, 35170000],
				['Juni', 31605000, 8300000, 59920000, 126190000, 142050000, 267100000, 26590000]
			]);
			var data2 = new google.visualization.DataTable();
			data2.addColumn('string', 'Bulan');
			data2.addColumn('number', 'Taman Wisata Tirtoyoso');
			data2.addColumn('number', 'Goa Selomangleng');
			data2.addColumn('number', 'Pantai Parangtritis');
			data2.addColumn('number', 'Jatim Park 3');
			data2.addColumn('number', 'Dufan');
			data2.addColumn('number', 'Trans Studio Bandung');
			data2.addColumn('number', 'Gembira Loka');

			data2.addRows([
				['Januari', 30865000, 6965000, 44570000, 123130000, 151400000, 311350000, 28390000],
				['Februari', 27665000, 7790000, 44495000, 118480000, 104150000, 283400000, 24850000],
				['Maret', 29565000, 7940000, 48545000, 147430000, 152700000, 237100000, 34810000],
				['April', 32925000, 7880000, 51770000, 131590000, 136350000, 300250000, 24670000],
				['Mei', 34265000, 7475000, 48520000, 128380000, 139500000, 268100000, 35170000],
				['Juni', 31605000, 8300000, 59920000, 126190000, 142050000, 267100000, 26590000]
			]);

			var materialOptions = {
				axes: {
					y: {
					gross: {label: 'Pendapatan Kotor'}, // Left y-axis.
					}
				}
			};
			var lineOptions = {
				width: 900,
				height: 500
			};
		
			chartDiv.style.marginLeft = "50px"
			chartDiv.style.marginTop = "50px"
			function drawMaterialChart() 
			{
				var materialChart = new google.charts.Bar(chartDiv);

				materialChart.draw(data1, google.charts.Bar.convertOptions(materialOptions));
				button.innerText = 'Ganti ke Line Chart';
				button.onclick = drawLineChart;
			}
			function drawLineChart() 
			{
				var lineChart = new google.charts.Line(chartDiv);

				lineChart.draw(data2, google.charts.Line.convertOptions(lineOptions));

				button.innerText = 'Ganti ke Bar Chart';
				button.onclick = drawMaterialChart;
			}
			drawMaterialChart();
		}
    </script>
	<meta charset="utf-8">
	<meta name="viewport" content="width-device-width, initial-scale=1">

	<link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../style.css">
	<script src="https://kit.fontawesome.com/9009871c45.js" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


	<title>Dashboard | Summary</title>
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
        <div class="shadow mt-3 mb-2 border rounded-top">
            <div class="bg-white col-sm-12 position-relative p-2 border-bottom">
                <h2 class="display-5 text-truncate judul1 mt-3 mb-3 ml-4">Dashboard</h1>
				</div>
			<div class="col-sm-12 position-relative bg-light border-bottom">
					<ul class="nav nav-pills">
						<li class="nav-item text-center">
							<a class="nav-link link-navbar tebel-sedang" href="dashboard.php">Daftar Tempat Wisata</a>
							<div class="garis"></div>
						</li>
						<li class="nav-item">
							<a class="nav-link active bg-active link-navbar tebel-sedang" href="summary.php">Summary</a>
						</li>
					</ul>
			</div>
			<div class="col-sm-12 position-relative mt-0 border-bottom pt-4 pb-5 justify-content-center">
				<ul class="nav nav-pills">
					<li class="ml-3 mr-5 nav-item text-left">
						<div class="shadow-sm col-sm-12 position-relative mb-3 ml-5 mt-3 border rounded">
							<h4 class="mt-2 ml-1 mb-1 display-5 text-truncate judul1">Total Pendapatan Kotor</h4>
							<p class="text-muted mb-0 ml-2"> <i>6 bulan terakhir</i></p>
							<h2 class="mt-0 ml-1 mb-4"><i> <?php echo "Rp " . number_format($gross, 2,',','.') ?> </i></h2>
						</div>
					</li>
					<li class="ml-4 nav-item text-left">
						<div class="shadow-sm col-sm-12 position-relative mb-3 ml-0 mt-3 pr-5 border rounded">
							<h4 class="mt-2 ml-1 mb-1 display-5 text-truncate judul1">Total Kunjungan</h4>
							<p class="text-muted mb-0 ml-2"> <i>6 bulan terakhir</i></p>
							<h2 class="mt-0 ml-1 mb-4"><i><?php echo number_format($visits, 0,'.','.') . " Kunjungan" ?></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h2>
						</div>
					</li>
				</ul>
				<div class="clearfix"></div>
				<!--Komparasi Gross-->
				<h3 class="ml-5 mb-0 display-5 text-truncate judul1">Komparasi Pendapatan Kotor</h4>
				<p class="text-muted mb-1 ml-5"> <i>6 bulan terakhir</i></p>
				<button class="ml-5 bg-custom badge badge-primary tebel-sedang shadow tengahin-tombol pl-3 pr-3" id="change-chart">Ganti ke Line Chart</button>
				<div class="container" id="chart_div" style="width: 1000px; height: 500px;"></div>

				<!-- Tabel overall-->
				<h3 class="ml-5 mb-0 display-5 text-truncate judul1 mt-5">Tabel Tempat Wisata</h4>
				<p class="text-muted mb-1 ml-5"> <i>6 bulan terakhir</i></p>
				<table class="table table-hover table-bordered col-sm-10 ml-5">
				<thead class="thead-light">
					<tr>
						<th scope="col">No.</td>
						<th scope="col">Nama Tempat Wisata</td>
						<th scope="col">Total Kunjungan</td>
						<th scope="col">Total Pendapatan Kotor</td>
					</tr>
				<tbody>
					<?php
					$query_table = mysqli_query($conn, "SELECT id_tempat_wisata as 'idTW', nama as 'namaTW', SUM(total_kunjungan) as 'visitTW', SUM((total_kunjungan*tiket_masuk*1000)) as 'grossTW' 
														FROM tempat_wisata JOIN catatan_kunjungan USING(id_tempat_wisata) GROUP BY id_tempat_wisata");

					if(mysqli_num_rows($query_table) > 0)
					{
						while($row = mysqli_fetch_array($query_table))
						{
						?>
							<tr>
								<td><?php echo $row['idTW']?></td>
								<td><?php echo $row['namaTW']?></td>
								<td><?php echo number_format($row['visitTW'], 0,'.','.') ?></td>
								<td><?php echo "Rp " . number_format($row['grossTW'], 2,',','.')?></td>
							</tr>		
					<?php 	
						}
					}
					?>
				</tbody>
				</table>
			</div>
        </div>
    </div>

	
    <script src="js/jquery-1.11.2.js"></script>
    <script src="js/bootstrap.min.js"></script>
	
</body>
</html>