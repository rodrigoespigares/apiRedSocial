<?php 
    namespace Lib;
    use Lib\ResponseHttp;
    use Firebase\JWT\JWT;
    use Firebase\JWT\Key;
    use PDOException;
    class Security{
        final public static function claveSecreta() :string {
            return $_ENV['SECRET_KEY'];
        }
        final public  static function encriptarPassw(string $passw){
            $opciones = ['cost' => 12];
            return password_hash($passw,PASSWORD_BCRYPT, $opciones);
        }
        final public static function validaPassw(string $passw, string $passwhash) : bool {
            return password_verify($passw, $passwhash);
        }
        final public static function crearToken(string $key, array $data) :string {
            $time = time();
            $token = array(
                "iay"=>$time,
                "exp"=>$time + 3600,
                "data"=>$data
            );

            return JWT::encode($token,$key,"HS256");
        }
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
        final public static function returnToken($token) {
            try{
                $decodeToken = JWT::decode($token, new Key(Security::claveSecreta(),'HS256'));
                return $decodeToken;
            }catch(PDOException $e){
                return $response['message'] = json_encode(ResponseHttp::statusMessage(401,"Token expirado o invalido"));
            }
        }
    }

?>