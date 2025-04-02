<?php
// login.php
session_start();

// Incluir el archivo de conexión
require_once 'config/conexion.php';

// Comprobar si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    
    // Validar que se han recibido los datos necesarios
    if (empty($email) || empty($password)) {
        header('Location: index.php?error=Todos los campos son obligatorios');
        exit;
    }
    
    try {
        // Crear una instancia de la conexión
        $conexion = new Conexion();
        $conn = $conexion->getConexion();
        
        // Consulta preparada para evitar inyección SQL
        $stmt = $conn->prepare("SELECT id_usuario, nombre, email, password, rol FROM usuarios WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        
        // Comprobar si existe el usuario
        if ($stmt->rowCount() > 0) {
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Verificar la contraseña (esto se mejorará en la Tarea 6 con hash)
            if ($password === $usuario['password']) { // Temporal, sin hash
                // Iniciar sesión y guardar datos
                $_SESSION['usuario_id'] = $usuario['id_usuario'];
                $_SESSION['usuario_nombre'] = $usuario['nombre'];
                $_SESSION['usuario_email'] = $usuario['email'];
                $_SESSION['usuario_rol'] = $usuario['rol'];
                
                // Redireccionar según el rol
                if ($usuario['rol'] === 'admin') {
                    header('Location: gestionfichadas.php');
                } else {
                    header('Location: fichar.php');
                }
                exit;
            } else {
                header('Location: index.php?error=Contraseña incorrecta');
                exit;
            }
        } else {
            header('Location: index.php?error=Usuario no encontrado');
            exit;
        }
    } catch(PDOException $e) {
        header('Location: index.php?error=Error en el servidor: ' . $e->getMessage());
        exit;
    }
} else {
    // Si se accede directamente a login.php sin enviar el formulario
    header('Location: index.php');
    exit;
}
?>