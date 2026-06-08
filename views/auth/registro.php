<!DOCTYPE html>

<html lang="es">



<head>

  <meta charset="UTF-8">

  <title>Registrar usuario</title>

  <link rel="stylesheet" href="assets/css/style.css">

</head>



<body>

  <main class="auth-page">

    <section class="auth-card auth-card-wide">

      <h1>Registrar usuario</h1>



      <!--

        Si AuthController detecta campos incorrectos,

        vuelve a esta vista y muestra los mensajes en esta caja.

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

        Este formulario crea un usuario del sistema.

        La contrasena se encripta en AuthController antes de guardar.

      -->

      <form action="index.php?accion=registrar" method="POST">

        <div class="form-group">

          <label>Nombre:</label>

          <input type="text" name="nombre" value="<?php echo h($datos["nombre"] ?? ""); ?>" required maxlength="80">

        </div>



        <div class="form-group">

          <label>Apellido paterno:</label>

          <input type="text" name="ape_pat" value="<?php echo h($datos["ape_pat"] ?? ""); ?>" required maxlength="80">

        </div>



        <div class="form-group">

          <label>Apellido materno:</label>

          <input type="text" name="ape_mat" value="<?php echo h($datos["ape_mat"] ?? ""); ?>" required maxlength="80">

        </div>



        <div class="form-group">

          <label>DNI:</label>

          <!-- El DNI se limita a 8 digitos tambien desde HTML. -->

          <input type="text" name="dni" value="<?php echo h($datos["dni"] ?? ""); ?>" required minlength="8" maxlength="8" pattern="[0-9]{8}">

        </div>



        <div class="form-group">

          <label>Usuario:</label>

          <!-- Usuario acepta letras, numeros y guion bajo. -->

          <input type="text" name="usuario" value="<?php echo h($datos["usuario"] ?? ""); ?>" required minlength="4" maxlength="50" pattern="[A-Za-z0-9_]{4,50}" autocomplete="username">

        </div>



        <div class="form-group">

          <label>Contrasena:</label>

          <input type="password" name="password" required minlength="8" autocomplete="new-password">

        </div>



        <div class="form-group">

          <label>Confirmar contrasena:</label>

          <input type="password" name="password_confirmacion" required minlength="8" autocomplete="new-password">

        </div>



        <button class="button full-button" type="submit">Crear usuario</button>



        <!-- Vuelve al login si el usuario ya tiene cuenta. -->

        <a class="auth-link" href="index.php?accion=login">Ya tengo una cuenta</a>

      </form>

    </section>

  </main>

</body>



</html>