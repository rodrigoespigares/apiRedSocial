<?php

namespace Models;

use Lib\Validar;

class Publicaciones
{
    protected static $errores;
    public function __construct(
        private string|null $id = null,
        private string $id_usuario,
        private string $contenido,
        private string $imagen,
        private string $fecha_publicacion,
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
     * Get the value of id_usuario
     */
    public function getId_usuario(): string
    {
        return $this->id_usuario;
    }

    /**
     * Set the value of id_usuario
     */
    public function setId_usuario(string $id_usuario): void
    {
        $this->id_usuario = $id_usuario;

    }

    /**
     * Get the value of contenido
     */
    public function getContenido(): string
    {
        return $this->contenido;
    }

    /**
     * Set the value of contenido
     */
    public function setContenido(string $contenido): void
    {
        $this->contenido = $contenido;

    }
    /**
     * Get the value of imagen
     */
    public function getImagen(): string
    {
        return $this->imagen;
    }

    /**
     * Set the value of imagen
     */
    public function setImagen(string $imagen): void
    {
        $this->imagen = $imagen;

    }
    /**
     * Get the value of fecha_publicacion
     */
    public function getFecha_publicacion(): string
    {
        return $this->fecha_publicacion;
    }

    /**
     * Set the value of fecha_publicacion
     */
    public function setFecha_publicacion(string $fecha_publicacion): void
    {
        $this->fecha_publicacion = $fecha_publicacion;

    }



    /**
     * Crea un usuario a partir de un array
     */
    public static function fromArray(array $data): Publicaciones
    {
        return new Publicaciones(
            $data['id'] ?? null,
            $data['id_usuario'] ?? '',
            $data['contenido'] ?? "",
            $data['imagen'] ?? "",
            $data['fecha_publicacion'] ?? "",
        );
    }
    ## VALIDAR
    public static function validation(object $data, array &$errores): array
    {
        ## Nombre
        if (!empty($data->Nombre) && !Validar::son_letras($data->Nombre)) {
            $errores['nombre'] = "Nombre tiene caracteres extraños";
        }
        ## Apellidos
        if (!empty($data->Apellidos) && !Validar::son_letras($data->Apellidos)) {
            $errores['apellidos'] = "Apellidos tiene caracteres extraños";
        }
        # Tags
        if (!empty($data->Tags) && !Validar::son_letras($data->Tags)){
            $errores['tags'] = "Las etiquetas tienen caracteres extraños";
        }
        # Redes
        if (!empty($data->Redes) && !Validar::son_letras($data->Redes)){
            $errores['redes'] = "Redes tienen caracteres extraños";
        }
        ## Email
        if (!empty($data->Email) && !Validar::esEmail($data->Email)){
            $errores['email'] = "Las etiquetas tienen caracteres extraños";
        }
        return $errores;
    }
}
