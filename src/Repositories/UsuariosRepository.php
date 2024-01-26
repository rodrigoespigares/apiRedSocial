<?php
    namespace Repositories;
    use Lib\DataBase;
    use Lib\Security;
    use Lib\Correo;
    use Models\Usuarios;
    use PDOException;
    use PDO;
    class UsuariosRepository{
        private DataBase $conection;
        private mixed $sql;
        private Correo $correo;
        function __construct(){
            $this->conection = new DataBase();
            $this->correo = new Correo();
        }
        public function findAll():? array {
            $this->conection->querySQL("SELECT * FROM usuarios;");
            return $this->extractAll();
        }
        public function extractAll():?array {
            $usuarios = [];
            try{
                $this->conection->querySQL("SELECT * FROM usuarios");
                $usuariosData = $this->conection->allRegister();
                foreach ($usuariosData as $usuarioData){
                    $usuarios[]=Usuarios::fromArray($usuarioData);
                }
            }catch(PDOException){
                $usuarios=null;
            }
            return $usuarios;
        }
        /**
         * Funcion para crear un usuario con los parametros $nombre,$apellidos,$dni,$email,$usuario,$contrasena
         */
        public function registro( $data){
            try{
                $this->sql = $this->conection->prepareSQL("INSERT INTO usuarios(nombre,apellidos,email,password,rol,confirmado,token,token_exp) VALUES (:nombre,:apellidos,:email,:password,:rol,:confirmado,:token,:token_exp);");
                $token = Security::crearToken(Security::claveSecreta(),["email"=>$data["email"]]);
                $time = date('Y-m-d H:i:s', time()+2300);
                $this->sql->bindValue(":nombre","");
                $this->sql->bindValue(":apellidos","");
                $this->sql->bindValue(":email",$data["email"]);
                $this->sql->bindValue(":password",$data["password"]);
                $this->sql->bindValue(":rol",isset($data["rol"])?$data["rol"]:"user");
                $this->sql->bindValue(":confirmado",0);
                $this->sql->bindValue(":token", $token);
                $this->sql->bindValue(":token_exp",$time);
                $this->sql->execute();
                $this->correo->sendMail($data['email'],$token);
                $result = null;
            }catch(PDOException $e){
                $result = $e->getMessage();
            }
            $this->sql->closeCursor();
            $this->sql = null;
            return $result;
        }
        public function getIdentity($email) {
            try {
                $this->sql = $this->conection->prepareSQL("SELECT * FROM usuarios WHERE email = :email");
                $this->sql->bindValue(":email", $email);
                $this->sql->execute();
                $usuarioData = $this->sql->fetch(PDO::FETCH_ASSOC);
                $this->sql->closeCursor();
                $usuario = $usuarioData ?: null;
            } catch (PDOException $e) {
                $usuario = $e->getMessage();
            }
        
            return $usuario;
        }
        /**
         * Funcion para obtener un usuario por id
         */
        public function getIdentityId($id) {
            try {
                $this->sql = $this->conection->prepareSQL("SELECT * FROM usuarios WHERE id = :id");
                $this->sql->bindValue(":id", $id);
                $this->sql->execute();
                $usuarioData = $this->sql->fetch(PDO::FETCH_ASSOC);
                $this->sql->closeCursor();
                $usuario = $usuarioData ?: null;
            } catch (PDOException $e) {
                $usuario = $e->getMessage();
            }
        
            return $usuario;
        }
        public function addIntento($id) {
            try {

                $this->sql = $this->conection->prepareSQL("UPDATE usuarios SET acceder = acceder + 1 WHERE id = :id;");
                $this->sql->bindValue(":id", $id);
                $this->sql->execute();
                $usuarioData = $this->sql->fetch(PDO::FETCH_ASSOC);
                $this->sql->closeCursor();
                $usuario = $usuarioData ?: null;
            } catch (PDOException $e) {
                $usuario = $e->getMessage();
            }
        
            return $usuario;
        }
        public function removeIntento($id) {
            try {

                $this->sql = $this->conection->prepareSQL("UPDATE usuarios SET acceder = 0 WHERE id = :id;");
                $this->sql->bindValue(":id", $id);
                $this->sql->execute();
                $usuarioData = $this->sql->fetch(PDO::FETCH_ASSOC);
                $this->sql->closeCursor();
                $usuario = $usuarioData ?: null;
            } catch (PDOException $e) {
                $usuario = $e->getMessage();
            }
        
            return $usuario;
        }
        public function checkToken($token) :bool {
            try {

                $this->sql = $this->conection->prepareSQL("SELECT email FROM usuarios WHERE token = :token;");
                $this->sql->bindValue(":token", $token);
                $this->sql->execute();
                $this->sql->closeCursor();
                $value = true;
            } catch (PDOException $e) {
                $value = false;
            }
        
            return $value;
        }
        public function confirmado($email) : bool {
            try {
                $this->sql = $this->conection->prepareSQL("UPDATE usuarios SET confirmado = 1 WHERE email = :email;");
                $this->sql->bindValue(":email", $email);
                $this->sql->execute();
                $this->sql->closeCursor();
                $value = true;
            } catch (PDOException $e) {
                $value = false;
            }
        
            return $value;
        }
    }