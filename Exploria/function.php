<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "exploria_timhoreee";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

function query($query){
	
	global $conn;
	$result = mysqli_query($conn, $query);
	$rows = [];
	while($row = mysqli_fetch_assoc($result)){
		$rows[] = $row;
	}
	return $rows;
}

function tampilchart($data){
	global $conn;

	$awal = $data["awal"];
	$akhir = $data["akhir"];
}
?>