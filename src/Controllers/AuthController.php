<?php
    namespace Controllers;

use Lib\Pages;
use Lib\Security;
use Services\UsuariosService;

    class AuthController{
        private UsuariosService $service;
        private Pages $page;
        public function __construct() {
            $this->page = new Pages();
            $this->service = new UsuariosService();
        }
        public function pruebas() {
            var_dump(Security::crearToken(Security::claveSecreta(),["id"=>3]));
        }
        public function verificate($token) :void {
            $myToken = Security::returnToken($token);
            if($myToken){
                if($this->service->checkToken($token)){
                    $this->service->confirmado($myToken->data->email);
                }
            }
            header("Location:".BASE_URL);
        }
        public function nuevoToken() {
            if ($_SESSION['identity'] != null){
                $token = Security::crearToken(Security::claveSecreta(),["email"=>$_SESSION['identity']['email']]);
                $this->service->changeToken($_SESSION['identity']['email'],$token);
                $json['token']=$token;
                $this->page->renderJSON($json);
            }
        }
    }
?>