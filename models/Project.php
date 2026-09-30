<?php

namespace Model;

class Project extends ActiveRecord {
  protected static $table = 'projects';
  protected static $dbColumns = ['id', 'name', 'url', 'user_id'];

  public ?int $id;
  public string $name;
  public string $url;
  public ?int $user_id;

  public function __construct($args = [])
  {
    $this->id = $args['id'] ?? null;
    $this->name = $args['name'] ?? '';
    $this->url = $args['url'] ?? '';
    $this->user_id = $args['user_id'] ?? null;
  }

  public function validateNewProject()
  {
    if (!$this->name) {
      self::$alerts['error'][] = 'El nombre del proyecto es obligatorio';
    }

    return self::$alerts;
  }
}