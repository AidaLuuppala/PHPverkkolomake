<?php
class Lahetys implements JsonSerializable {
	private static $virhelista = array (
			- 1 => "Tuntematon virhe",
			0 => "",
			1 => "Tarkista kenttä",
			2 => "Täytä kenttä"
	);

	//numeroa vastaava virheilmoitus
	public static function getError($virhekoodi) {
		if (isset ( self::$virhelista [$virhekoodi] )) //tutkitaan löytyykö virhe listasta
			return self::$virhelista [$virhekoodi]; //jos löytyy, palautetaan koodia vastaava teksti

		return self::$virhelista [- 1]; //jos ei löydy listalta, palautetaan -1
	}

	//lukoan attribuutit
	private $yritysNimi;
	private $ytunnus;
	private $lahOsoite;
	private $lahPostNum;
	private $lahPostTmp;
	private $sposti;
	private $tilinum;
	private $lahetystunnus;
	private $summa;
	private $tuotteet;
	private $vasNimi;
	private $vasOsoite;
	private $vasPostNum;
	private $vasPostTmp;
	private $id; // Tehty kannan takia, on kannassa avainkenttänä
	             
	// Metodi, mikä muuttaa olion JSON-muotoon
	public function jsonSerialize() {
		return array (
			"yrityksen_nimi" => $this->yritysNimi,
			"ytunnus" => $this->ytunnus,
			"lah_katuosoite" => $this->lahOsoite,
			"lah_postinro" => $this->lahPostNum,
			"lah_postitmp" => $this->lahPostTmp,
			"sposti" => $this->sposti,
			"tilinumero" => $this->tilinum,
			"lahetystunnus" => $this->lahetystunnus,
			"summa" => $this->summa,
			"tuotteet" => $this->tuotteet,
			"vas_nimi" => $this->vasNimi,
			"vas_katuosoite" => $this->vasOsoite,
			"vas_postinro" => $this->vasPostNum,
			"vas_postitmp" => $this->vasPostTmp,
			"id" => $this->id 
		);
	}

	//konstruktori
	function __construct($yritysNimi = "", $ytunnus = "", $lahOsoite = "", $lahPostNum = "", $lahPostTmp = "", $sposti = "", $tilinum = "", $lahetystunnus = "", $summa = "", $tuotteet = "", $vasNimi = "", $vasOsoite = "", $vasPostNum = "", $vasPostTmp = "", $id = ""){
		$this->yritysNimi = trim(mb_convert_case($yritysNimi, MB_CASE_TITLE, "UTF-8"));
		$this->ytunnus = trim($ytunnus);
		$this->lahOsoite = trim(mb_convert_case($lahOsoite, MB_CASE_TITLE, "UTF-8"));
		$this->lahPostNum = trim($lahPostNum);
		$this->lahPostTmp = trim(mb_convert_case($lahPostTmp, MB_CASE_TITLE, "UTF-8"));
		$this->sposti = trim($sposti);
		$this->tilinum = trim($tilinum);
		$this->lahetystunnus = trim($lahetystunnus);
		$this->summa = trim($summa);
		$this->tuotteet = trim($tuotteet);
		$this->vasNimi = trim(mb_convert_case($vasNimi, MB_CASE_TITLE, "UTF-8"));
		$this->vasOsoite = trim(mb_convert_case($vasOsoite, MB_CASE_TITLE, "UTF-8"));
		$this->vasPostNum = trim($vasPostNum);
		$this->vasPostTmp = trim(mb_convert_case($vasPostTmp, MB_CASE_TITLE, "UTF-8"));
		$this->id = $id;
	}
	
	//YRITYSNIMI----------------------------------------------------------------------------------------

	public function setYritysNimi($yritysNimi){
		$this->yritysNimi = trim($yritysNimi);
	}

	public function getYritysNimi(){
		return $this->yritysNimi;
	}
	
	public function checkYritysNimi(){
		if(!empty($this->yritysNimi)){ //jos kenttä ei ole tyhjä, niin tarkistetaan
			if (!preg_match("/[a-zåäöA-ZÅÄÖ\-\.]/", $this->yritysNimi)){ //jos ei oikeassa muodossa
				return 1; //palautetaan virheilmoitus
			}else{ //muutoin kenttä on oikein
				return 0; //ei virheilmoitusta
			}	
		}else{
			return 2; //kenttä tyhjä virheilmoitus
		}
	}
	
	//Y-TUNNUS----------------------------------------------------------------------------------------
	
	public function setYtunnus($ytunnus){
		$this->ytunnus = trim($ytunnus);
	}

	public function getYtunnus(){
		return $this->ytunnus;
	}

	public function checkYtunnus(){
		if(!empty($this->ytunnus)){
			if (!preg_match("/^\d{7}\-.$/", $this->ytunnus)){
				return 1;
			}else{
				return 0;
			}	
		}else{
			return 2;
		}
	}
	
	//LÄHETTÄJÄN KATUOSOITE-------------------------------------------------------------------------------
	
	public function setLahOsoite($lahOsoite){
		$this->lahOsoite = trim($lahOsoite);
	}

	public function getLahOsoite(){
		return $this->lahOsoite;
	}

	public function checkLahOsoite(){
		if(!empty($this->lahOsoite)){
			if (!preg_match("/[a-zäöåA-ZÄÖÅ0-9\-]+/", $this->lahOsoite)){
				return 1;
			}else{
				return 0;
			}	
		}else{
			return 2;
		}
	}
	
	//LÄHETTÄJÄN POSTINUMERO----------------------------------------------------------------------------------------
	
	public function setLahPostNum($lahPostNum){
		$this->lahPostNum = trim($lahPostNum);
	}

	public function getLahPostNum(){
		return $this->lahPostNum;
	}

	public function checkLahPostNum(){
		if(!empty($this->lahPostNum)){
			if (!preg_match("/\d{5}/", $this->lahPostNum)){
				return 1;
			}else{
				return 0;
			}	
		}else{
			return 2;
		}
	}
	
	//LÄHETTÄJÄN POSTITOIMIPAIKKA-------------------------------------------------------------------------
	
	public function setLahPostTmp($lahPostTmp){
		$this->lahPostTmp = trim($lahPostTmp);
	}

	public function getLahPostTmp(){
		return $this->lahPostTmp;
	}

	public function checkLahPostTmp(){
		if(!empty($this->lahPostTmp)){
			if (!preg_match("/^[a-zäöåA-ZÄÖÅ][a-zäöåA-ZÄÖÅ\-]+$/", $this->lahPostTmp)){
				return 1;
			}elseif($this->lahPostTmp[strlen($this->lahPostTmp)-1] == "-"){ //tutkitaan, ettei viimeinen merkki ole -
				return 1;
			}elseif(substr_count($this->lahPostTmp, "-") > 1){ //tutkitaan, ettei ole kuin yksi -
				return 1;
			}else{
				return 0;
			}	
		}else{
			return 2;
		}
	}
	
	//SÄHKÖPOSTI----------------------------------------------------------------------------------------

	public function setSposti($sposti){
		$this->sposti = trim($sposti);
	}

	public function getSposti(){
		return $this->sposti;
	}

	public function checkSposti(){
		if(!empty($this->sposti)){
			if (!preg_match("/^[A-Za-z](.*)([@]{1})(.{1,})(\\.)(.{1,})/", $this->sposti)){
				return 1;
			}else{
				return 0;
			}	
		}else{
			return 2;
		}
	}
	
	//TILINUMERO----------------------------------------------------------------------------------------

	public function setTilinum($tilinum){
		$this->tilinum = trim($tilinum);
	}

	public function getTilinum() {
		return $this->tilinum;
	}

	public function checkTilinum(){
		if(!empty($this->tilinum)){
			if (! preg_match("/^([A-Z]{2})\d{16}$/", $this->tilinum)){
				return 1;
			}else{
				return 0;
			}
		}else{
			return 2;
		}
	}
	
	//LÄHETYSTUNNUS----------------------------------------------------------------------------------------

	public function setLahetystunnus($lahetystunnus) {
		$this->lahetystunnus = trim($lahetystunnus);
	}

	public function getLahetystunnus() {
		return $this->lahetystunnus;
	}

	public function checkLahetystunnus() {
		if(!empty($this->lahetystunnus)){
			if (!preg_match("/[a-zA-Z0-9]+/", $this->lahetystunnus)){
				return 1;
			}else{
				return 0;
			}	
		}else{
			return 2;
		}
	}
	
	//LOPPUSUMMA----------------------------------------------------------------------------------------

	public function setSumma($summa){
		$this->summa = trim($summa);
	}

	public function getSumma(){
		return $this->summa;
	}
 
	public function checkSumma(){
		if(!empty($this->summa)){
			if (!preg_match("/^\d+(\.\d{2})?$/", $this->summa)){
				return 1;
			}else{
				return 0;
			}	
		}else{
			return 2;
		}
	}
	
	//TUOTTEET----------------------------------------------------------------------------------------
	
	public function setTuotteet($tuotteet){
		$this->tuotteet = trim($tuotteet);
	}

	public function getTuotteet() {
		return $this->tuotteet;
	}
	
	public function checkTuotteet(){
		if(!empty($this->tuotteet)){
			if (!preg_match("/[a-zäöåA-ZÄÖÅ0-9.]+/", $this->tuotteet)){
				return 1;
			}else{
				return 0;
			}	
		}else{
			return 2;
		}
	}
	
	//VASTAANOTTAJAN NIMI----------------------------------------------------------------------------------

	public function setVasNimi($vasNimi){
		$this->vasNimi = trim($vasNimi);
	}

	public function getVasNimi(){
		return $this->vasNimi;
	}
	
	public function checkVasNimi(){
		if(!empty($this->vasNimi)){
			if (!preg_match("/[a-zåäöA-ZÅÄÖ\-]/", $this->vasNimi)){
				return 1;
			}else{
				return 0;
			}	
		}else{
			return 2;
		}
	}
	
	//VASTAANOTTAJAN KATUOSOITE-------------------------------------------------------------------------------
	
	public function setVasOsoite($vasOsoite){
		$this->vasOsoite = trim ($vasOsoite);
	}

	public function getVasOsoite(){
		return $this->vasOsoite;
	}

	public function checkVasOsoite($required = true){
		if(!empty($this->vasOsoite)){
			if (!preg_match("/[a-zäöåA-ZÄÖÅ0-9\-]+/", $this->vasOsoite)){
				return 1;
			}else{
				return 0;
			}	
		}else{
			return 2;
		}
	}
	
	//VASTAANOTTAJAN POSTINUMERO----------------------------------------------------------------------------------------
	
	public function setVasPostNum($vasPostNum){
		$this->vasPostNum = trim($vasPostNum);
	}

	public function getVasPostNum(){
		return $this->vasPostNum;
	}

	public function checkVasPostNum(){
		if(!empty($this->vasPostNum)){
			if (!preg_match("/\d{5}/", $this->vasPostNum)){
				return 1;
			}else{
				return 0;
			}	
		}else{
			return 2;
		}
	}
	
	//VASTAANOTTAJAN POSTITOIMIPAIKKA-------------------------------------------------------------------------
	
	public function setVasPostTmp($vasPostTmp){
		$this->vasPostTmp = trim($vasPostTmp);
	}

	public function getVasPostTmp(){
		return $this->vasPostTmp;
	}

	public function checkVasPostTmp(){
		if(!empty($this->vasPostTmp)){
			if (!preg_match("/^[a-zäöåA-ZÄÖÅ][a-zäöåA-ZÄÖÅ\-]+$/", $this->vasPostTmp)){
				return 1;
			}elseif($this->vasPostTmp[strlen($this->vasPostTmp)-1] == "-"){ //tutkitaan, ettei viimeinen merkki ole -
				return 1;
			}elseif(substr_count($this->vasPostTmp, "-") > 1){ //tutkitaan, ettei ole kuin yksi -
				return 1;
			}else{
				return 0;
			}	
		}else{
			return 2;
		}
	}
	
	//ID-------------------------------------------------------------------------
	
	public function setId($id) {
		$this->id = $id;
	}
	
	public function getId() {
		return $this->id;
	}
}
?>