<?php
/**
 * Sistema AntiDDOS
 * FILE: index.php
 * Por Diego Matos
 */
$View = new View;
$ad_source = $Check->getFromfile_source('black');
if(in_array($Check->getIp(), $ad_source)) {die();}

$ad_source = $Check->getFromfile_source('white');
if(!in_array($Check->getIp(), $ad_source)) {

	$ad_source = $Check->getFromfile_source('temp');
	if(!in_array($Check->getIp(), $ad_source)) {
		$_SESSION['variable_check']=1;
		$_SESSION['nbre_essai']=3;
		$ad_file = fopen($Check->TempFile, "a+");
		$ad_string = $Check->getIp().',';
		fputs($ad_file, "$ad_string");
		fclose($ad_file); 
		$array_for_nom = array('maN','bZ','E','S','i','P','u','1','4','Ds','Er','FtGy','A','d','98','z1sW');
		$nom_form = $array_for_nom[rand(0,15)].$array_for_nom[rand(0,15)].$array_for_nom[rand(0,15)].$array_for_nom[rand(0,15)].$array_for_nom[rand(0,15)];
		$variable_form = str_shuffle($nom_form).$array_for_nom[rand(0,15)].$array_for_nom[rand(0,15)];
		$_SESSION['variable_du_form'] = $variable_form;

		$tpl_v = $View->Load('verify_v');
		$view_v['nom_form'] = $nom_form;
		$view_v['variable_du_form'] = $variable_form;
		$View->Show($view_v, $tpl_v);
		die();
	}elseif(isset($_POST[$_SESSION['variable_du_form']]) AND $_SESSION['nbre_essai']>0 AND $_SESSION['variable_check']<4){
		$secure = isset($_POST['valCAPTCHA']) ? ($_POST['valCAPTCHA']) : '';

		if (strtoupper($secure) == $_SESSION['securecode']){
			$ad_file = fopen($Check->WhiteFile, "a+");
			$ad_string = $Check->getIp(). ',';
			fputs($ad_file, "$ad_string");
			fclose($ad_file);
			unset($_SESSION['securecode']);
			unset($_SESSION['nbre_essai']);
			unset($_SESSION['variable_check']);
			header("HTTP/1.1 301 Moved Permanently");
			header("Location: ".$Check->getProtocolo());
		}else{
			$_SESSION['nbre_essai']--;
			$_SESSION['variable_check'] = $_SESSION['variable_check']+1;
			$array_for_nom = array('maN','bZ','E','S','i','P','u','1','4','Ds','Er','FtGy','A','d','98','z1sW');
			$nom_form = $array_for_nom[rand(0,15)].$array_for_nom[rand(0,15)].$array_for_nom[rand(0,15)].$array_for_nom[rand(0,15)].$array_for_nom[rand(0,15)]; 
			$variable_form = str_shuffle($nom_form).$array_for_nom[rand(0,15)].$array_for_nom[rand(0,15)]; 
			$_SESSION['variable_du_form'] = $variable_form;
			
			$tpl_l = $View->Load('verify_l');
			$view_v['nom_form'] = $nom_form;
			$view_v['variable_du_form'] = $variable_form;
			$view_v['nbre_essai'] = $_SESSION['nbre_essai']+1;
			$View->Show($view_v, $tpl_l);
			die();
		}
		
	}elseif(isset($_SESSION['variable_check']) && $_SESSION['variable_check']<4){
		$array_for_nom = array('maN','bZ','E','S','i','P','u','1','4','Ds','Er','FtGy','A','d','98','z1sW');
		$nom_form = $array_for_nom[rand(0,15)].$array_for_nom[rand(0,15)].$array_for_nom[rand(0,15)].$array_for_nom[rand(0,15)].$array_for_nom[rand(0,15)]; 
		$variable_form = str_shuffle($nom_form).$array_for_nom[rand(0,15)].$array_for_nom[rand(0,15)];
		$_SESSION['variable_du_form'] = $variable_form;
		$_SESSION['nbre_essai']--;
		$_SESSION['variable_check'] = $_SESSION['variable_check']+1;
		
		$tpl_l = $View->Load('verify_l');
		$view_v['nom_form'] = $nom_form;
		$view_v['variable_du_form'] = $variable_form;
		$view_v['nbre_essai'] = $_SESSION['nbre_essai']+1;
		$View->Show($view_v, $tpl_l);
		
		die();
	} else {
		if($_SESSION['variable_check']>3){
			$ad_file = fopen($Check->BlackFile, "a+");
			$ad_string = $Check->getIp().',';
			fputs($ad_file, "$ad_string");
			fclose($ad_file);
			die();
		}
	}
}
?>
