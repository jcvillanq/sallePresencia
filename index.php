<?php
// index.php
session_start();

// Incluir el archivo de conexión
require_once 'config/conexion.php';

// Comprobar si ya hay una sesión iniciada
if (isset($_SESSION['usuario_id'])) {
    // Redireccionar según el rol
    if ($_SESSION['usuario_rol'] === 'admin') {
        header('Location: gestionfichadas.php');
        exit;
    } else {
        header('Location: fichar.php');
        exit;
    }
}

// Incluir el header
include_once 'includes/header.php';
?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header bg-primary-dark text-white text-center">
                <h4 class="my-0">Iniciar Sesión</h4>
            </div>
            <div class="card-body p-4">
                <?php
                // Mostrar mensaje de error si existe
                if (isset($_GET['error'])) {
                    echo '<div class="alert alert-danger" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>' . htmlspecialchars($_GET['error']) . '
                    </div>';
                }
                ?>
                
                <form action="login.php" method="POST">
                    <div class="mb-3">
                        <label for="email" class="form-label">Correo Electrónico</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            <input type="email" class="form-control" id="email" name="email" 
                                placeholder="usuario@ejemplo.com" required>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="password" class="form-label">Contraseña</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            <input type="password" class="form-control" id="password" name="password" 
                                placeholder="Tu contraseña" required>
                        </div>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-sign-in-alt me-2"></i>Iniciar Sesión
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
// Incluir el footer
include_once 'includes/footer.php';
?>