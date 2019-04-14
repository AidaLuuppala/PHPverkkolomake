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

<section>
<br>
<?php
if (isset($_GET["viesti"])) {
	print("<h2>" . $_GET["viesti"] . "</h2>");
}else {
	if (isset($_COOKIE["nimikeksi"])) {
	$nimi = $_COOKIE["nimikeksi"];
	print("<h2>Tervetuloa " . $nimi . "!</h2>");
	}else{
		print("<h2>Tervetuloa!</h2>");
	}
}
?>
<br>

<div class="center">
<div class="container">
<div>
		<a href="uusilahetys.php">
		<img src="kuvat/uusilahetys.png" alt="uusi lähetys" style="width:30%; height:30%;">
		<p class="etusivu">Kirjaa uusi lähetys.</p>
		</a>
</div>
<div>
		<a href="lahetykset.php">
		<img src="kuvat/lahetykset.png" alt="lähetykset" style="width:30%; height:30%;">
		<p class="etusivu">Katso ja hallinnoi lähetyksiä.</p>
		</a>
</div>

<div>
		<a href="asetukset.php">
		<img src="kuvat/asetukset.png" alt="asetukset" style="width:30%; height:30%;">
		<p class="etusivu">Muuta asetuksia.</p>
		</a>
</div>
</div>
</div>

</section>

</body>

</html>