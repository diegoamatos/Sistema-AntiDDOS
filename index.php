<?php
	/*UTILIZAÇÃO BÁSICA*/
	//include ("./_antiDDOS/begin.php"); //escreva isto no topo da sua aplicação PHP e tudo está feito!!!
	
	/*UTILIZAÇÃO AVANÇADO*/
	try{
		if (!file_exists("./_antiDDOS/begin.php"))
			throw new Exception ('./_antiDDOS/begin.php não existe');
		else
			require_once("./_antiDDOS/begin.php"); 
	} 
	//Pegue a exceção se algo der errado.
	catch (Exception $ex) {
		require_once("./_antiDDOS/_app/Config.inc.php");
		//imprimir uma mensagem dizendo que há um erro
		echo '<div style="padding:10px;color:white;position:fixed;top:0;left:0;width:100%;background:black;text-align:center;">O <a href="https://github.com/dinhobala/Sistema-Anti-DDOS" target="_blank">"Sistema AntiDDOS"</a> não foi carregado corretamente neste site, por favor, comente o \'catch Exception\' para ver o que está acontecendo!</div>';
	}
	$View = new View;
	$tpl_index = $View->Load('index');
	$view_i['name_system'] = NAME_SYSTEM;
	$view_i['name_author'] = NAME_AUTHOR;
	$view_i['url_system'] = URL_SYSTEM;
	$view_i['url_author'] = URL_DEVELOPER;
	$view_i['logo_author'] = LOGO_AUTHOR;
	$View->Show($view_i, $tpl_index);
?>