<?php 
    namespace Controllers;
    use Services\PublicacionesService;
    use Lib\Pages;
    use Lib\ResponseHttp;
    use Lib\Security;
    use Models\Publicaciones;

    class PublicacionesController{
        private PublicacionesService $service;
        private Pages $pages;
        public function __construct()
        {
            $this->service = new PublicacionesService();
            $this->pages = new Pages();
        }
        /**
         * Función para obtener todas las publicaciones
         */
        public function allPonentes():void{
            if(Security::validateToken()){
                ResponseHttp::setHeaders("GET");
                $result = $this->service->allPonentes();
                $json = [];
                if (count($result)>0) {
                    $json["head"]=ResponseHttp::statusMessage(202,count($result));
                    foreach ($result as $value) {
                    $json["body"][] = array("id"=>$value->getId(),"id_usuario"=>$value->getId_usuario(),"contenido"=>$value->getContenido(),"imagen"=>$value->getImagen(),"fecha_publicacion"=>$value->getFecha_publicacion());
                    }
                }else{
                    $json["head"]=ResponseHttp::statusMessage(404,count($result));
                    $json["body"][]=array();
                }
                $this->pages->renderJSON($json);
            }else{
                $json["head"]=ResponseHttp::statusMessage(500,"El token no es válido es necesario crear otro nuevo");
                $json["body"][]=array();
                $this->pages->renderJSON($json);
            }
            
        }
        /**
         * Función para obtener una publicación por su id
         */
        public function find(string $id):void{
            if(Security::validateToken()){
                ResponseHttp::setHeaders("GET");
                $result = $this->service->find($id);
                $json = [];
                if ($result != null) {
                    $json["head"][]=ResponseHttp::statusMessage(202,count($result)>0?1:0);
                    $json["body"][] = array("id"=>$result['id'],"id_usuario"=>$result['id_usuario'],"contenido"=>$result['contenido'],"imagen"=>$result['imagen'],"fecha_publicacion"=>$result['fecha_publicacion']);
                }else{
                    $json["head"][]=ResponseHttp::statusMessage(404,0);
                    $json["body"][]=array();
                }
                $this->pages->renderJSON($json);
            }else{
                $json["head"]=ResponseHttp::statusMessage(500,"El token no es válido es necesario crear otro nuevo");
                $json["body"][]=array();
                $this->pages->renderJSON($json);
            }
        }
        /**
         * Función para crear una publicación
         */
        public function create():void {
            if (Security::validateToken()) {
                ResponseHttp::setHeaders("POST");
                $data = json_decode(file_get_contents("php://input"));
                $errores = [];
                Publicaciones::validation($data,$errores);
                if(empty($errores)){
                    if($this->service->register($data)){
                        $json["head"][]=ResponseHttp::statusMessage(202,1);
                        $json["body"][]= array("Message"=>"Registro completado");
                    }else{
                        $json["head"][]=ResponseHttp::statusMessage(404,0);
                        $json["body"][]= array("Message"=>"No se ha completado el registro");
                    }
                }else{
                    $json["head"][]=ResponseHttp::statusMessage(500,0);
                    $json["body"][]= array("Message"=>"No se ha completado el registro por errores de validación","errores"=>$errores);
                }
                $this->pages->renderJSON($json);
            }else{
                $json["head"]=ResponseHttp::statusMessage(500,"El token no es válido es necesario crear otro nuevo");
                $json["body"][]=array();
                $this->pages->renderJSON($json);
            }
        }
        /**
         * Función para eliminar una publicacion
         */
        public function delete(string $id):void{
            if (Security::validateToken()) {
                ResponseHttp::setHeaders("DELETE");
                if($this->service->remove($id)){
                    $json["head"][]=ResponseHttp::statusMessage(202,1);
                    $json["body"][]= array("Message"=>"Publicación eliminiada");
                }else{
                    $json["head"][]=ResponseHttp::statusMessage(404,0);
                    $json["body"][]= array("Message"=>"No se ha eliminado la publicación");
                }
                $this->pages->renderJSON($json);
            }else{
                $json["head"]=ResponseHttp::statusMessage(500,"El token no es válido es necesario crear otro nuevo");
                $json["body"][]=array();
                $this->pages->renderJSON($json);
            }
        }
        /**
         * Función para modificar una publicación
         */
        public function edit(string $id):void {
            if (Security::validateToken()) {
                ResponseHttp::setHeaders("PUT");
                $data = json_decode(file_get_contents("php://input"));
                $errores = [];
                Publicaciones::validation($data,$errores);
                if(empty($errores)){
                    if($this->service->edit($id,$data)){
                        $json["head"][]=ResponseHttp::statusMessage(202,1);
                        $json["body"][]= array("Message"=>"Modificación completada");
                    }else{
                        $json["head"][]=ResponseHttp::statusMessage(404,0);
                        $json["body"][]= array("Message"=>"No se ha completado la modificación");
                    }
                }else{
                    $json["head"][]=ResponseHttp::statusMessage(500,0);
                    $json["body"][]= array("Message"=>"No se ha completado la modificación por errores de validación","errores"=>$errores);
                }
                $this->pages->renderJSON($json);
            }else{
                $json["head"]=ResponseHttp::statusMessage(500,"El token no es válido es necesario crear otro nuevo");
                $json["body"][]=array();
                $this->pages->renderJSON($json);
            }
        }
    }
?>