<?php 
    namespace Controllers;
    use Services\PonenteService;
    use Lib\Pages;
    use Lib\ResponseHttp;
use Models\Ponente;

    class ApiPonenteController{
        private PonenteService $service;
        private Pages $pages;
        public function __construct()
        {
            $this->service = new PonenteService();
            $this->pages = new Pages();
        }
        /**
         * Función para obtener todos los ponentes
         */
        public function allPonentes():void{
            ResponseHttp::setHeaders("GET");
            $result = $this->service->allPonentes();
            $json = [];
            if (count($result)>0) {
                $json["head"]=ResponseHttp::statusMessage(202,count($result));
                foreach ($result as $value) {
                   $json["body"][] = array("Id"=>$value->getId(),"Nombre"=>$value->getNombre(),"Apellidos"=>$value->getApellidos(),"Imagen"=>$value->getImagen(),"Tags"=>$value->getTags(),"Redes"=>$value->getRedes(),"Email"=>$value->getEmail());
                }
            }else{
                $json["head"]=ResponseHttp::statusMessage(404,count($result));
                $json["body"][]=array();
            }
            $this->pages->renderJSON($json);
        }
        /**
         * Función para obtener un ponente por su id
         */
        public function find(string $id):void{
            ResponseHttp::setHeaders("GET");
            $result = $this->service->find($id);
            $json = [];
            if ($result != null) {
                $json["head"][]=ResponseHttp::statusMessage(202,count($result)>0?1:0);
                $json["body"][] = array("Id"=>$result['id'],"Nombre"=>$result['nombre'],"Apellidos"=>$result['apellidos'],"Imagen"=>$result['imagen'],"Tags"=>$result['tags'],"Redes"=>$result['redes'],"Email"=>$result['email']);
            }else{
                $json["head"][]=ResponseHttp::statusMessage(404,0);
                $json["body"][]=array();
            }
            $this->pages->renderJSON($json);
        }
        /**
         * Función para crear un ponente
         */
        public function create():void {
            ResponseHttp::setHeaders("POST");
            $data = json_decode(file_get_contents("php://input"));
            $errores = [];
            Ponente::validation($data,$errores);
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
        }
        /**
         * Función para eliminar un ponente
         */
        public function delete(string $id):void{
            ResponseHttp::setHeaders("DELETE");
            
            if($this->service->remove($id)){
                $json["head"][]=ResponseHttp::statusMessage(202,1);
                $json["body"][]= array("Message"=>"Ponente eliminado");
            }else{
                $json["head"][]=ResponseHttp::statusMessage(404,0);
                $json["body"][]= array("Message"=>"No se ha eliminado el ponente");
            }
            
            $this->pages->renderJSON($json);
        }
        /**
         * Función para crear un ponente
         */
        public function edit(string $id):void {
            ResponseHttp::setHeaders("PUT");
            $data = json_decode(file_get_contents("php://input"));
            $errores = [];
            Ponente::validation($data,$errores);
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
        }
    }
?>