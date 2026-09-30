<?php include_once __DIR__ . '/header-dashboard.php'; ?>

<div class="container-sm">
  <div class="container-new-task">
    <button type="button" class="add-task" id="add-task">
      &#43; Nueva Tarea
    </button>
  </div>

  <ul id="task-list" class="task-list"></ul>
</div>

<?php
include_once __DIR__ . '/footer-dashboard.php';
$script = '
  <script src="dist/js/tasks.js"></script>
';
?>