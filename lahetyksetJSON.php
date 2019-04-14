<?php
try {
	require_once "lahetysPDO.php";
	$kanta = new lahetysPDO();
	
	if(!empty($_GET["hakusana"])){
		$hakusana = $_GET["hakusana"];
		$tulos = $kanta->haeLahetys($hakusana);
		echo json_encode($tulos);
	} else {
		$tulos = $kanta->kaikkiLahetykset();
		echo json_encode($tulos);
	}
} catch (Exception $error) {
	echo("Ei onnistu!" . $error);
}
?>