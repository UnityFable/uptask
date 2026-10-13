<aside class="sidebar">
  <div class="sidebar-container">
    <h2>UpTask</h2>
    <div class="close-menu">
      <img src="dist/img/close.svg" alt="cerrar menu" id="close-menu">
    </div>
  </div>
  <nav class="sidebar-nav">
    <a class="<?php echo (isset ($title) && $title === 'Proyectos') ? 'selected' : ''; ?>" href="/dashboard">Proyectos</a>
    <a class="<?php echo (isset ($title) && $title === 'Nuevo Proyecto') ? 'selected' : ''; ?>" href="/new-project">Nuevo Proyecto</a>
    <a class="<?php echo (isset ($title) && $title === 'Perfil') ? 'selected' : ''; ?>" href="/profile">Perfil</a>
  </nav>

  <div class="close-session-mobile">
    <a href="/logout" class="close-session">Cerrar Sesión</a>
  </div>
</aside>