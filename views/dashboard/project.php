<?php include_once __DIR__ . '/header-dashboard.php'; ?>

<div class="container-sm">
  <div class="container-new-task">
    <button type="button" class="add-task" id="add-task">
      &#43; Nueva Tarea
    </button>
  </div>

  <div id="filters" class="filters">
    <div class="filters-inputs">
      <h2>Filtros:</h2>
      <div class="field">
        <label for="all">Todas</label>
        <input type="radio" id="all" name="filter" value="" checked>
      </div>
      <div class="field">
        <label for="completed">Finalizadas</label>
        <input type="radio" id="completed" name="filter" value="1">
      </div>
      <div class="field">
        <label for="pending">Pendientes</label>
        <input type="radio" id="pending" name="filter" value="0">
      </div>
    </div>
  </div>

  <ul id="task-list" class="task-list"></ul>
</div>

<?php
include_once __DIR__ . '/footer-dashboard.php';
$script = '
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="dist/js/tasks.js"></script>
';
?>