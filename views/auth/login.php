<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar sesion</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <main class="auth-page">
        <section class="auth-card">
            <h1>Iniciar sesion</h1>

            <!--
                $errores llega desde AuthController.
                Si el usuario o la contrasena son incorrectos, se muestran aqui.
            -->
            <?php if (!empty($errores)): ?>
                <div class="error-box">
                    <ul>
                        <?php foreach ($errores as $error): ?>
                            <li><?php echo h($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <!--
                Este formulario envia usuario y contrasena a:
                index.php?accion=autenticar
                Esa accion ejecuta AuthController::autenticar().
            -->
            <form action="index.php?accion=autenticar" method="POST">
                <div class="form-group">
                    <label>Usuario:</label>
                    <input
                        type="text"
                        name="usuario"
                        value="<?php echo h($usuario ?? ""); ?>"
                        required
                        autocomplete="username">
                </div>

                <div class="form-group">
                    <label>Contrasena:</label>
                    <input
                        type="password"
                        name="password"
                        required
                        autocomplete="current-password">
                </div>

                <button class="button full-button" type="submit">Ingresar</button>

                <!-- Enlace al formulario publico para crear una cuenta nueva. -->
                <a class="auth-link" href="index.php?accion=registro">Registrar usuario nuevo</a>
            </form>
        </section>
    </main>
</body>
</html>
