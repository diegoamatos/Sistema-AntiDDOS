<?php
 /**
 * Check.class [ HELPER ]
 * Classe responável por manipular e validade dados do sistema!
 * Sistema AntiDDOS
 * @copyright (c) 2015, Diego Matos
 */
class Check {

    private static $Data;
    private static $Format;
	public $CheckFile;
	public $AllFile;
	public $BlackFile;
	public $WhiteFile;
	public $TempFile;

	public function getProtocolo() {
        return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    }
	
	public function getIp() {
        $ad_ip = ""; 
		$ad_ip = (getenv("HTTP_CLIENT_IP") and preg_match("/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}\z/", getenv(" HTTP_CLIENT_IP "))) ? getenv("HTTP_CLIENT_IP") : ( (getenv("HTTP_X_FORWARDED_FOR") and preg_match("/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}\z/", getenv(" HTTP_X_FORWARDED_FOR "))) ? getenv("HTTP_X_FORWARDED_FOR") : getenv("REMOTE_ADDR"));
		return $ad_ip;
    }

	public function Create_File($the_path){
		$handle = fopen($the_path, 'w') or die('Não pode abrir o arquivo:  '.$the_path);
		return "Criando ".$the_path." .... OK";
	}
    
	//Verificar se todos os arquivos existem antes de lançar o cheking
    public function CheckFile($AD_DDOS) {
		
		$config_status = "";
        foreach ($AD_DDOS as $ad):
			if(!file_exists(AD_DIR.DIRECTORY_SEPARATOR.$ad)):
				$config_status .= $this->Create_File(AD_DIR.DIRECTORY_SEPARATOR.$ad);
			else:
				$config_status .= "ERROR: Criando ".AD_DIR.DIRECTORY_SEPARATOR.$ad."<br>";
			endif;
		endforeach;
		
		if (!file_exists (AD_DIR.DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."anti_ddos.php")) {
			$config_status .= "anti_ddos.php não existe!";
		}
		
		foreach ($AD_DDOS as $file):
			if (!file_exists(AD_DIR.DIRECTORY_SEPARATOR.$file)) {
				$config_status .= "O arquivo {$file} não existe!";
				die($config_status);
			}
		endforeach;
		
		$this->CheckFile = AD_DIR.DIRECTORY_SEPARATOR.$AD_DDOS["AD_CHECK_FILE"];//Arquivo para gravar o estado atual durante o monitoramento
		$this->AllFile = AD_DIR.DIRECTORY_SEPARATOR.$AD_DDOS["AD_ALL_FILE"];//Arquivo temporário
		$this->BlackFile = AD_DIR.DIRECTORY_SEPARATOR.$AD_DDOS["AD_BLACK_FILE"];//Será inserido em um ip de máquina zumbi
		$this->WhiteFile = AD_DIR.DIRECTORY_SEPARATOR.$AD_DDOS["AD_WHITE_FILE"];//Visitantes logados ip
		$this->TempFile = AD_DIR.DIRECTORY_SEPARATOR.$AD_DDOS["AD_TEMP_FILE"];//Visitantes logados ip
		
    }
	
    public function getFromfile_source($type){
		return ($type == "black") ? explode(',', implode(',',file($this->BlackFile))) : ( ($type == "white") ? explode(',', implode(',',file($this->WhiteFile))) : explode(',', implode(',',file($this->TempFile))) ) ;
	}

}
