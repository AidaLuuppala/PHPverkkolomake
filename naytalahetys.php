<?php
require_once "lahetys.php";
require_once "lahetysPDO.php";
session_start();

if(isset($_SESSION["lahetys"])){ //jos istunnossa on olio
	$lahetys = $_SESSION["lahetys"]; //sijoitetaan istunnosta löytyvät tiedot olioon
	
	if (isset ( $_POST ["korjaa"] )) {
		header ( "location: uusilahetys.php" );
		exit ();
	}
	elseif (isset ( $_POST ["tallenna"] )) {
		$kanta = new lahetysPDO();
		$onnistui = $kanta->lisaaLahetys($lahetys);
		if ($onnistui = true){
			unset($_SESSION["lahetys"]); //poistetaan lahetys istunnosta
			$tallennettu = "Tiedot tallennettu!";
			header ( "location: index.php?viesti=$tallennettu" );
			exit ();
		}
	} 
	elseif (isset ( $_POST ["peruuta"] )) { //jos painetaan poista nappia
		unset($_SESSION["lahetys"]); //poistetaan lahetys istunnosta
		header ( "location: index.php" );
		exit ();
	}
}else{ //jos ei, niin lähetetään käyttäjä etusivulle
	header("location: index.php");
	exit();
}
?>
<!DOCTYPE html> 
	
<html lang="fi">
<head>

  <title>Lähetykset</title>

  <meta http-equiv="X-UA-Compatible"   content="IE=edge"> 

  <meta name="viewport" content="width=device-width, initial-scale=1">

  <meta charset="UTF-8">

  <meta name="author" content="Aida">
  
  <script src="http://code.jquery.com/jquery-2.2.3.min.js"></script>
    
  <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

  <link href="style.css" rel="stylesheet" type="text/css">
  
  <link rel="icon" href="kuvat/favicon.ico" type="image/x-icon" />

</head>

<body>

<header>

<div>
	<a href="index.php">
		<h1>LÄHETYSTEN KIRJAAMINEN</h1>
	</a>
</div>

<div class="center">
	<nav>
		<a href="index.php">ETUSIVU</a>
		<a href="uusilahetys.php">UUSI LÄHETYS</a>
		<a href="lahetykset.php">LÄHETYKSET</a>
		<a href="haelahetys.php">HAE LÄHETYS</a>
		<a href="asetukset.php">ASETUKSET</a>
	</nav>
</div>

</header>

<article>
	<h3 style="text-align: center">Lähetyksen tiedot</h3>
	<fieldset>
		<legend>Lähettäjän tiedot:</legend>
			<?php
			print("<p> Yrityksen nimi: " . $lahetys->getYritysNimi());
			print("<br> Y-tunnus: " . $lahetys->getYtunnus());
			print("<br> Katuosoite: " . $lahetys->getLahOsoite());
			print("<br> Postinumero: " . $lahetys->getLahPostNum());
			print("<br> Postitoimipaikka: " . $lahetys->getLahPostTmp());
			print("<br> Sähköposti: " . $lahetys->getSposti());
			print("<br> Tilinumero: " . $lahetys->getTilinum() . "</p>\n");
			?>
	</fieldset>
	<fieldset>
		<legend>Lähetyksen tiedot:</legend>
			<?php
			print("<p> Lähetystunnus: " . $lahetys->getLahetystunnus());
			print("<br> Loppusumma: " . $lahetys->getSumma());
			print("<br> Lähetyksen tuotteet: " . $lahetys->getTuotteet() . "</p>\n");
			?>
	</fieldset>
	<fieldset>
		<legend>Vastaanottajan tiedot:</legend>
			<?php
			print("<p> Nimi: " . $lahetys->getVasNimi());
			print("<br> Katuosoite: " . $lahetys->getVasOsoite());
			print("<br> Postinumero: " . $lahetys->getVasPostNum());
			print("<br> Postitoimipaikka: " . $lahetys->getVasPostTmp() . "</p>\n");
			?>
	</fieldset>
</article>
<br>
<form action="naytalahetys.php" method="post">
	<div class="btn">
		<input type="submit" name="korjaa" value="Korjaa">
		<input type="submit" name="tallenna" value="Tallenna">
		<input type="submit" name="peruuta" value="Peruuta">
	</div>
</form>
<br>

</body>

</html>

