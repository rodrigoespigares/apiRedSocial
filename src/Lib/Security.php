<?php 
    namespace Lib;
    use Lib\ResponseHttp;
    use Firebase\JWT\JWT;
    use Firebase\JWT\Key;
    use Firebase\JWT\ExpiredException;
    use Services\UsuariosService;
    use PDOException;
    
    class Security{
        
        /**
         * Función para obtener la clave secreta del .env
         */
        final public static function claveSecreta() :string {
            return $_ENV['SECRET_KEY'];
        }
        /**
         * Función para encriptar la password
         */
        final public  static function encriptarPassw(string $passw){
            $opciones = ['cost' => 12];
            return password_hash($passw,PASSWORD_BCRYPT, $opciones);
        }
        /**
         * Función para validar la password
         */
        final public static function validaPassw(string $passw, string $passwhash) : bool {
            return password_verify($passw, $passwhash);
        }
        /**
         * Función para crear el token con un tiempo de 2300 segundos desde el momento de la creación
         */
        final public static function crearToken(string $key, array $data) :string {
            $time = time();
            $token = array(
                "iay"=>$time,
                "exp"=>$time + 2300,
                "data"=>$data
            );

            return JWT::encode($token,$key,"HS256");
        }
        /**
         * Función para obtener el token de la cabecera
         */
        final public static function getToken(){
            $header = apache_request_headers();
            if(!isset($header['Authorization'])){
                return $response['message'] = ResponseHttp::statusMessage(404,"No tienes autorización");
            }
            try{
                $authArr = explode(' ',$header['Authorization']);
                $token = $authArr[1];
                $decodeToken = JWT::decode($token, new Key(Security::claveSecreta(),'HS256'));
                return $decodeToken;
            }catch(PDOException $e){
                return $response['message'] = json_encode(ResponseHttp::statusMessage(401,"Token expirado o invalido"));
            }
        }
        /**
         * Función para devolver el token decoficado
         * 
         */
        final public static function returnToken(string $token) {
            
            try{
                $decodeToken = JWT::decode($token, new Key(Security::claveSecreta(),'HS256'));
                return $decodeToken;
            }catch(ExpiredException $e){
                return false;
            }
        }
        /**
         * Funcón para validar el token
         */
        final public static function validateToken() :bool {
            $service = new UsuariosService();
            $info = self::getToken();
            if(isset($info->data->email)){
                $email = $info->data->email;
                $value = strtotime($service->checkTokenExp($email)['token_exp']);
                return $value >= time();
            }else{
                return false;
            }    
        }
        /**
         * Función para caducar un token
         */
        final public static function caducarToken() {
            $service = new UsuariosService();
            $info = self::getToken();
            $service->caducarTokenExp($info->data->email);
        }
    }

?>