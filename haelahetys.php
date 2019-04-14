<!DOCTYPE html> 
	
<html lang="fi">
<head>

  <title>Lähetykset</title>

  <meta http-equiv="X-UA-Compatible"   content="IE=edge"> 

  <meta name="viewport" content="width=device-width, initial-scale=1">

  <meta charset="UTF-8">

  <meta name="author" content="Aida">
  
  <script src="http://code.jquery.com/jquery-2.2.3.min.js" integrity="sha256-a23g1Nt4dtEYOj7bR+vTu7+T8VP13humZFBJNIYoEJo=" crossorigin="anonymous"></script>
  
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito">

  <link rel="stylesheet" href="style.css" type="text/css">
  
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
<form action='' method='post'>
<div class="center">
  <label>Hakusana: </label>&nbsp;
  <input type="text" name="hakusana" id="hakusana">&nbsp;
  <input type="button" id="hae" value="Hae">
</div>
</form>
<br>
<div id="lista"></div>

<script type="text/javascript">

	$(document).on("ready", function() {
		
		$("#hae").on("click", function() {
			
			$.ajax({
				url: "lahetyksetJSON.php",
				method: "get",
				data: {hakusana: $("#hakusana").val()},
				dataType: "json"
			})
			.done(function(data) {
				$("#lista").html("");
				for(var i = 0; i < data.length; i++) {
					$("#lista").append("<div class='center'><p><b>Lähettäjän tiedot:</b><br>Nimi: " + data[i].yrityksen_nimi +
						"<br>Y-tunnus: " + data[i].ytunnus +
						"<br>Katuosoite: " + data[i].lah_katuosoite +
						"<br>Postinumero: " + data[i].lah_postinro +
						"<br>Postitoimipaikka: " + data[i].lah_postitmp +
						"<br>Sähköposti: " + data[i].sposti +
						"<br>Tilinumero: " + data[i].tilinumero +
						"<br><b>Lähetyksen tiedot:</b><br>Lähetystunnus: " + data[i].lahetystunnus +
						"<br>Loppusumma: " + data[i].summa +
						"<br>Tuotteet: " + data[i].tuotteet +
						"<br><b>Vastaanottajan tiedot:</b><br>Nimi: " + data[i].vas_nimi +
						"<br>Katuosoite: " + data[i].vas_katuosoite +
						"<br>Postinumero: " + data[i].vas_postinro +
						"<br>Postitoimipaikka: " + data[i].vas_postitmp + "</p></div>");
				}
				if (data.length == 0) {
					$("#lista").append("<p>Haku ei tuottanut yhtään lähetystä.</p>")
				}
			})
			.fail(function() {
				$("#lista").html("<p>Listausta ei voida tehdä.</p>");
			});
				
		});
	});
	
</script>

</body>

</html>

