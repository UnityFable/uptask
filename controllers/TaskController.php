<?php

namespace Controllers;

use Model\Project;
use Model\Task;

class TaskController
{
  public static function getAll()
  {
    $projectUrl = $_GET['url'];
    if (!$projectUrl) header('Location: /dashboard');

    if (!isset($_SESSION)) session_start();
    $project = Project::where('url', $projectUrl);
    if (!$project || $project->user_id !== $_SESSION['id']) header('Location: /404');

    $tasks = Task::where('project_id', $project->id, true);
    echo json_encode(['tasks' => $tasks]);
  }

  public static function create()
  {
    if (!isset($_SESSION)) session_start();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $project = Project::where('url', $_POST['projectUrl']);

      if (!$project || $project->user_id !== $_SESSION['id']) {
        $response = [
          'type' => 'error',
          'message' => 'No se pudo agregar la tarea'
        ];

        echo json_encode($response);
        return;
      }

      $taskObj = [
        'name' => $_POST['name'],
        'project_id' => $project->id
      ];
      $task = new Task($taskObj);
      $result = $task->save();
      if ($result && $result['result']) {
        $response = [
          'type' => 'success',
          'id' => $result['id'],
          'message' => 'Tarea creada correctamente',
          'projectId' => $project->id
        ];
      } else {
        $response = [
          'type' => 'error',
          'message' => 'No se pudo agregar la tarea'
        ];
      }
      echo json_encode($response);
    }
  }

  public static function update()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    }
  }

  public static function delete()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    }
  }
}
