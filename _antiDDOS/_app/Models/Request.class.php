<?php
/**
 * Link [ MODEL ]
 * Classe responsável por realizar a navegação!
 * Sistema AntiDDOS
 * @copyright (c) 2015, Diego Matos
 */
class Request {

    private $File;
    private $Link;

    /** DATA */
    private $Local;
    private $Patch;
	private $Checks = false;
	

    /** PUBLIC */
    public $num_query;
	public $sec_query;
	public $end_defense;
	public $ad_sec;
	public $ad_date;
	public $ad_defense_time;
    
    function __construct() {
		$Check = new Check;
		$this->Local = strip_tags(trim($Check->getProtocolo()));
    }

    public function getPatch() {
        return $this->Patch;
    }
	
	public function Enclose($AD_DDOS_REQUESTS) {
		$this->setEnclose($AD_DDOS_REQUESTS);
	}
	
	public function Patch($AD_DDOS_FILE) {
		$this->setPatch($AD_DDOS_FILE);
	}
	
	public function getNum_query() {
		return $this->num_query;
	}
	
	public function getSec_query() {
		return $this->sec_query;
	}
	
	public function getEnd_defense() {
		return $this->end_defense;
	}
	
	public function getAd_sec() {
		return $this->ad_sec;
	}
	
	public function getAd_date() {
		return $this->ad_date;
	}
	
	public function getAd_defense_time() {
		return $this->ad_defense_time;
	}
	
	//PRIVATES
	private function setEnclose($AD_DDOS_REQUESTS) {
		$this->num_query = $AD_DDOS_REQUESTS["AD_NUM_QUERY"];//Número atual de solicitações por segundo de um arquivo $check_file
		$this->sec_query = $AD_DDOS_REQUESTS["AD_SEC_QUERY"];//Segundo de um arquivo $check_file
		$this->end_defense = $AD_DDOS_REQUESTS["AD_END_DEFENSE"];//Terminar enquanto protege o arquivo $check_file
		$this->ad_sec = $AD_DDOS_REQUESTS["AD_SEC"];//Segundo atual
		$this->ad_date = $AD_DDOS_REQUESTS["AD_DATE"];//Hora atual
		$this->ad_defense_time = $AD_DDOS_REQUESTS["AD_DEFENSE_TIME"];//DDoS ​​attack tempo de detecção em segundos em que para de monitorar
		$this->Checks = true;
	}
	
    private function setPatch($AD_DDOS_FILE) {
		if($this->Checks){
			if ($this->end_defense and $this->end_defense > $this->ad_date) {
				$this->Patch = (AD_DIR.DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."anti_ddos.php");
			} else {
				$this->num_query = ($this->ad_sec == $this->sec_query) ? $this->num_query++ : '1';
				$ad_file = fopen (AD_DIR.DIRECTORY_SEPARATOR.$AD_DDOS_FILE['AD_CHECK_FILE'], "w");
				$ad_string = ($this->num_query >= AD_DDOS_QUERY) ? '<?php $Request->end_defense='.($this->ad_date + $this->ad_defense_time).';?>':'<?php $Request->num_query='.$this->num_query.';$Request->sec_query='.$this->ad_sec.';?>';
				fputs ($ad_file, $ad_string);
				fclose ($ad_file);
				
				$ad_string = ($this->num_query >= AD_DDOS_QUERY) ? $this->end_defense =($this->ad_date + $this->ad_defense_time) : $this->num_query =$this->num_query; $this->ad_sec=$this->ad_sec;
			}
		}
    }
}
