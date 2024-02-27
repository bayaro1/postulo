<?php
namespace App\Email\Security;

use App\Config\DefaultTextConfig;
use App\Email\EmailFactory;
use App\File\Pdf\PdfManager;
use App\Form\DataModel\PostuloModel;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Mime\Email;
use Twig\Environment;

class PostuloEmail extends EmailFactory
{
    public function send(PostuloModel $postuloModel, string $cvFullPath, string $motivationLetterFullPath)
    {
        $email = (new Email())
            ->from('arotcarena.ib@gmail.com')
            ->to($postuloModel->getEnterpriseEmail())
            ->subject(
                $postuloModel->getSearch() === PostuloModel::SEARCH_ALTERNANCE ? 'Candidature spontanée pour une alternance': 'Candidature spontanée'
            )
            ->text(DefaultTextConfig::EMAIL_CONTENT_TEXT)
            ->html($this->twig->render('email/postulo_email.html.twig', [
                'email_content_enterprise_paraph' => $postuloModel->getEmailContentEnterpriseParaph(),
                'search' => $postuloModel->getSearch(),
                'localisation' => $postuloModel->getLocalisation()
            ]));

        $email->attachFromPath($cvFullPath, 'CV Ibai Arotçarena', 'application/pdf')
                ->attachFromPath($motivationLetterFullPath, 'Lettre de motivation', 'application/pdf')
                ;

        $this->sendEmail($email);
    }
}