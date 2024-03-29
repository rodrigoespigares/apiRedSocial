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
        /**
         * Función para extraer todas las publicaciones
         */
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
         * Función para crear una publicacion con los parametros $nombre,$apellidos,$dni,$email,$usuario,$contrasena
         */
        public function registro( $data){
            try{
                $value = (isset($data->imagen)? $data->imagen: "");
                $this->sql = $this->conection->prepareSQL("INSERT INTO publicaciones(id_usuario,contenido,imagen,fecha_publicacion) VALUES (:id_usuario,:contenido,:imagen,:fecha_publicacion);");
                $this->sql->bindValue(":id_usuario",$data->id_usuario);
                $this->sql->bindValue(":contenido",$data->contenido);
                $this->sql->bindValue(":imagen",$value);
                $this->sql->bindValue(":fecha_publicacion",$data->fecha_publicacion);
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
         * Función para obtener una publicacion por id
         */
        public function find(string $id) {
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
        /**
         * Función para eliminar una publicación
         * 
         * 
         * @param string $id con el id de la publicacion a borrar
         * @return bool
         */
        public function remove(string $id) :bool {
            try {
                $this->sql = $this->conection->prepareSQL("DELETE FROM publicaciones WHERE id = :id");
                $this->sql->bindValue(":id", $id);
                $this->sql->execute();
                $rowCount = $this->sql->rowCount();
                $this->sql->closeCursor();
                $result = ($rowCount > 0);
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
                $value = (isset($data->imagen)? $data->imagen: "");
                $this->sql = $this->conection->prepareSQL("UPDATE publicaciones SET id_usuario=:id_usuario,contenido=:contenido,imagen=:imagen,fecha_publicacion =:fecha_publicacion WHERE id=:id;");
                $this->sql->bindValue(":id",$id);
                $this->sql->bindValue(":id_usuario",$data->id_usuario);
                $this->sql->bindValue(":contenido",$data->contenido);
                $this->sql->bindValue(":imagen",$value);
                $this->sql->bindValue(":fecha_publicacion",$data->fecha_publicacion);
                $this->sql->execute();
                $rowCount = $this->sql->rowCount();
                $this->sql->closeCursor();
                $result = ($rowCount > 0);
            }catch(PDOException $e){
                $result = false;
            }
            $this->sql = null;
            return $result;
        }
    }