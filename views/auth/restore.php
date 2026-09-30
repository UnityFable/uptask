<div class="container restore">
  <?php include_once __DIR__ . '/../templates/site-brand.php'; ?>

  <div class="container-sm">
    <p class="page-description">Coloca tu nueva Contraseña</p>
    <?php
    include_once __DIR__ . '/../templates/alerts.php';
    if (isset($show) && $show):
    ?>
      <form method="POST" class="form">
        <div class="field">
          <label for="password">Contraseña</label>
          <input type="password" name="password" id="password" placeholder="Contraseña">
        </div>

        <div class="field">
          <label for="password2">Verifica tu Contraseña</label>
          <input type="password" name="password2" id="password2" placeholder="Verifica tu Contraseña">
        </div>
        <input type="submit" class="button" value="Guardar Cambios">
      </form>
    <?php endif; ?>
    <div class="actions">
      <a href="/">¿Ya tienes una cuenta? Inicia Sesión</a>
      <a href="/register">¿Aún no tienes una cuenta? Registate ahora</a>
    </div>
  </div>
</div>