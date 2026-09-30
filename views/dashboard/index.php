<?php include_once __DIR__ . '/header-dashboard.php'; ?>

<?php if (count($projects) === 0): ?>
  <p class="no-projects">No Hay Proyectos Aún <a href="/new-project">Crea uno</a></p>
<?php else: ?>
  <ul class="projects-list">
    <?php foreach ($projects as $project): ?>
      <li class="project">
        <a href="/project?url=<?php echo $project->url; ?>">
          <?php echo $project->name; ?>
        </a>
      </li>
    <?php endforeach; ?>
  </ul>
<?php endif; ?>

<?php include_once __DIR__ . '/footer-dashboard.php'; ?>