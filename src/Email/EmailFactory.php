<?php
namespace App\Email;

use App\Config\SecurityConfig;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Environment;

abstract class EmailFactory
{
    private Mailer $mailer;

    public function __construct(
        protected Environment $twig, 
    )
    {

    }

    public function sendEmail(Email $email)
    {
        $this->configureMailer();

        $this->mailer->send($email);
    }

    private function configureMailer(): void
    {
        //DELETE_FOR_PROD // a suppr pour Prod
        $transport = Transport::fromDsn(SecurityConfig::SMTP_TEST);
        
        // $transport = Transport::fromDsn('smtp://'.SecurityConfig::EMAIL_USERNAME.':'.SecurityConfig::EMAIL_PASSWORD.'@'.SecurityConfig::EMAIL_SERVER);
        $this->mailer = new Mailer($transport);
    }
}