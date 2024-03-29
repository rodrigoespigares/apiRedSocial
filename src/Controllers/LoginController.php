<?php
namespace Controllers;
use Services\UsuariosService;
use Controllers\AuthController;
use Models\Usuarios;
use Lib\Pages;
use Lib\Security;

    class LoginController{
        // Creamos atributo de la clase UsuarioService
        private UsuariosService $userService;
        private AuthController $auth;
        // Creamos el atributo de la clase Usuario
        // Creamos la variable de la case Pages
        private Pages $pages;
        /**
         * Constructor de la clase sin parámetros
         */
        public function __construct(){
            # Instanciamos las clases
            $this->userService = new UsuariosService();
            $this->auth= new AuthController();
            $this->pages = new Pages();
        }
        /**
         * Función para cargar el login
         */
        public function index(bool $value):void{
            $this->pages->render("pages/login/formLogin",["isLogin"=>$value]);
        }
        /**
         * Función para validar los datos introducidos en el login y en el registro
         */
        public function vLogin(bool $value):?array{
            $registro = $_POST['data'];            
            if (!$value) {
                
                $errores = [];
                Usuarios::validation($registro,$errores);
               
                if (empty($errores)) {
                    
                    $registro["password"] = password_hash($registro['password'], PASSWORD_BCRYPT,["cost"=>4]);
                    $this->userService->register($registro);
                    header("Location:".BASE_URL);
                }else{
                    $this->pages->render("pages/login/formLogin",["errores"=>$errores,"relleno"=>$registro, "isLogin"=>false]);
                }
            }elseif ($value) {
                $error = [];
                
                Usuarios::validationLogin($registro,$error);
                
                if(empty($error)){
                    $identity = $this->userService->getIdentity($registro['email']);
                    if($identity['confirmado'] == 0){
                        $error['confirmacion']="Necesitas confirmar el correo.";
                        if(!Security::returnToken($identity['token'])){
                            $error['confirmacion']="Necesitas confirmar el correo. Revisa tu bandeja de entrada";
                            $this->auth->nuevoTokenConfirmacion($identity['email']);
                        }
                    }
                    if($identity != null){
                        if(password_verify($registro['password'],$identity['password'])){
                            $_SESSION['identity']=$identity;
                            header("Location:".BASE_URL);
                            
                        }else{
                            $error["password"]="Error en la contraseña";
                            $this->pages->render("pages/login/formLogin",["error"=>$error,"relleno"=>$registro,"isLogin"=>true]);
                        }
                    }else{
                        $error['email'] = "Email no registrado";
                        $this->pages->render("pages/login/formLogin",["error"=>$error,"relleno"=>$registro,"isLogin"=>true]);
                    }
                }else{
                    $this->pages->render("pages/login/formLogin",["error"=>$error,"relleno"=>$registro,"isLogin"=>true]);
                }
            }   
            return null;
        }

        /**
         * Función para cerrar la sesión
         */
        public function logout(){
            $_SESSION['identity']=null;
            session_destroy();
            header("Location:".BASE_URL);
        }
    }