<?php

$nimi = "";

if (isset($_POST["muutanimi"])) {
	$nimi = $_POST["kayttajanimi"];
	setcookie("nimikeksi", $nimi, time() + 60*60*24*7);
	header ( "location: index.php" );
	exit ();
}else{
	if (isset($_COOKIE["nimikeksi"])) {
		$nimi = $_COOKIE["nimikeksi"];
	}else{
		$nimi = "";
	}
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

<br>

<form action="asetukset.php" method="post">
	<div class="center">
		<div>
			<label>Nimi:</label>
			<input type="text" name="kayttajanimi" id="kayttajanimi" value="<?php print(htmlentities($nimi, ENT_QUOTES, 'UTF-8'))?>">
			<input type="submit" name="muutanimi" value="Muuta nimi">
		</div>
	</div>
</form>

</body>

</html>

