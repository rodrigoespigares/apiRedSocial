<?php

namespace Repositories;

use Lib\DataBase;
use Lib\Security;
use Lib\Correo;
use Models\Usuarios;
use PDOException;
use PDO;

class UsuariosRepository
{
    private DataBase $conection;
    private mixed $sql;
    private Correo $correo;
    function __construct()
    {
        $this->conection = new DataBase();
        $this->correo = new Correo();
    }
    public function findAll(): ?array
    {
        $this->conection->querySQL("SELECT * FROM usuarios;");
        return $this->extractAll();
    }
    public function extractAll(): ?array
    {
        $usuarios = [];
        try {
            $this->conection->querySQL("SELECT * FROM usuarios");
            $usuariosData = $this->conection->allRegister();
            foreach ($usuariosData as $usuarioData) {
                $usuarios[] = Usuarios::fromArray($usuarioData);
            }
        } catch (PDOException) {
            $usuarios = null;
        }
        return $usuarios;
    }
    /**
     * Método de registro de usuarios.
     *
     * Este método se utiliza para registrar un nuevo usuario en la base de datos.
     * Toma los datos del usuario como parámetro y realiza una inserción en la tabla 'usuarios'.
     * Genera un token de autenticación utilizando la clase Security y lo guarda en la columna 'token'.
     * También establece la fecha de expiración del token en 2300 segundos después de la fecha actual.
     * Envía un correo electrónico de confirmación al usuario utilizando la clase Correo.
     * Si ocurre algún error durante el proceso, se captura la excepción PDOException y se devuelve el mensaje de error.
     * Al finalizar, se cierra la conexión y se devuelve el resultado de la operación.
     *
     * @param array $data Los datos del usuario a registrar.
     * @return string|null El resultado de la operación o null si no hay errores.
     */
    public function registro($data)
    {
        try {
            $this->sql = $this->conection->prepareSQL("INSERT INTO usuarios(nombre,apellidos,email,password,rol,confirmado,token,token_exp) VALUES (:nombre,:apellidos,:email,:password,:rol,:confirmado,:token,:token_exp);");
            $token = Security::crearToken(Security::claveSecreta(), ["email" => $data["email"]]);
            $time = date('Y-m-d H:i:s', time() + 2300);
            $this->sql->bindValue(":nombre", "");
            $this->sql->bindValue(":apellidos", "");
            $this->sql->bindValue(":email", $data["email"]);
            $this->sql->bindValue(":password", $data["password"]);
            $this->sql->bindValue(":rol", isset($data["rol"]) ? $data["rol"] : "user");
            $this->sql->bindValue(":confirmado", 0);
            $this->sql->bindValue(":token", $token);
            $this->sql->bindValue(":token_exp", $time);
            $this->sql->execute();
            $this->correo->sendMail($data['email'], $token);
            $result = null;
        } catch (PDOException $e) {
            $result = $e->getMessage();
        }
        $this->sql->closeCursor();
        $this->sql = null;
        return $result;
    }
    public function getIdentity($email)
    {
        try {
            $this->sql = $this->conection->prepareSQL("SELECT * FROM usuarios WHERE email = :email");
            $this->sql->bindValue(":email", $email);
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
     * Funcion para obtener un usuario por id
     */
    public function getIdentityId($id)
    {
        try {
            $this->sql = $this->conection->prepareSQL("SELECT * FROM usuarios WHERE id = :id");
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
    public function checkToken($token): bool
    {
        try {
            $this->sql = $this->conection->prepareSQL("SELECT email FROM usuarios WHERE token = :token;");
            $this->sql->bindValue(":token", $token);
            $this->sql->execute();
            $this->sql->closeCursor();
            $value = true;
        } catch (PDOException $e) {
            $value = false;
        }
        return $value;
    }
    public function checkTokenExp($email)
    {
        try {

            $this->sql = $this->conection->prepareSQL("SELECT token_exp FROM usuarios WHERE email = :email;");
            $this->sql->bindValue(":email", $email);
            $this->sql->execute();
            $valueData = $this->sql->fetch(PDO::FETCH_ASSOC);
            $this->sql->closeCursor();
            $value = $valueData ?: null;
        } catch (PDOException $e) {
            $value = false;
        }

        return $value;
    }
    public function confirmado($email): bool
    {
        try {
            $time = date('Y-m-d H:i:s', time() - 2300);
            $this->sql = $this->conection->prepareSQL("UPDATE usuarios SET confirmado = 1, token_exp = :token_exp WHERE email = :email;");
            $this->sql->bindValue(":email", $email);
            $this->sql->bindValue(":token_exp", $time);
            $this->sql->execute();
            $this->sql->closeCursor();
            $value = true;
        } catch (PDOException $e) {
            $value = false;
        }

        return $value;
    }
    public function changeToken(string $email, string $token)
    {
        try {
            $time = date('Y-m-d H:i:s', time() + 2300);
            $this->sql = $this->conection->prepareSQL("UPDATE usuarios SET token = :token, token_exp = :token_exp WHERE email = :email;");
            $this->sql->bindValue(":email", $email);
            $this->sql->bindValue(":token", $token);
            $this->sql->bindValue(":token_exp", $time);
            $this->sql->execute();
            $this->sql->closeCursor();
            $value = true;
        } catch (PDOException $e) {
            $value = false;
        }

        return $value;
    }
    public function caducarToken(string $email):? string {
        try {
            $time = date('Y-m-d H:i:s', time() - 6000);
            $this->sql = $this->conection->prepareSQL("UPDATE usuarios SET token_exp = :token_exp WHERE email = :email;");
            $this->sql->bindValue(":email", $email);
            $this->sql->bindValue(":token_exp", $time);
            $this->sql->execute();
            $this->sql->closeCursor();
            $value = null;
        } catch (PDOException $e) {
            $value = false;
        }

        return $value;
    }
}
