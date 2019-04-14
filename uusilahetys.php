<?php
require_once "lahetys.php";
session_start();
//print_r($_SESSION);
 
if (isset ( $_POST ["tallenna"] )) { //jos painetaan tallenna nappia
	
	//tehdään uusi olio ja täytetään se käyttäjän antamilla tiedoilla
	$lahetys = new Lahetys($_POST["yritysNimi"], $_POST["ytunnus"], $_POST["lahOsoite"],
	$_POST["lahPostNum"], $_POST["lahPostTmp"], $_POST["sposti"], $_POST["tilinum"],
	$_POST["lahetystunnus"], $_POST["summa"], $_POST["tuotteet"],
	$_POST["vasNimi"], $_POST["vasOsoite"], $_POST["vasPostNum"], $_POST["vasPostTmp"]);
	//olio istuntoon
	$_SESSION["lahetys"] = $lahetys;
	session_write_close();
	
	//tarkistus metodikutsut oletusarvoilla
	$yritysNimiVirhe = $lahetys->checkYritysNimi();
	$ytunnusVirhe = $lahetys->checkYtunnus();
	$lahOsoiteVirhe = $lahetys->checkLahOsoite();
	$lahPostNumVirhe = $lahetys->checkLahPostNum();
	$lahPostTmpVirhe = $lahetys->checkLahPostTmp();
	$spostiVirhe = $lahetys->checkSposti();
	$tilinumVirhe = $lahetys->checkTilinum();
	//lähetyksen tiedot
	$lahetystunnusVirhe = $lahetys->checkLahetystunnus();
	$summaVirhe = $lahetys->checkSumma();
	$tuotteetVirhe = $lahetys->checkTuotteet();
	//vastaanottajan tiedot
	$vasNimiVirhe = $lahetys->checkVasNimi();
	$vasOsoiteVirhe = $lahetys->checkVasOsoite();
	$vasPostNumVirhe = $lahetys->checkVasPostNum();
	$vasPostTmpVirhe = $lahetys->checkVasPostTmp();
	
	//jos ei virheitä, niin siirrytään naytalahetys sivulle
	if($yritysNimiVirhe == 0 && $ytunnusVirhe == 0 && $lahOsoiteVirhe == 0 && $lahPostNumVirhe == 0 && $lahPostTmpVirhe == 0 && $spostiVirhe == 0 && $tilinumVirhe == 0 && $lahetystunnusVirhe == 0 && $summaVirhe == 0 && $tuotteetVirhe == 0 && $vasNimiVirhe == 0 && $vasOsoiteVirhe == 0 && $vasPostNumVirhe == 0 && $vasPostTmpVirhe == 0){
		header("location: naytalahetys.php");
		exit();
	}
}
elseif (isset ( $_POST ["peruuta"] )) { //jos painetaan peruuta nappia
	unset($_SESSION["lahetys"]); //poistetaan lahetys istunnosta
	header ( "location: index.php" );
	exit ();
} 
else { //sivu ladataan ensimmäistä kertaa

	if(isset($_SESSION["lahetys"])){ //jos istunnossa on tietoja
			$lahetys = $_SESSION["lahetys"]; //sijoitetaan tiedot olio muuttujaan
			//tarkistus metodikutsut oletusarvoilla
			$yritysNimiVirhe = $lahetys->checkYritysNimi();
			$ytunnusVirhe = $lahetys->checkYtunnus();
			$lahOsoiteVirhe = $lahetys->checkLahOsoite();
			$lahPostNumVirhe = $lahetys->checkLahPostNum();
			$lahPostTmpVirhe = $lahetys->checkLahPostTmp();
			$spostiVirhe = $lahetys->checkSposti();
			$tilinumVirhe = $lahetys->checkTilinum();
			//lähetyksen tiedot
			$lahetystunnusVirhe = $lahetys->checkLahetystunnus();
			$summaVirhe = $lahetys->checkSumma();
			$tuotteetVirhe = $lahetys->checkTuotteet();
			//vastaanottajan tiedot
			$vasNimiVirhe = $lahetys->checkVasNimi();
			$vasOsoiteVirhe = $lahetys->checkVasOsoite();
			$vasPostNumVirhe = $lahetys->checkVasPostNum();
			$vasPostTmpVirhe = $lahetys->checkVasPostTmp();
		}else{ //muuten tehdään tyhjä ilmoitus
			$lahetys = new Lahetys(); //tehdään uusi olio konstruktorin oletusarvoilla
			//ei virheilmoituksia
			$yritysNimiVirhe = 0;
			$ytunnusVirhe = 0;
			$lahOsoiteVirhe = 0;
			$lahPostNumVirhe = 0;
			$lahPostTmpVirhe = 0;
			$spostiVirhe = 0;
			$tilinumVirhe = 0;
			//lähetyksen tiedot
			$lahetystunnusVirhe = 0;
			$summaVirhe = 0;
			$tuotteetVirhe = 0;
			//vastaanottajan tiedot
			$vasNimiVirhe = 0;
			$vasOsoiteVirhe = 0;
			$vasPostNumVirhe = 0;
			$vasPostTmpVirhe = 0;
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

<form action="uusilahetys.php" method="post">
	<fieldset>
		<legend>Lähettäjän tiedot:</legend>
			<div class="container2">
				<div class="left">
					<label>Yrityksen nimi:</label>
				</div>
				<div class="left">
					<input type="text" name="yritysNimi" id="yritysNimi"
					value="<?php print(htmlentities($lahetys->getYritysNimi(), ENT_QUOTES, 'UTF-8'))?>">
				</div>
				<div class="left">
					<?php print("<span style='color: #ff0000'>" . $lahetys->getError($yritysNimiVirhe) . "</span>")?>
				</div>
			</div>
			<div class="container2">
				<div class="left">
					<label>Y-tunnus:</label>
				</div>
				<div class="left">
					<input type="text" name="ytunnus" id="ytunnus"
					value="<?php print(htmlentities($lahetys->getYtunnus(), ENT_QUOTES, 'UTF-8'))?>">
				</div>
				<div class="left">
					<?php print("<span style='color: #ff0000'>" . $lahetys->getError($ytunnusVirhe) . "</span>")?>
				</div>
			</div>
			<div class="container2">
				<div class="left">
					<label>Katuosoite:</label>
				</div>
				<div class="left">
					<input type="text" name="lahOsoite" id="lahOsoite"
					value="<?php print(htmlentities($lahetys->getLahOsoite(), ENT_QUOTES, 'UTF-8'))?>">
				</div>
				<div class="left">
					<?php print("<span style='color: #ff0000'>" . $lahetys->getError($lahOsoiteVirhe) . "</span>")?>
				</div>
			</div>
			<div class="container2">
				<div class="left">
					<label>Postinumero:</label>
				</div>
				<div class="left">
					<input type="text" name="lahPostNum" id="lahPostNum"
					value="<?php print(htmlentities($lahetys->getLahPostNum(), ENT_QUOTES, 'UTF-8'))?>">
				</div>
				<div class="left">
					<?php print("<span style='color: #ff0000'>" . $lahetys->getError($lahPostNumVirhe) . "</span>")?>
				</div>
			</div>
			<div class="container2">
				<div class="left">
					<label>Postitoimipaikka:</label>
				</div>
				<div class="left">
					<input type="text" name="lahPostTmp" id="lahPostTmp"
					value="<?php print(htmlentities($lahetys->getLahPostTmp(), ENT_QUOTES, 'UTF-8'))?>">
				</div>
				<div class="left">
					<?php print("<span style='color: #ff0000'>" . $lahetys->getError($lahPostTmpVirhe) . "</span>")?>
				</div>
			</div>
			<div class="container2">
				<div class="left">
					<label>Sähköposti:</label>
				</div>
				<div class="left">
					<input type="text" name="sposti" id="sposti"
					value="<?php print(htmlentities($lahetys->getSposti(), ENT_QUOTES, 'UTF-8'))?>">
				</div>
				<div class="left">
					<?php print("<span style='color: #ff0000'>" . $lahetys->getError($spostiVirhe) . "</span>")?>
				</div>
			</div>
			<div class="container2">
				<div class="left">
					<label>Tilinumero:</label>
				</div>
				<div class="left">
					<input type="text" name="tilinum" id="tilinum"
					value="<?php print(htmlentities($lahetys->getTilinum(), ENT_QUOTES, 'UTF-8'))?>">
				</div>
				<div class="left">
					<?php print("<span style='color: #ff0000'>" . $lahetys->getError($tilinumVirhe) . "</span>")?>
				</div>
			</div>
	</fieldset>
	<fieldset>
		<legend>Lähetyksen tiedot:</legend>
			<div class="container2">
				<div class="left">
					<label>Lähetystunnus:</label>
				</div>
				<div class="left">
					<input type="text" name="lahetystunnus" id="lahetystunnus"
					value="<?php print(htmlentities($lahetys->getLahetystunnus(), ENT_QUOTES, 'UTF-8'))?>">
				</div>
				<div class="left">
					<?php print("<span style='color: #ff0000'>" . $lahetys->getError($lahetystunnusVirhe) . "</span>")?>
				</div>
			</div>
			<div class="container2">
				<div class="left">
					<label>Loppusumma:</label>
				</div>
				<div class="left">
					<input type="text" name="summa" id="summa"
					value="<?php print(htmlentities($lahetys->getSumma(), ENT_QUOTES, 'UTF-8'))?>">
				</div>
				<div class="left">
					<?php print("<span style='color: #ff0000'>" . $lahetys->getError($summaVirhe) . "</span>")?>
				</div>
			</div>
			<div class="container2">
				<div class="left">
					<label>Lähetyksen tuotteet:</label>
				</div>
				<div class="left">
					<textarea style="margin-left:25px" rows="5" cols="20" name="tuotteet" id="tuotteet"><?php print(htmlentities($lahetys->getTuotteet(), ENT_QUOTES, 'UTF-8'))?></textarea>
				</div>
				<div class="left">
					<?php print("<span style='color: #ff0000'>" . $lahetys->getError($tuotteetVirhe) . "</span>")?>
				</div>
			</div>
	</fieldset>
	<fieldset>
		<legend>Vastaanottajan tiedot:</legend>
			<div class="container2">
				<div class="left">
					<label>Nimi:</label>
				</div>
				<div class="left">
					<input type="text" name="vasNimi" id="vasNimi"
					value="<?php print(htmlentities($lahetys->getVasNimi(), ENT_QUOTES, 'UTF-8'))?>">
				</div>
				<div class="left">
					<?php print("<span style='color: #ff0000'>" . $lahetys->getError($vasNimiVirhe) . "</span>")?>
				</div>
			</div>
			<div class="container2">
				<div class="left">
					<label>Katuosoite:</label>
				</div>
				<div class="left">
					<input type="text" name="vasOsoite" id="vasOsoite"
					value="<?php print(htmlentities($lahetys->getVasOsoite(), ENT_QUOTES, 'UTF-8'))?>">
				</div>
				<div class="left">
					<?php print("<span style='color: #ff0000'>" . $lahetys->getError($vasOsoiteVirhe) . "</span>")?>
				</div>
			</div>
			<div class="container2">
				<div class="left">
					<label>Postinumero:</label>
				</div>
				<div class="left">
					<input type="text" name="vasPostNum" id="vasPostNum"
					value="<?php print(htmlentities($lahetys->getVasPostNum(), ENT_QUOTES, 'UTF-8'))?>">
				</div>
				<div class="left">
					<?php print("<span style='color: #ff0000'>" . $lahetys->getError($vasPostNumVirhe) . "</span>")?>
				</div>
			</div>
			<div class="container2">
				<div class="left">
					<label>Postitoimipaikka:</label>
				</div>
				<div class="left">
					<input type="text" name="vasPostTmp" id="vasPostTmp"
					value="<?php print(htmlentities($lahetys->getVasPostTmp(), ENT_QUOTES, 'UTF-8'))?>">
				</div>
				<div class="left">
					<?php print("<span style='color: #ff0000'>" . $lahetys->getError($vasPostTmpVirhe) . "</span>")?>
				</div>
			</div>	
	</fieldset>
	<br>
	<div class="btn">
		<input type="submit" name="tallenna" value="Tallenna">
		<input type="submit" name="peruuta" value="Peruuta">
	</div>
	<br>
</form>

</body>

</html>

