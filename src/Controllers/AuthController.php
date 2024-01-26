<?php
    namespace Controllers;

use Lib\Security;
use Services\UsuariosService;

    class AuthController{
        private UsuariosService $service;
        public function __construct() {
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
    }
?>