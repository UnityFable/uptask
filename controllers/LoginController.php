<?php

namespace Controllers;

use Classes\Email;
use Model\User;
use MVC\Router;

class LoginController
{
  public static function login(Router $router)
  {
    if (isset($_SESSION)) $_SESSION = [];
    $alerts = [];
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $auth = new User($_POST);
      $alerts = $auth->validateLogin();

      if (empty($alerts)) {
        $user = User::where('email', $auth->email);
        if (!$user || !$user->confirmed) {
          User::setAlert('error', 'El usuario no se encuentra registrado o no ha sido confirmado');
        } else {
          if (password_verify($auth->password, $user->password)) {
            if (!isset($_SESSION)) session_start();
            $_SESSION['id'] = $user->id;
            $_SESSION['name'] = $user->name;
            $_SESSION['email'] = $user->email;
            $_SESSION['login'] = true;

            header('Location: /dashboard');
          } else {
            User::setAlert('error', 'Usuario o contraseña incorrectos');
          }
        }
      }
    }

    $alerts = User::getAlerts();

    $router->render('auth/login', [
      'title' => 'Iniciar Sesión',
      'alerts' => $alerts
    ]);
  }

  public static function logout() {
    if (!isset($_SESSION)) session_start();
    $_SESSION = [];
    header('Location: /');
  }

  public static function register(Router $router)
  {
    $user = new User();
    $alerts = [];
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $user->sync($_POST);
      $alerts = $user->validateNewUser();

      if (empty($alerts)) {
        $userExists = User::where('email', $user->email);
        if ($userExists) {
          User::setAlert('error', 'El usuario ya se encuentra registrado');
        } else {
          $user->hashPassword();
          unset($user->password2);
          $user->generateToken();
          $result = $user->save();
          if ($result) header('Location: /message');
        }
      }
    }
    $alerts = User::getAlerts();

    $router->render('auth/register', [
      'title' => 'Registrate en UpTask',
      'user' => $user,
      'alerts' => $alerts
    ]);
  }

  public static function reset(Router $router)
  {
    $alerts = [];
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $user = new User($_POST);
      $alerts = $user->validateEmail();

      if (empty($alerts)) {
        $user = User::where('email', $user->email);
        if ($user && $user->confirmed) {
          unset($user->password2);
          $user->generateToken();
          $user->save();

          User::setAlert('success', 'Hemos enviado las instrucciones a tu correo');
        } else {
          User::setAlert('error', 'El usuario no existe o no está confirmado');
        }
      }
    }
    $alerts = User::getAlerts();

    $router->render('auth/reset', [
      'title' => 'Recuperar contraseña',
      'alerts' => $alerts
    ]);
  }

  public static function restore(Router $router)
  {
    $token = s($_GET['token']);
    $show = true;
    if (!$token) header('Location: /');

    $user = User::where('token', $token);
    if (empty($user)) {
      User::setAlert('error', 'Token inválido');
      $show = false;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $user->sync($_POST);
      $alerts = $user->validatePassword();
      if (empty($alerts)) {
        $user->hashPassword();
        $user->token = null;
        unset($user->password2);
        $result = $user->save();
        if ($result) header('Location: /');
      }
    }

    $alerts = User::getAlerts();

    $router->render('auth/restore', [
      'title' => 'Reestablecer contraseña',
      'alerts' => $alerts,
      'show' => $show
    ]);
  }

  public static function message(Router $router)
  {
    $router->render('auth/message', [
      'title' => 'Cuenta Creada Correctamente'
    ]);
  }

  public static function confirm(Router $router)
  {
    $token = s($_GET['token']);
    if (!$token) header('Location: /');

    $user = User::where('token', $token);
    if (empty($user)) {
      User::setAlert('error', 'Token Invalido');
    } else {
      $user->confirmed = 1;
      $user->token = null;
      unset($user->password2);
      $user->save();
      User::setAlert('success', 'Cuenta confirmada correctamente, ya puedes iniciar sesión en UpTask');
    }

    $alerts = User::getAlerts();

    $router->render('auth/confirm', [
      'title' => 'Confirmar cuenta',
      'alerts' => $alerts
    ]);
  }
}
