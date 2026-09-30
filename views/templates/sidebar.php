<div class="sidebar">
  <h2>UpTask</h2>
  <nav class="sidebar-nav">
    <a class="<?php echo (isset ($title) && $title === 'Proyectos') ? 'selected' : ''; ?>" href="/dashboard">Proyectos</a>
    <a class="<?php echo (isset ($title) && $title === 'Nuevo Proyecto') ? 'selected' : ''; ?>" href="/new-project">Nuevo Proyecto</a>
    <a class="<?php echo (isset ($title) && $title === 'Perfil') ? 'selected' : ''; ?>" href="/profile">Perfil</a>
  </nav>
</div>