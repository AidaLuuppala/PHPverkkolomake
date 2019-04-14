<?php
require_once "lahetys.php";

class lahetysPDO {
	private $db;
	private $lkm;

	//konstruktori
	function __construct($dsn = "mysql:host=localhost;dbname=verkkolomake", $user = "root", $password = "salainen") {
		$this->db = new PDO ( $dsn, $user, $password );
		
		// Virheiden jäljitys kehitysaikana
		//nähdään kaikki virheilmoitus, pois tuotannosta kommentteihin
		$this->db->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
		
		//parametrien sidonta
		$this->db->setAttribute ( PDO::ATTR_EMULATE_PREPARES, false );
		
		//tulosrivien määrä
		$this->lkm = 0;
	}
	
	//metodi palauttaa tulosrivien määrän
	function getLkm() {
		return $this->lkm;
	}
	
//HAE KAIKKI LÄHETYKSET-------------------------------------------------------------------
	
	public function kaikkiLahetykset() {
		$sql = "SELECT * FROM lahetykset";
		
		//valmistellaan lause
		if (! $stmt = $this->db->prepare ( $sql )) {
			$virhe = $this->db->errorInfo ();
			
			throw new PDOException ( $virhe [2], $virhe [1] );
		}
		
		//ajetaan lauseke
		if (! $stmt->execute()) {
			$virhe = $stmt->errorInfo ();
			
			throw new PDOException ( $virhe [2], $virhe [1] );
		}
		
		//käsittellään hakulausekkeen tulos
		$tulos = array();
		
		while ( $row = $stmt->fetchObject () ) {
			$lahetys = new Lahetys ();
			
			//täytetään olio tietokannan tiedoilla
			$lahetys->setId($row->id);
			$lahetys->setYritysNimi(utf8_encode($row->yrityksen_nimi));
			$lahetys->setYtunnus($row->ytunnus);
			$lahetys->setLahOsoite(utf8_encode($row->lah_katuosoite));
			$lahetys->setLahPostNum($row->lah_postinro);
			$lahetys->setLahPostTmp(utf8_encode($row->lah_postitmp));
			$lahetys->setSposti($row->sposti);
			$lahetys->setTilinum($row->tilinumero);
			$lahetys->setLahetystunnus($row->lahetystunnus);
			$lahetys->setSumma($row->summa);
			$lahetys->setTuotteet(utf8_encode($row->tuotteet));
			$lahetys->setVasNimi(utf8_encode($row->vas_nimi));
			$lahetys->setVasOsoite(utf8_encode($row->vas_katuosoite));
			$lahetys->setVasPostNum($row->vas_postinro);
			$lahetys->setVasPostTmp(utf8_encode($row->vas_postitmp));
			
			//laitetaan olio tulos olio tyyppiseen taulukkoon
			$tulos [] = $lahetys;
		} 
		
		//päivitetään lukumäärä muuttuja eli kuinka monta riviä tuli vastauksena
		$this->lkm = $stmt->rowCount ();
		
		
		//palautetaan tulos-taulukko
		return $tulos;
	}
	
//HAE LÄHETYS------------------------------------------------------------------------
	
	public function haeLahetys($hakusana) {
		$sql = "SELECT * FROM lahetykset
				WHERE yrityksen_nimi like :hakusana";
		
		if (! $stmt = $this->db->prepare ( $sql )) {
			$virhe = $this->db->errorInfo ();
			throw new PDOException ( $virhe [2], $virhe [1] );
		}
		
		//sidotaan parametrit
		$haku = "%" . utf8_decode($hakusana) . "%";
		$stmt->bindValue(":hakusana", $haku, PDO::PARAM_STR);
		
		if (! $stmt->execute ()) {
			$virhe = $stmt->errorInfo ();
			
			if ($virhe [0] == "HY093") {
				$virhe [2] = "Invalid parameter";
			}
			
			throw new PDOException ( $virhe [2], $virhe [1] );
		}
		
		$tulos = array ();
		
		while ( $row = $stmt->fetchObject () ) {
			$lahetys = new Lahetys ();
			
			$lahetys->setId($row->id);
			$lahetys->setYritysNimi(utf8_encode($row->yrityksen_nimi));
			$lahetys->setYtunnus($row->ytunnus);
			$lahetys->setLahOsoite(utf8_encode($row->lah_katuosoite));
			$lahetys->setLahPostNum($row->lah_postinro);
			$lahetys->setLahPostTmp(utf8_encode($row->lah_postitmp));
			$lahetys->setSposti($row->sposti);
			$lahetys->setTilinum($row->tilinumero);
			$lahetys->setLahetystunnus($row->lahetystunnus);
			$lahetys->setSumma($row->summa);
			$lahetys->setTuotteet(utf8_encode($row->tuotteet));
			$lahetys->setVasNimi(utf8_encode($row->vas_nimi));
			$lahetys->setVasOsoite(utf8_encode($row->vas_katuosoite));
			$lahetys->setVasPostNum($row->vas_postinro);
			$lahetys->setVasPostTmp(utf8_encode($row->vas_postitmp));
			
			$tulos [] = $lahetys;
		}
		
		$this->lkm = $stmt->rowCount ();
		
		return $tulos;
	}
	
//LISÄÄ LÄHETYS----------------------------------------------------------------------
	
	function lisaaLahetys($lahetys) {
		
		$onnistui = true;

		$sql = "insert into lahetykset (yrityksen_nimi, ytunnus, lah_katuosoite, lah_postinro, lah_postitmp, sposti, tilinumero, lahetystunnus, summa, tuotteet, vas_nimi, vas_katuosoite, vas_postinro, vas_postitmp)
		        values (:yritysnimi, :ytunnus, :lahosoite, :lahpostnum, :lahposttmp, :sposti, :tilinum, :lahetystunnus, :summa, :tuotteet, :vasnimi, :vasosoite, :vaspostnum, :vasposttmp)";
		
		if (! $stmt = $this->db->prepare ( $sql )) {
			$virhe = $this->db->errorInfo ();
			throw new PDOException ( $virhe [2], $virhe [1] );
		}
		
		//sidotaan parametrit
		$stmt->bindValue(":yritysnimi", utf8_decode($lahetys->getYritysNimi()), PDO::PARAM_STR);
		$stmt->bindValue(":ytunnus", $lahetys->getYtunnus(), PDO::PARAM_STR);
		$stmt->bindValue(":lahosoite", utf8_decode($lahetys->getLahOsoite()), PDO::PARAM_STR);
		$stmt->bindValue(":lahpostnum", $lahetys->getLahPostNum(), PDO::PARAM_STR);
		$stmt->bindValue(":lahposttmp", utf8_decode($lahetys->getLahPostTmp()), PDO::PARAM_STR);
		$stmt->bindValue(":sposti", $lahetys->getSposti(), PDO::PARAM_STR);
		$stmt->bindValue(":tilinum", $lahetys->getTilinum(), PDO::PARAM_STR);
		$stmt->bindValue(":lahetystunnus", $lahetys->getLahetystunnus(), PDO::PARAM_STR);
		$stmt->bindValue(":summa", $lahetys->getSumma(), PDO::PARAM_STR);
		$stmt->bindValue(":tuotteet", utf8_decode($lahetys->getTuotteet()), PDO::PARAM_STR);
		$stmt->bindValue(":vasnimi", utf8_decode($lahetys->getVasNimi()), PDO::PARAM_STR);
		$stmt->bindValue(":vasosoite", utf8_decode($lahetys->getVasOsoite()), PDO::PARAM_STR);
		$stmt->bindValue(":vaspostnum", $lahetys->getVasPostNum(), PDO::PARAM_STR);
		$stmt->bindValue(":vasposttmp", utf8_decode($lahetys->getVasPostTmp()), PDO::PARAM_STR);
		
		$this->db->beginTransaction();
		
		if (! $stmt->execute ()) {
			$virhe = $stmt->errorInfo ();
			
			if ($virhe [0] == "HY093") {
				$virhe [2] = "Invalid parameter";
			}
			 
			//perutaan tapahtuma
			$this->db->rollBack();
			
			throw new PDOException ( $virhe [2], $virhe [1] );
			
			$onnistui = false;
		}
	 	
		$id = $this->db->lastInsertId();
		
		$this->db->commit();
		
		return $onnistui;
	}
	
//HAE LÄHETYS ID:LLÄ-------------------------------------------------------------------
	
	public function haeLahetysId($id) {
		$sql = "SELECT * FROM lahetykset
				WHERE id = :id";
		
		if (! $stmt = $this->db->prepare ( $sql )) {
			$virhe = $this->db->errorInfo ();
			throw new PDOException ( $virhe [2], $virhe [1] );
		}
		
		$stmt->bindValue(":id", $id, PDO::PARAM_INT);
		
		if (! $stmt->execute ()) {
			$virhe = $stmt->errorInfo ();
			
			if ($virhe [0] == "HY093") {
				$virhe [2] = "Invalid parameter";
			}
			
			throw new PDOException ( $virhe [2], $virhe [1] );
		}
		
		$tulos = array ();
		
		while ( $row = $stmt->fetchObject () ) {
			$lahetys = new Lahetys ();
			
			$lahetys->setId($row->id);
			$lahetys->setYritysNimi(utf8_encode($row->yrityksen_nimi));
			$lahetys->setYtunnus($row->ytunnus);
			$lahetys->setLahOsoite(utf8_encode($row->lah_katuosoite));
			$lahetys->setLahPostNum($row->lah_postinro);
			$lahetys->setLahPostTmp(utf8_encode($row->lah_postitmp));
			$lahetys->setSposti($row->sposti);
			$lahetys->setTilinum($row->tilinumero);
			$lahetys->setLahetystunnus($row->lahetystunnus);
			$lahetys->setSumma($row->summa);
			$lahetys->setTuotteet(utf8_encode($row->tuotteet));
			$lahetys->setVasNimi(utf8_encode($row->vas_nimi));
			$lahetys->setVasOsoite(utf8_encode($row->vas_katuosoite));
			$lahetys->setVasPostNum($row->vas_postinro);
			$lahetys->setVasPostTmp(utf8_encode($row->vas_postitmp));
			
			$tulos [] = $lahetys;
		}
		
		$this->lkm = $stmt->rowCount ();
		
		return $tulos;
	}
	
//POISTA LÄHETYS-----------------------------------------------------------------------
	
	public function poistaLahetys($id) {
		
		$onnistui = true;
		
		$sql = "DELETE FROM lahetykset
				WHERE id = :id";
		
		if (! $stmt = $this->db->prepare ( $sql )) {
			$virhe = $this->db->errorInfo ();
			throw new PDOException ( $virhe [2], $virhe [1] );
			
			$onnistui = false;
		}
		
		$stmt->bindValue(":id", $id, PDO::PARAM_INT);
		
		if (! $stmt->execute ()) {
			$virhe = $stmt->errorInfo ();
			
			if ($virhe [0] == "HY093") {
				$virhe [2] = "Invalid parameter";
			}
			
			$onnistui = false;
			
			throw new PDOException ( $virhe [2], $virhe [1] );
		}
		
		return $onnistui;
	}
}
?>