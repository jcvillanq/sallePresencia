<?php
// clases/clsUsuario.php

// Incluir archivo de conexión
require_once 'config/conexion.php';

class Usuario {
    // Propiedades de la clase que corresponden a las columnas de la tabla
    private $conn;
    private $id_usuario;
    private $nombre;
    private $email;
    private $password;
    private $codigo;
    private $horas;
    private $rol;

    // Constructor
    public function __construct() {
        $conexion = new Conexion();
        $this->conn = $conexion->getConexion();
    }

    // Getters y setters
    public function getId() {
        return $this->id_usuario;
    }

    public function setId($id_usuario) {
        $this->id_usuario = $id_usuario;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function getCodigo() {
        return $this->codigo;
    }

    public function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    public function getHoras() {
        return $this->horas;
    }

    public function setHoras($horas) {
        $this->horas = $horas;
    }

    public function getRol() {
        return $this->rol;
    }

    public function setRol($rol) {
        $this->rol = $rol;
    }

    // Método para crear un nuevo usuario
    public function crear() {
        try {
            // Verificar si el email ya existe
            if ($this->emailExiste($this->email)) {
                return false;
            }

            $query = "INSERT INTO usuarios (nombre, email, password, codigo, horas, rol) 
                      VALUES (:nombre, :email, :password, :codigo, :horas, :rol)";
            
            $stmt = $this->conn->prepare($query);
            
            // Sanitización de datos
            $this->nombre = htmlspecialchars(strip_tags($this->nombre));
            $this->email = htmlspecialchars(strip_tags($this->email));
            $this->password = htmlspecialchars(strip_tags($this->password));
            $this->codigo = htmlspecialchars(strip_tags($this->codigo));
            $this->rol = htmlspecialchars(strip_tags($this->rol));
            
            // Bind de parámetros
            $stmt->bindParam(':nombre', $this->nombre);
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':password', $this->password);
            $stmt->bindParam(':codigo', $this->codigo);
            $stmt->bindParam(':horas', $this->horas);
            $stmt->bindParam(':rol', $this->rol);
            
            // Ejecutar query
            if ($stmt->execute()) {
                $this->id_usuario = $this->conn->lastInsertId();
                return true;
            }
            
            return false;
        } catch (PDOException $e) {
            echo "Error en crear usuario: " . $e->getMessage();
            return false;
        }
    }

    // Método para actualizar un usuario existente
    public function actualizar() {
        try {
            // Verificar si el email ya existe para otro usuario
            if ($this->emailExisteOtroUsuario($this->email, $this->id_usuario)) {
                return false;
            }

            $query = "UPDATE usuarios 
                      SET nombre = :nombre, email = :email, codigo = :codigo, 
                          horas = :horas, rol = :rol 
                      WHERE id_usuario = :id_usuario";
            
            // Si se proporciona una contraseña, actualizarla también
            if (!empty($this->password)) {
                $query = "UPDATE usuarios 
                          SET nombre = :nombre, email = :email, password = :password, 
                              codigo = :codigo, horas = :horas, rol = :rol 
                          WHERE id_usuario = :id_usuario";
            }
            
            $stmt = $this->conn->prepare($query);
            
            // Sanitización de datos
            $this->nombre = htmlspecialchars(strip_tags($this->nombre));
            $this->email = htmlspecialchars(strip_tags($this->email));
            $this->codigo = htmlspecialchars(strip_tags($this->codigo));
            $this->rol = htmlspecialchars(strip_tags($this->rol));
            
            // Bind de parámetros
            $stmt->bindParam(':nombre', $this->nombre);
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':codigo', $this->codigo);
            $stmt->bindParam(':horas', $this->horas);
            $stmt->bindParam(':rol', $this->rol);
            $stmt->bindParam(':id_usuario', $this->id_usuario);
            
            // Si hay contraseña, hacer bind también
            if (!empty($this->password)) {
                $this->password = htmlspecialchars(strip_tags($this->password));
                $stmt->bindParam(':password', $this->password);
            }
            
            // Ejecutar query
            if ($stmt->execute()) {
                return true;
            }
            
            return false;
        } catch (PDOException $e) {
            echo "Error en actualizar usuario: " . $e->getMessage();
            return false;
        }
    }

    // Método para listar todos los usuarios
    public function listar() {
        try {
            $query = "SELECT * FROM usuarios ORDER BY nombre ASC";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            
            return $stmt;
        } catch (PDOException $e) {
            echo "Error al listar usuarios: " . $e->getMessage();
            return null;
        }
    }

    // Método para eliminar un usuario
    public function eliminar() {
        try {
            $query = "DELETE FROM usuarios WHERE id_usuario = :id_usuario";
            $stmt = $this->conn->prepare($query);
            
            // Sanitizar ID
            $this->id_usuario = htmlspecialchars(strip_tags($this->id_usuario));
            
            // Bind del ID
            $stmt->bindParam(':id_usuario', $this->id_usuario);
            
            // Ejecutar query
            if ($stmt->execute()) {
                return true;
            }
            
            return false;
        } catch (PDOException $e) {
            echo "Error al eliminar usuario: " . $e->getMessage();
            return false;
        }
    }

    // Método para cargar un usuario por su ID
    public function cargar() {
        try {
            $query = "SELECT * FROM usuarios WHERE id_usuario = :id_usuario";
            $stmt = $this->conn->prepare($query);
            
            // Sanitizar ID
            $this->id_usuario = htmlspecialchars(strip_tags($this->id_usuario));
            
            // Bind del ID
            $stmt->bindParam(':id_usuario', $this->id_usuario);
            
            // Ejecutar query
            $stmt->execute();
            
            // Obtener fila
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($row) {
                // Poblar propiedades
                $this->nombre = $row['nombre'];
                $this->email = $row['email'];
                $this->password = $row['password'];
                $this->codigo = $row['codigo'];
                $this->horas = $row['horas'];
                $this->rol = $row['rol'];
                return true;
            }
            
            return false;
        } catch (PDOException $e) {
            echo "Error al cargar usuario: " . $e->getMessage();
            return false;
        }
    }

    // Método avanzado para login
    public function login($email, $password) {
        try {
            $query = "SELECT * FROM usuarios WHERE email = :email";
            $stmt = $this->conn->prepare($query);
            
            // Sanitizar email
            $email = htmlspecialchars(strip_tags($email));
            
            // Bind de parámetros
            $stmt->bindParam(':email', $email);
            
            // Ejecutar query
            $stmt->execute();
            
            // Verificar si existe el usuario
            if ($stmt->rowCount() > 0) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                
                // Verificar contraseña (temporal, sin hash)
                if ($password === $row['password']) {
                    // Poblar propiedades
                    $this->id_usuario = $row['id_usuario'];
                    $this->nombre = $row['nombre'];
                    $this->email = $row['email'];
                    $this->password = $row['password'];
                    $this->codigo = $row['codigo'];
                    $this->horas = $row['horas'];
                    $this->rol = $row['rol'];
                    return true;
                }
            }
            
            return false;
        } catch (PDOException $e) {
            echo "Error en login: " . $e->getMessage();
            return false;
        }
    }

    // Método para cambiar la contraseña
    public function cambiarPassword($nueva_password) {
        try {
            $query = "UPDATE usuarios SET password = :password WHERE id_usuario = :id_usuario";
            $stmt = $this->conn->prepare($query);
            
            // Sanitizar datos
            $nueva_password = htmlspecialchars(strip_tags($nueva_password));
            $this->id_usuario = htmlspecialchars(strip_tags($this->id_usuario));
            
            // Bind de parámetros
            $stmt->bindParam(':password', $nueva_password);
            $stmt->bindParam(':id_usuario', $this->id_usuario);
            
            // Ejecutar query
            if ($stmt->execute()) {
                $this->password = $nueva_password;
                return true;
            }
            
            return false;
        } catch (PDOException $e) {
            echo "Error al cambiar contraseña: " . $e->getMessage();
            return false;
        }
    }

    // Método auxiliar para verificar si un email ya existe
    private function emailExiste($email) {
        try {
            $query = "SELECT COUNT(*) FROM usuarios WHERE email = :email";
            $stmt = $this->conn->prepare($query);
            
            // Bind del email
            $stmt->bindParam(':email', $email);
            
            // Ejecutar query
            $stmt->execute();
            
            // Obtener resultado
            $count = $stmt->fetchColumn();
            
            return $count > 0;
        } catch (PDOException $e) {
            echo "Error al verificar email: " . $e->getMessage();
            return true; // En caso de error, asumimos que existe para prevenir duplicados
        }
    }

    // Método auxiliar para verificar si un email existe para otro usuario
    private function emailExisteOtroUsuario($email, $id_usuario) {
        try {
            $query = "SELECT COUNT(*) FROM usuarios WHERE email = :email AND id_usuario != :id_usuario";
            $stmt = $this->conn->prepare($query);
            
            // Bind de parámetros
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':id_usuario', $id_usuario);
            
            // Ejecutar query
            $stmt->execute();
            
            // Obtener resultado
            $count = $stmt->fetchColumn();
            
            return $count > 0;
        } catch (PDOException $e) {
            echo "Error al verificar email para otro usuario: " . $e->getMessage();
            return true; // En caso de error, asumimos que existe para prevenir duplicados
        }
    }
}
?>