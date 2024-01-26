<?php
    namespace Services;
    use Repositories\UsuariosRepository;
    class UsuariosService{
        // Creando variable con
        private UsuariosRepository $userRepository;
        function __construct() {
            $this->userRepository = new UsuariosRepository();
        }
        public function allUsers() :?array {
            return $this->userRepository->findAll();
        }
        public function register($data):void{
            $this->userRepository->registro($data);
        }
        public function getIdentity($usuario) {
            return $this->userRepository->getIdentity($usuario);
        }
        public function getIdentityId($id) {
            return $this->userRepository->getIdentityId($id);
        }
        public function addIntento($id) {
            $this->userRepository->addIntento($id);
        }
        public function removeIntento($id) {
            $this->userRepository->removeIntento($id);
        }
        public function checkToken($token) : bool {
            return $this->userRepository->checkToken($token);
        }
        public function confirmado($email) : bool {
            return $this->userRepository->confirmado($email);
        }
    }