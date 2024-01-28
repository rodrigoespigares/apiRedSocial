<?php
    namespace Services;
    use Repositories\PublicacionesRepository;
    class PublicacionesService{
        // Creando variable con
        private PublicacionesRepository $reposiroty;
        function __construct() {
            $this->reposiroty = new PublicacionesRepository();
        }
        /**
         * Función para obtener todos las publicaciones
         * 
         * @return array con las publicaciones
         */
        public function allPonentes() :?array {
            return $this->reposiroty->findAll();
        }
        /**
         * Funcion para registrar una publicacion
         * 
         * @return bool true si se ha registrado false si no se ha registrado
         */
        public function register(object $data):bool{
            return $this->reposiroty->registro($data);
        }
        /**
         * Funcion para editar una publicacion
         * 
         * @return bool true si se ha modificado false si no se ha modificado
         */
        public function edit(string $id, object $data):bool{
            return $this->reposiroty->edit($id, $data);
        }
        /**
         * Función para buscar un ponente por su id
         * 
         * @param string $id con el id de la publicacion
         * 
         * @return array con los datos de la publicacion
         */
        public function find(string $id) :? array{
            return $this->reposiroty->find($id);
        }
        /**
         * Funcion para eliminar una publicacion
         * 
         * @param string $id con el id de la publicacion a eliminar
         * 
         * @return bool true si se ha eliminado false si no se ha eliminado
         */
        public function remove(string $id) : bool{
            return $this->reposiroty->remove($id);
        }
        
    }