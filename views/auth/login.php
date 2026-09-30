<div class="container login">
  <?php include_once __DIR__ . '/../templates/site-brand.php'; ?>

  <div class="container-sm">
    <p class="page-description">Iniciar Sesión</p>
    <?php include_once __DIR__ . '/../templates/alerts.php'; ?>
    <form action="/" method="POST" class="form">
      <div class="field">
        <label for="email">Correo Electrónico</label>
        <input type="email" name="email" id="email" placeholder="Correo Electrónico">
      </div>

      <div class="field">
        <label for="password">Contraseña</label>
        <input type="password" name="password" id="password" placeholder="Contraseña">
      </div>

      <input type="submit" class="button" value="Iniciar Sesión">
    </form>
    <div class="actions">
      <a href="/register">¿Aún no tienes una cuenta? Registate ahora</a>
      <a href="/reset">¿Olvidaste tu contraseña?</a>
    </div>
  </div>
</div>