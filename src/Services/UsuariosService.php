<?php
    namespace Services;
    use Repositories\UsuariosRepository;
    class UsuariosService{
        // Creando variable con
        private UsuariosRepository $userRepository;
        function __construct() {
            $this->userRepository = new UsuariosRepository();
        }
        /**
         * Registra un usuario
         */
        public function register($data):void{
            $this->userRepository->registro($data);
        }
        /**
         * Obtiene los datos de un usuario
         */
        public function getIdentity($usuario) {
            return $this->userRepository->getIdentity($usuario);
        }
        /**
         * Verifica el token
         */
        public function checkToken($token) :? string {
            return $this->userRepository->checkToken($token);
        }
        /**
         * Verifica la fecha de expedicion del token
         */
        public function checkTokenExp($email){
            return $this->userRepository->checkTokenExp($email);
        }
        /**
         * Confirma el usuario
         */
        public function confirmado($email) : bool {
            return $this->userRepository->confirmado($email);
        }
        /**
         * Crea un nuevo token para consultas
         */
        public function changeToken(string $email, string $token) {
            $this->userRepository->changeToken($email,$token);
        }
        /**
         * Caduca un token
         */
        public function caducarTokenExp(string $email) {
            $this->userRepository->caducarToken($email);
        }
        /**
         * Cambia el token de validación
         */
        public function changeTokenConfirmacion(string $email, string $token) {
            $this->userRepository->changeTokenConfirmacion($email,$token);
        }
    }