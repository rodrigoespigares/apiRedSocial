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
        public function checkToken($token) : bool {
            return $this->userRepository->checkToken($token);
        }
        public function checkTokenExp($email){
            return $this->userRepository->checkTokenExp($email);
        }
        public function confirmado($email) : bool {
            return $this->userRepository->confirmado($email);
        }
        public function changeToken(string $email, string $token) {
            $this->userRepository->changeToken($email,$token);
        }
    }