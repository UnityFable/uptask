<?php include_once __DIR__ . '/header-dashboard.php'; ?>
<div class="container-sm">
  <?php include_once __DIR__ . '/../templates/alerts.php'; ?>
  <a href="/profile" class="link">Volver al Perfil</a>
  
  <form method="POST" class="form" action="/change-password">
    <div class="field">
      <label for="oldPassword">Contraseña Actual</label>
      <input type="password" name="oldPassword" id="oldPassword" placeholder="Contraseña Actual" value="">
    </div>
    <div class="field">
      <label for="newPassword">Nueva Contraseña</label>
      <input type="password" name="newPassword" id="newPassword" placeholder="Nueva Contraseña" value="">
    </div>
    <div class="field">
      <label for="newPassword2">Repetir contraseña</label>
      <input type="password" name="newPassword2" id="newPassword2" placeholder="Repetir Contraseña" value="">
    </div>

    <input type="submit" value="Guardar">
  </form>
</div>
<?php include_once __DIR__ . '/footer-dashboard.php'; ?>