<?php

namespace Controllers;

use Model\Project;
use MVC\Router;

class DashboardController
{
  public static function index(Router $router)
  {
    isAuth();

    $userId = $_SESSION['id'];
    $projects = Project::where('user_id', $userId, true);

    $router->render('dashboard/index', [
      'title' => 'Proyectos',
      'name' => $_SESSION['name'],
      'projects' => $projects
    ]);
  }

  public static function project(Router $router) {
    isAuth();

    $url = $_GET['url'];
    if (!$url) header('Location: /dashboard');

    $project = Project::where('url', $url);

    $userId = $_SESSION['id'];
    if ($project->user_id !== $userId) header('Location: /dashboard');

    $router->render('dashboard/project', [
      'title' => $project->name,
      'name' => $_SESSION['name']
    ]);
  }

  public static function newProject(Router $router)
  {
    isAuth();
    $alerts = [];
    $project = new Project();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $project = new Project($_POST);
      $alerts = $project->validateNewProject();

      if (empty($alerts)) {
        $project->url = md5(uniqid());
        $userId = $_SESSION['id'];
        $project->user_id = $userId;

        $result = $project->save();
        if ($result) header('Location: /project?url=' . $project->url);
      }
    }

    $router->render('dashboard/new-project', [
      'title' => 'Nuevo Proyecto',
      'name' => $_SESSION['name'],
      'alerts' => $alerts,
      'project' => $project
    ]);
  }

  public static function profile(Router $router)
  {
    isAuth();
    $router->render('dashboard/profile', [
      'title' => 'Perfil',
      'name' => $_SESSION['name']
    ]);
  }
}
