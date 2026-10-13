<?php include_once __DIR__ . '/header-dashboard.php'; ?>
<div class="container-sm">
  <?php include_once __DIR__ . '/../templates/alerts.php'; ?>
  <a href="/change-password" class="link">Cambiar Contraseña</a>
  
  <form method="POST" class="form" action="/profile">
    <div class="field">
      <label for="name">Nombre</label>
      <input type="text" name="name" id="name" placeholder="Nombre" value="<?php echo $user->name ?? ''; ?>">
    </div>
    <div class="field">
      <label for="email">Correo Electrónico</label>
      <input type="email" name="email" id="email" placeholder="Correo Electrónico" value="<?php echo $user->email ?? ''; ?>">
    </div>

    <input type="submit" value="Guardar">
  </form>
</div>
<?php include_once __DIR__ . '/footer-dashboard.php'; ?>