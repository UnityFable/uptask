<?php

namespace Model;

class User extends ActiveRecord
{
  protected static $table = 'users';
  protected static $dbColumns = ['id', 'name', 'email', 'password', 'token', 'confirmed'];

  public ?int $id;
  public string $name;
  public string $email;
  public string $password;
  public ?string $password2;
  public ?string $token;
  public int $confirmed;

  public function __construct($args = [])
  {
    $this->id = $args['id'] ?? null;
    $this->name = $args['name'] ?? '';
    $this->email = $args['email'] ?? '';
    $this->password = $args['password'] ?? '';
    $this->password2 = $args['password2'] ?? null;
    $this->token = $args['token'] ?? null;
    $this->confirmed = $args['confirmed'] ?? 0;
  }

  public function validateNewUser()
  {
    if (!$this->name) {
      self::$alerts['error'][] = 'El nombre del Usuario es obligatorio';
    }
    if (!$this->email) {
      self::$alerts['error'][] = 'El email es obligatorio';
    }
    if (!$this->password) {
      self::$alerts['error'][] = 'La contraseña es obligatoria';
    } else if (strlen($this->password) < 6) {
      self::$alerts['error'][] = 'La contraseña debe tener minimo 6 caracteres';
    } else if ($this->password !== $this->password2) {
      self::$alerts['error'][] = 'Las contraseñas no coinciden';
    }

    return self::$alerts;
  }

  public function validateEmail()
  {
    if (!$this->email) {
      self::$alerts['error'][] = 'El correo electrónico es obligatorio';
    } else if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
      self::$alerts['error'][] = 'Debe ingresar un correo electrónico válido';
    }

    return self::$alerts;
  }

  public function validatePassword()
  {
    if (!$this->password) {
      self::$alerts['error'][] = 'La contraseña es obligatoria';
    } else if (strlen($this->password) < 6) {
      self::$alerts['error'][] = 'La contraseña debe tener minimo 6 caracteres';
    } else if ($this->password !== $this->password2) {
      self::$alerts['error'][] = 'Las contraseñas no coinciden';
    }

    return self::$alerts;
  }

  public function validateLogin()
  {
    if (!$this->email) {
      self::$alerts['error'][] = 'El email es obligatorio';
    } else if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
      self::$alerts['error'][] = 'Debe ingresar un correo electrónico válido';
    }
    if (!$this->password) {
      self::$alerts['error'][] = 'La contraseña es obligatoria';
    }

    return self::$alerts;
  }

  public function hashPassword()
  {
    $this->password = password_hash($this->password, PASSWORD_BCRYPT);
  }

  public function generateToken()
  {
    $this->token = uniqid();
  }
}
