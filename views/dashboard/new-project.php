<?php include_once __DIR__ . '/header-dashboard.php'; ?>

<div class="container-sm">
  <?php include_once __DIR__ . '/../templates/alerts.php'; ?>
  
  <form method="POST" class="form" action="/new-project">
    <?php include_once __DIR__ . '/project-form.php'; ?>
    <input type="submit" value="Guardar">
  </form>
</div>

<?php include_once __DIR__ . '/footer-dashboard.php'; ?>