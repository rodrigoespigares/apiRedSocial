<?php
    namespace Repositories;
    use Lib\DataBase;
    use Models\Publicaciones;
    use PDOException;
    use PDO;
    class PublicacionesRepository{
        private DataBase $conection;
        private mixed $sql;
        function __construct(){
            $this->conection = new DataBase();
        }
        public function findAll():? array {
            $this->conection->querySQL("SELECT * FROM publicaciones;");
            return $this->extractAll();
        }
        public function extractAll():?array {
            $datos = [];
            try{
                $this->conection->querySQL("SELECT * FROM publicaciones");
                $datosData = $this->conection->allRegister();
                foreach ($datosData as $datoData){
                    $datos[]=Publicaciones::fromArray($datoData);
                }
            }catch(PDOException){
                $datos=null;
            }
            return $datos;
        }
        /**
         * Funcion para crear una publicacion con los parametros $nombre,$apellidos,$dni,$email,$usuario,$contrasena
         */
        public function registro( $data){
            try{
                $this->sql = $this->conection->prepareSQL("INSERT INTO publicaciones(nombre,apellidos,imagen,tags,redes,email) VALUES (:nombre,:apellidos,:imagen,:tags,:redes,:email);");
                $this->sql->bindValue(":nombre",$data->Nombre);
                $this->sql->bindValue(":apellidos",$data->Apellidos);
                $this->sql->bindValue(":imagen",$data->Imagen);
                $this->sql->bindValue(":tags",$data->Tags);
                $this->sql->bindValue(":redes",$data->Redes);
                $this->sql->bindValue(":email",$data->Email);
                $this->sql->execute();
                $result = true;
            }catch(PDOException $e){
                $result = false;
            }
            $this->sql->closeCursor();
            $this->sql = null;
            return $result;
        }
        /**
         * Funcion para obtener un ponente por id
         */
        public function find($id) {
            try {
                $this->sql = $this->conection->prepareSQL("SELECT * FROM publicaciones WHERE id = :id");
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
        public function remove($id) :bool {
            try {
                $this->sql = $this->conection->prepareSQL("DELETE FROM publicaciones WHERE id = :id");
                $this->sql->bindValue(":id", $id);
                $this->sql->execute();
                $this->sql->closeCursor();
                $result = true;
            } catch (PDOException $e) {
                $result = false;
            }
            return $result;
        }
        /**
         * Funcion para editar un ponente con los parametros $id y $data
         */
        public function edit(string $id,object $data){
            try{
                $this->sql = $this->conection->prepareSQL("UPDATE ponentes SET nombre=:nombre,apellidos=:apellidos,imagen=:imagen,tags =:tags,redes=:redes,email=:email WHERE id=:id;");
                $this->sql->bindValue(":id",$id);
                $this->sql->bindValue(":nombre",$data->Nombre);
                $this->sql->bindValue(":apellidos",$data->Apellidos);
                $this->sql->bindValue(":imagen",$data->Imagen);
                $this->sql->bindValue(":tags",$data->Tags);
                $this->sql->bindValue(":redes",$data->Redes);
                $this->sql->bindValue(":email",$data->Email);
                $this->sql->execute();
                $result = true;
            }catch(PDOException $e){
                $result = false;
            }
            $this->sql->closeCursor();
            $this->sql = null;
            return $result;
        }
    }