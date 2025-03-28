<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            padding: 50px 0;
        }
        .header h1 {
            margin: 0;
            font-size: 2.5em;
        }
        .forms {
            display: flex;
            justify-content: space-around;
            margin-top: 50px;
        }
        .form-container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 45%;
        }
        .form-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .form-container form {
            display: flex;
            flex-direction: column;
        }
        .form-container form input {
            margin-bottom: 15px;
            padding: 10px;
            font-size: 1em;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .form-container form button {
            padding: 10px;
            font-size: 1em;
            color: #fff;
            background-color: #007BFF;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .form-container form button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Bienvenido a Nuestra Landing Page</h1>
            <p>Regístrate o inicia sesión para continuar</p>
        </div>
        <div class="forms">
            <!-- Formulario de Registro -->
            <div class="form-container">
                <h2>Registro</h2>
                <form action="register.php" method="POST">
                    <input type="text" name="name" placeholder="Nombre completo" required>
                    <input type="email" name="email" placeholder="Correo electrónico" required>
                    <input type="password" name="password" placeholder="Contraseña" required>
                    <button type="submit">Registrarse</button>
                </form>
            </div>
            <!-- Formulario de Inicio de Sesión -->
            <div class="form-container">
                <h2>Inicio de Sesión</h2>
                <form action="login.php" method="POST">
                    <input type="email" name="email" placeholder="Correo electrónico" required>
                    <input type="password" name="password" placeholder="Contraseña" required>
                    <button type="submit">Iniciar Sesión</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>