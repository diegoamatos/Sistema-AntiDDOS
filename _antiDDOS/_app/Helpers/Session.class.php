<?php
/**
 * Session.class [ HELPER ]
 * Responsável pelas sessões e atualizações de tráfego do sistema!
 * Sistema AntiDDOS
 * @copyright (c) 2015, Diego Matos
 */
class Session {

    private $Date;

    function __construct($Cache = null) {
        session_start();
        $this->CheckSession($Cache);
    }
	
	public function getSession() {
		return $_SESSION['standby'];	
    }
	
	public function setSessionDestroy() {
		session_destroy();
    }
	
    //Verifica e executa todos os métodos da classe!
    private function CheckSession($Cache = null) {
        $this->setSession();
    }

    //Inicia a sessão do usuário
    private function setSession() {
		if (empty($_SESSION['standby'])):
            $_SESSION['standby'] = 1;
        else:
            $_SESSION['standby'] = $_SESSION['standby']+1;
        endif;	
    }

    //Verifica, cria e atualiza o cookie do usuário
    private function getCookie() {
        $Cookie = filter_input(INPUT_COOKIE, 'useronline', FILTER_DEFAULT);
        setcookie("useronline", base64_encode("antiddos"), time() + 86400);
        if (!$Cookie):
            return false;
        else:
            return true;
        endif;
    }
}
