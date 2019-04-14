<!DOCTYPE html> 
	
<html lang="fi">
<head>

  <title>Lähetykset</title>

  <meta http-equiv="X-UA-Compatible"   content="IE=edge"> 

  <meta name="viewport" content="width=device-width, initial-scale=1">

  <meta charset="UTF-8">

  <meta name="author" content="Aida">
  
  <script src="http://code.jquery.com/jquery-2.2.3.min.js"></script>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito">
  
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
<?php
if(isset($_GET ["value"] )) {
		$id = $_GET["value"];
	try {
		require_once "lahetysPDO.php";
		
		$kanta = new lahetysPDO();
		$tulos = $kanta->haeLahetysId($id);
		//kantakäsittely oliolle suoritetaan kaikkiIlmoitukset() metodi, joka keroo rivit kannasta
		
		//tietokannasta haetaan yksi rivi, kirjoitetaan se ilmoitukseen ja haetaan ilmoituksesta tyyppi
		foreach($tulos as $lahetys) { //käydään rivit läpi ja ilmoitus muuttujaan tehdään uusi ilmoitus
			print("<div class='center'><p><b>Lähettäjän tiedot:</b><br>Lähettäjän nimi: " . $lahetys->getYritysNimi());
			print("<br>Y-tunnus: " . $lahetys->getYtunnus());
			print("<br>Katuosoite: " . $lahetys->getLahOsoite());
			print("<br>Postinumero: " . $lahetys->getLahPostNum());
			print("<br>Postitoimipaikka: " . $lahetys->getLahPostTmp());
			print("<br>Sähköposti: " . $lahetys->getSposti());
			print("<br>Tilinumero: " . $lahetys->getTilinum());
			print("<br><b>Lähetyksen tiedot:</b><br>Lähetystunnus: " . $lahetys->getLahetystunnus());
			print("<br>Loppusumma: " . $lahetys->getSumma());
			print("<br>Tuotteet: " . $lahetys->getTuotteet());
			print("<br><b>Vastaanottajan tiedot:</b><br>Nimi: " . $lahetys->getVasNimi());
			print("<br>Katuosoite: " . $lahetys->getVasOsoite());
			print("<br>Postinumero: " . $lahetys->getVasPostNum());
			print("<br>Postitoimipaikka: " . $lahetys->getVasPostTmp());
			print("</p></div>");
		}
		
	} catch ( Exception $error ) {
		//print("<p>Virhe: " . $error->getMessage ());
		header ( "location: virhe.php?sivu=Listaus&virhe=" . $error->getMessage () ); //jos tulee poikkeus, ohjataan headerillä virhesivulle
		//exit ();
	}
}
?>
<form action='katsolahetys.php' method='post'>
<div class='center'>
<input type='submit' name='takaisin' value='Takaisin'>
</div></form>

<?php
if (isset ( $_POST ["takaisin"] )) {
		header ( "location: lahetykset.php" );
		exit ();
	}
?>

</article>

</body>

</html>

