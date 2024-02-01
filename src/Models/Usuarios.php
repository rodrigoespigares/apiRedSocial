<?php

namespace Models;

use Lib\Validar;
use Services\UsuariosService;

class Usuarios
{
    protected static $errores;
    public function __construct(
        private string|null $id = null,
        private string $nombre,
        private string $apellidos,
        private string $dni,
        private string $email,
        private string $usuario,
        private string $contrasena,
        private string $acceder,
        private string $rol,
    ) {
    }
    /**
     * Get the value of id
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * Set the value of id
     */
    public function setId(?string $id): void
    {
        $this->id = $id;

    }

    /**
     * Get the value of nombre
     */
    public function getNombre(): string
    {
        return $this->nombre;
    }

    /**
     * Set the value of nombre
     */
    public function setNombre(string $nombre): void
    {
        $this->nombre = $nombre;

    }

    /**
     * Get the value of apellidos
     */
    public function getApellidos(): string
    {
        return $this->apellidos;
    }

    /**
     * Set the value of apellidos
     */
    public function setApellidos(string $apellidos): void
    {
        $this->apellidos = $apellidos;

    }
    /**
     * Get the value of dni
     */
    public function getDni(): string
    {
        return $this->dni;
    }

    /**
     * Set the value of dni
     */
    public function setDni(string $dni): void
    {
        $this->dni = $dni;

    }

    /**
     * Get the value of email
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Set the value of email
     */
    public function setEmail(string $email):void
    {
        $this->email = $email;

    }
    /**
     * Get the value of usuario
     */
    public function getUsuario(): string
    {
        return $this->usuario;
    }

    /**
     * Set the value of usuario
     */
    public function setUsuario(string $usuario):void
    {
        $this->usuario = $usuario;

    }
     /**
     * Get the value of contrasena
     */
    public function getContrasena(): string
    {
        return $this->contrasena;
    }

    /**
     * Set the value of contrasena
     */
    public function setContrasena(string $contrasena):void
    {
        $this->contrasena = $contrasena;

    }
    /**
     * Get the value of rol
     */
    public function getRol(): string
    {
        return $this->rol;
    }

    /**
     * Set the value of rol
     */
    public function setRol(string $rol): void
    {
        $this->rol = $rol;

    }
    /**
     * Get the value of acceder
     */
    public function getAcceder(): string
    {
        return $this->acceder;
    }

    /**
     * Set the value of acceder
     */
    public function setAcceder(string $acceder): void
    {
        $this->acceder = $acceder;

    }
    /**
     * Crea un usuario a partir de un array
     */
    public static function fromArray(array $data): Usuarios
    {
        return new Usuarios(
            $data['id'] ?? null,
            $data['nombre'] ?? '',
            $data['apellidos'] ?? "",
            $data['dni'] ?? "",
            $data['email'] ?? "",
            $data['usuario'] ?? "",
            $data['contrasena'] ?? "",
            $data['acceder'] ?? "",
            $data['rol'] ?? "profesor",
            
        );
    }
    public static function validation(array $data, array &$errores): array
    {
        $service = new UsuariosService();
        ##############
        #  PASSWORD  #
        ##############
        if (empty($data['password'])) {
            $errores['password'] = "Contraseña obligatoria";
        } elseif ($data['password'] != $data['password2']) {
            $errores['password'] = "Las contraseñas no coinciden";
            $errores['password2'] = "Las contraseñas no coinciden";
        }
        if (strlen($data['password']) <= 7) {
            $errores['password'] = "Contraseña debe tener más de 8 caracteres";
        }
        ###############
        #    EMAIL    #
        ###############
        if (empty($data['email'])) {
            $errores['email'] = "Email no puede quedar vacío";
        }
        if(!$service->checkMail($data['email'])){
            $errores['email'] = "Email ya registrado";
        }

        return $errores;
    }
    public static function validationLogin(array $data,array &$errores) : array {
        $pass = $data['password'];
        $email = $data['email'];
        if (empty($pass)) {
            $errores['password'] = "Contraseña obligatoria";
        }
        if (empty($email)) {
            $errores['email'] = "Email obligatorio";
        }else if(!Validar::esEmail($email)){
            $errores['email'] = "Parece que eso no es un email";
        }
        return $errores;
    }
}
