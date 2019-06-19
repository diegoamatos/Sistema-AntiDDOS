<?php
date_default_timezone_set('America/Sao_Paulo');
define("AD_DDOS_QUERY",5);//Número de solicitações por segundo para detectar ataques DDOS
define("AD_DIR",'_antiDDOS'. DIRECTORY_SEPARATOR . 'anti_ddos'. DIRECTORY_SEPARATOR . 'files');//Diretório com scripts
define("URL_SYSTEM","https://github.com/dinhobala/AntiDDOS-system");
define("URL_DEVELOPER","https://github.com/dinhobala");
define("NAME_SYSTEM","Sistema AntiDDOS");
define("NAME_AUTHOR","Diego Matos");
define("LOGO_AUTHOR","https://avatars2.githubusercontent.com/u/5185014?s=460&amp;v=4");

$AD_DDOS_FILE = ["AD_CHECK_FILE"=>'check.txt',"AD_ALL_FILE"=>'all_ip.txt',"AD_BLACK_FILE"=>'black_ip.txt',"AD_WHITE_FILE"=>'white_ip.txt',"AD_TEMP_FILE"=>'ad_temp_file.txt'];

$AD_DDOS_REQUESTS = ["AD_NUM_QUERY"=>(int)0,"AD_SEC_QUERY"=>(int)0,"AD_END_DEFENSE"=>(int)0,"AD_SEC"=>(int)date("s"),"AD_DATE"=>(int)date("is"),"AD_DEFENSE_TIME"=>(int)100];	
	
// AUTO LOAD DE CLASSES ####################
function __autoload($Class) {

    $cDir = ['Conn', 'Helpers', 'Models'];
    $iDir = null;

    foreach ($cDir as $dirName):
        if (!$iDir && file_exists(__DIR__ . DIRECTORY_SEPARATOR . $dirName . DIRECTORY_SEPARATOR . $Class . '.class.php') && !is_dir(__DIR__ . DIRECTORY_SEPARATOR . $dirName . DIRECTORY_SEPARATOR . $Class . '.class.php')):
            include_once (__DIR__ . DIRECTORY_SEPARATOR . $dirName . DIRECTORY_SEPARATOR . $Class . '.class.php');
            $iDir = true;
        endif;
    endforeach;

    if (!$iDir):
        trigger_error("Não foi possível incluir {$Class}.class.php", E_USER_ERROR);
        die;
    endif;
}