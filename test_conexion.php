<?php
// test_conexion.php
// Incluir el archivo de conexión
require_once 'config/conexion.php';

// Título de la página
$titulo = "Test de Conexión - SALLEPRESENCIA";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $titulo; ?></title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome para iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .bg-primary-dark {
            background-color: #003399;
        }
        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 20px;
            background-color: #f8f9fa;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-primary-dark text-white text-center">
                        <h4 class="my-0"><?php echo $titulo; ?></h4>
                    </div>
                    <div class="card-body p-4">
                        <?php
                        try {
                            // Crear una instancia de la clase Conexion
                            $conexion = new Conexion();
                            
                            // Obtener la conexión
                            $conn = $conexion->getConexion();
                            
                            // Comprobar si la conexión fue exitosa
                            if ($conn) {
                                echo '<div class="alert alert-success" role="alert">
                                    <h4 class="alert-heading"><i class="fas fa-check-circle me-2"></i>Conexión exitosa</h4>
                                    <p>La conexión a la base de datos se ha establecido correctamente.</p>
                                </div>';
                            } else {
                                echo '<div class="alert alert-danger" role="alert">
                                    <h4 class="alert-heading"><i class="fas fa-times-circle me-2"></i>Error de conexión</h4>
                                    <p>No se pudo establecer la conexión a la base de datos.</p>
                                </div>';
                            }
                            
                            // Cerrar la conexión
                            $conexion->closeConexion();
                        } catch(Exception $e) {
                            echo '<div class="alert alert-danger" role="alert">
                                <h4 class="alert-heading"><i class="fas fa-times-circle me-2"></i>Error de conexión</h4>
                                <p>' . $e->getMessage() . '</p>
                            </div>';
                        }
                        ?>
                        
                        <div class="text-center mt-4">
                            <a href="index.php" class="btn btn-primary">
                                <i class="fas fa-home me-2"></i>Volver al inicio
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>