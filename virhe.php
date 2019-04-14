<?php
session_start ();

unset ( $_SESSION ["lahetys"] );

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
<?php
if (isset ( $_GET ["virhe"] )) { //löytyykö selaimen osoiterivista virhe
	$virhe = $_GET ["virhe"]; //jos on, otetaan se
} else {
	$virhe = "Tuntematon virhe"; //muuten tuntematon virhe
}

//näytetään virhe
print ("<p style='margin-top:1cm'>$virhe <br><br>Siirrytään etusivulle 5 sekunnin kuluttua...</p>") ;

?>
</article>
</body>

</html>

<?php
header ( "refresh:5; url=index.php?virhe=kylla" ); //viiden sekunnin kuluttua, siirry etusivulle
exit ();
?>

