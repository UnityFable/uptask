<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email
{
  protected string $email;
  protected string $name;
  protected string $token;

  public function __construct(string $email, string $name, string $token)
  {
    $this->email = $email;
    $this->name = $name;
    $this->token = $token;
  }

  public function sendConfirmation()
  {
    $mailer = new PHPMailer();
    $mailer->isSMTP();
    $mailer->Host = '';
    $mailer->SMTPAuth = true;
    $mailer->Port = 2525;
    $mailer->Username = '';
    $mailer->Password = '';

    $mailer->setFrom('cuentas@uptask.com');
    $mailer->addAddress('cuentas@uptask.com', 'uptask.com');
    $mailer->Subject = 'Confirma tu cuenta';

    $mailer->isHTML(true);
    $mailer->CharSet = 'UTF-8';

    $content = '<html>';
    $content .= "<p><strong>Hola " . $this->name . "</strong> Has creado tu cuenta en UpTask, Da click en el siguiente enlace para confirmarla</p>";
    $content .= "<p>Presiona aquí: <a href='http://localhost:3000/confirm?token=" . $this->token . "'>Confirmar Cuenta</a></p>";
    $content .= '<p>Si no reconoces este movimiento, puedes ignorar este mensaje</p>';
    $content .= '</html>';

    $mailer->Body = $content;
  }

  public function sendResetPassword() {
    $mailer = new PHPMailer();
    $mailer->isSMTP();
    $mailer->Host = '';
    $mailer->SMTPAuth = true;
    $mailer->Port = 2525;
    $mailer->Username = '';
    $mailer->Password = '';

    $mailer->setFrom('cuentas@uptask.com');
    $mailer->addAddress('cuentas@uptask.com', 'uptask.com');
    $mailer->Subject = 'Reestablece tu contraseña';

    $mailer->isHTML(true);
    $mailer->CharSet = 'UTF-8';

    $content = '<html>';
    $content .= "<p><strong>Hola " . $this->name . "</strong> Has solicitado restaurar tu contraseña, para hacerlo haz click en el siguiente enlace</p>";
    $content .= "<p>Presiona aquí: <a href='http://localhost:3000/restore?token=" . $this->token . "'>Confirmar Cuenta</a></p>";
    $content .= '<p>Si no reconoces este movimiento, puedes ignorar este mensaje</p>';
    $content .= '</html>';

    $mailer->Body = $content;
  }
}
