<div class="container reset">
  <?php include_once __DIR__ . '/../templates/site-brand.php'; ?>

  <div class="container-sm">
    <p class="page-description">Recupera tu Contraseña</p>
    <?php include_once __DIR__ . '/../templates/alerts.php'; ?>
    <form action="/reset" method="POST" class="form">
      <div class="field">
        <label for="email">Correo Electrónico</label>
        <input type="email" name="email" id="email" placeholder="Correo Electrónico">
      </div>
      <input type="submit" class="button" value="Enviar">
    </form>
    <div class="actions">
      <a href="/">¿Ya tienes una cuenta? Inicia Sesión</a>
      <a href="/register">¿Aún no tienes una cuenta? Registate ahora</a>
    </div>
  </div>
</div>