<?php
// config/conexion.php

class Conexion {
    private $host = 'localhost';
    private $db_name = 'sallepresencia';
    private $username = 'root';
    private $password = '';
    private $conn = null;
    
    // Método para obtener la conexión
    public function getConexion() {
        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name,
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->exec("set names utf8");
            return $this->conn;
        } catch(PDOException $e) {
            echo "Error de conexión: " . $e->getMessage();
            return null;
        }
    }
    
    // Método para cerrar la conexión
    public function closeConexion() {
        $this->conn = null;
    }
}
?>