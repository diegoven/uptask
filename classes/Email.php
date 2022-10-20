<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email
{
    protected $email;
    protected $nombre;
    protected $token;

    public function __construct($email, $nombre, $token)
    {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }

    public function enviarConfirmacion()
    {
        $phpmailer = new PHPMailer();
        $phpmailer->isSMTP();
        $phpmailer->Host = 'smtp.mailtrap.io';
        $phpmailer->SMTPAuth = true;
        $phpmailer->Port = 2525;
        $phpmailer->Username = '062a0a6bb8438c';
        $phpmailer->Password = 'b63eaf78cd07f1';

        $phpmailer->setFrom('cuentas@uptask.com');
        $phpmailer->addAddress('cuentas@uptask.com', 'uptask.com');
        $phpmailer->Subject = 'Confirma tu cuenta';

        $phpmailer->isHTML(TRUE);
        $phpmailer->CharSet = 'UTF-8';

        $body = "<html>";
        $body .= "<p>Hola <strong>" . $this->name . "</strong>. Has creado tu cuenta en UpTask, solo debes confirmarla en el siguiente enlace.</p>";
        $body .= "<p>Presiona aquí: <a href ='http://localhost:3000/confirm-user?token=" . $this->token . "'>Confirmar cuenta</a></p>";
        $body .= "<p>Si tu no creaste esta cuenta puedes ignorar este mensaje.</p>";
        $body .= "</html>";

        $phpmailer->Body = $body;
        $phpmailer->send();
    }

    public function enviarInstrucciones()
    {
        $phpmailer = new PHPMailer();
        $phpmailer->isSMTP();
        $phpmailer->Host = 'smtp.mailtrap.io';
        $phpmailer->SMTPAuth = true;
        $phpmailer->Port = 2525;
        $phpmailer->Username = '062a0a6bb8438c';
        $phpmailer->Password = 'b63eaf78cd07f1';

        $phpmailer->setFrom('cuentas@uptask.com');
        $phpmailer->addAddress('cuentas@uptask.com', 'uptask.com');
        $phpmailer->Subject = 'Reestablece tu contraseña';

        $phpmailer->isHTML(TRUE);
        $phpmailer->CharSet = 'UTF-8';

        $body = "<html>";
        $body .= "<p>Hola <strong>" . $this->name . "</strong>. Parece que has olvidado tu contraseña, sigue el siguiente enlace para que definas una contraseña nueva</p>";
        $body .= "<p>Presiona aquí: <a href ='http://localhost:3000/reset-password?token=" . $this->token . "'>Reestablecer contraseña</a></p>";
        $body .= "<p>Si tu no creaste esta cuenta puedes ignorar este mensaje.</p>";
        $body .= "</html>";

        $phpmailer->Body = $body;
        $phpmailer->send();
    }
}
