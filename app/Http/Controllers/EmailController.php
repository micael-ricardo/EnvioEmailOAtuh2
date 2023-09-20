<?php

namespace App\Http\Controllers;
use Swift_SmtpTransport;
use Swift_Mailer;
use Swift_Message;

class EmailController extends Controller
{

    public function enviarEmail()
    {
        $transport = (new Swift_SmtpTransport('smtp.office365.com', 587, 'tls'))
            ->setUsername('micael.praxis@outlook.com')
            ->setPassword('12345678@@');

        $mailer = new Swift_Mailer($transport);

        $message = (new Swift_Message('Teste de e-mail'))
            ->setFrom(['micael.praxis@outlook.com' => 'Praxis'])
            ->setTo(['micael.ricardo@outlook.com'])
            ->setBody('Este é um teste de e-mail enviado utilizando o Laravel e o SwiftMailer 155.');

        $result = $mailer->send($message);

        if ($result) {
            return "E-mail enviado com sucesso!";
        } else {
            return "Falha ao enviar o e-mail.";
        }
    }

}
