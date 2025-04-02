<?php
// includes/header.php
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SALLEPRESENCIA - Sistema de Control de Presencia</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome para iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Estilos personalizados -->
    <style>
        .bg-primary-dark {
            background-color: #003399;
        }
        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        main {
            flex-grow: 1;
        }
    </style>
</head>
<body>
    <header class="bg-primary-dark text-white py-3">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h1 class="display-5">SALLEPRESENCIA</h1>
                    <p class="lead">Sistema de Control de Presencia</p>
                </div>
            </div>
            
            <?php if(isset($_SESSION['usuario_id'])): ?>
            <nav class="navbar navbar-expand-lg navbar-dark bg-primary-dark mt-2">
                <div class="container-fluid">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                        <ul class="navbar-nav">
                            <?php if($_SESSION['usuario_rol'] === 'admin'): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="gestionfichadas.php">
                                    <i class="fas fa-tasks me-1"></i> Gestión de Fichadas
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="usuarios.php">
                                    <i class="fas fa-users me-1"></i> Usuarios
                                </a>
                            </li>
                            <?php endif; ?>
                            <li class="nav-item">
                                <a class="nav-link" href="fichar.php">
                                    <i class="fas fa-clock me-1"></i> Fichar
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="perfil.php">
                                    <i class="fas fa-user me-1"></i> Mi Perfil
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="logout.php">
                                    <i class="fas fa-sign-out-alt me-1"></i> Cerrar Sesión
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <?php endif; ?>
        </div>
    </header>
    
    <main class="py-4">
        <div class="container">