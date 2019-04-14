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
<br>
<div class='center'>
<table>
<tr>
<th>Lähettäjän nimi:</th>
<th>Vastaanottajan nimi:</th>
<th>Lähetystunnus:</th>
<th>Loppusumma:</th>
<th></th>
</tr>
<?php
require_once "lahetysPDO.php";

$kanta = new lahetysPDO();

function haeTiedot(){
	try {
		global $kanta;
		$rivit = $kanta->kaikkiLahetykset();
		foreach($rivit as $lahetys) { //käydään rivit läpi ja ilmoitus muuttujaan tehdään uusi ilmoitus
			$id = $lahetys->getId();
			print("<tr>");
			print("<form action='lahetykset.php' method='post'><td>" . $lahetys->getYritysNimi() . "</td>");
			print("<td>" . $lahetys->getVasNimi() . "</td>");
			print("<td>" . $lahetys->getLahetystunnus() . "</td>");
			print("<td>" . $lahetys->getSumma() . "</td>");
			print("<td><input type='hidden' name='id' value=" . $id . "><input type='submit' name='nayta' value='Näytä'><input type='submit' name='poista' value='Poista'></td></form>");
			print("</tr>");
		}
	} catch ( Exception $error ) {
		//print("<p>Virhe: " . $error->getMessage ());
		header ( "location: virhe.php?sivu=Listaus&virhe=" . $error->getMessage () ); //jos tulee poikkeus, ohjataan headerillä virhesivulle
		//exit ();
	}
}
	
if(isset ( $_POST ["nayta"] )) {
	$id = $_POST ["id"];
	header ( "location: katsolahetys.php?value=$id" );
	exit ();
}elseif (isset ( $_POST ["poista"] )) {
	$id = $_POST ["id"];
	global $kanta;
	$onnistui = $kanta->poistaLahetys($id);
	haeTiedot();
}else{
	haeTiedot();
}

?>
</table>
</div>

</body>

</html>
