<div class="container register">
  <?php include_once __DIR__ . '/../templates/site-brand.php'; ?>

  <div class="container-sm">
    <p class="page-description">Crea tu cuenta en UpTask</p>
    <?php include_once __DIR__ . '/../templates/alerts.php'; ?>
    <form action="/register" method="POST" class="form">
      <div class="field">
        <label for="name">Nombre</label>
        <input type="text" name="name" id="name" placeholder="Nombre" value="<?php echo $user->name; ?>">
      </div>

      <div class="field">
        <label for="email">Correo Electrónico</label>
        <input type="email" name="email" id="email" placeholder="Correo Electrónico" value="<?php echo $user->email; ?>">
      </div>

      <div class="field">
        <label for="password">Contraseña</label>
        <input type="password" name="password" id="password" placeholder="Contraseña">
      </div>

      <div class="field">
        <label for="password2">Verifica tu Contraseña</label>
        <input type="password" name="password2" id="password2" placeholder="Verifica tu Contraseña">
      </div>

      <input type="submit" class="button" value="Crear Cuenta">
    </form>
    <div class="actions">
      <a href="/">¿Ya tienes una cuenta? Inicia Sesión</a>
      <a href="/reset">¿Olvidaste tu contraseña?</a>
    </div>
  </div>
</div>