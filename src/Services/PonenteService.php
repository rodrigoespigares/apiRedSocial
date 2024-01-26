<?php
    namespace Services;
    use Repositories\PonenteRepository;
    class PonenteService{
        // Creando variable con
        private PonenteRepository $userRepository;
        function __construct() {
            $this->userRepository = new PonenteRepository();
        }
        /**
         * Función para obtener todos los ponentes
         * 
         * @return array con los ponentes
         */
        public function allPonentes() :?array {
            return $this->userRepository->findAll();
        }
        /**
         * Funcion para registrar un ponente
         * 
         * @return bool true si se ha registrado false si no se ha registrado
         */
        public function register(object $data):bool{
            return $this->userRepository->registro($data);
        }
        /**
         * Funcion para registrar un ponente
         * 
         * @return bool true si se ha registrado false si no se ha registrado
         */
        public function edit(string $id, object $data):bool{
            return $this->userRepository->edit($id, $data);
        }
        /**
         * Función para buscar un ponente por su id
         * 
         * @param string $id con el id del ponente
         * 
         * @return array con los datos del ponente
         */
        public function find(string $id) :? array{
            return $this->userRepository->find($id);
        }
        /**
         * Funcion para eliminar un ponente
         * 
         * @param string $id con el id del ponente a eliminar
         * 
         * @return bool true si se ha registrado false si no se ha registrado
         */
        public function remove(string $id) : bool{
            return $this->userRepository->remove($id);
        }
    }