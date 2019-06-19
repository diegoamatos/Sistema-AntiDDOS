<?php
require("_app/Config.inc.php");
$Session = new Session;
$Check = new Check;
$Request = new Request;
//$Session->setSessionDestroy();
if($Session->getSession()>1):
	$Check->CheckFile($AD_DDOS_FILE);
	$Request->Enclose($AD_DDOS_REQUESTS);
	require (AD_DIR.DIRECTORY_SEPARATOR.$AD_DDOS_FILE['AD_CHECK_FILE']);
	$Request->Patch($AD_DDOS_FILE);
	if ($Request->getPatch()!==NULL):
		require($Request->getPatch());
	endif;
else:
	header("HTTP/1.1 301 Moved Permanently");
	header("refresh:8,".$Check->getProtocolo());
	$View = new View;
	$tpl_v = $View->Load('check_v');
	$view_v['name_system'] = NAME_SYSTEM;
	$view_v['name_author'] = NAME_AUTHOR;
	$view_v['url_system'] = URL_SYSTEM;
	$view_v['url_author'] = URL_DEVELOPER;
	$View->Show($view_v, $tpl_v);
	exit(0);
endif;
?>