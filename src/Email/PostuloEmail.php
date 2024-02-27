<?php
namespace App\Email;

use App\Config\DefaultTextConfig;
use App\Email\EmailFactory;
use App\Form\DataModel\PostuloModel;
use Symfony\Component\Mime\Email;

class PostuloEmail extends EmailFactory
{
    public function send(PostuloModel $postuloModel, string $cvFullPath = null, string $motivationLetterFullPath = null)
    {
        $email = (new Email())
            ->from('arotcarena.ib@gmail.com')
            ->to($postuloModel->getEnterpriseEmail())
            ->subject(
                $postuloModel->getSearch() === PostuloModel::SEARCH_ALTERNANCE ? 'Candidature spontanée pour une alternance': 'Candidature spontanée'
            )
            ->text(DefaultTextConfig::EMAIL_CONTENT_TEXT)
            ->html($this->twig->render('email/postulo_email.html.twig', [
                'enterpriseParaph' => $postuloModel->getEmailContentEnterpriseParaph(),
                'search' => $postuloModel->getSearch(),
                'localisation' => $postuloModel->getLocalisation()
            ]));

        if($cvFullPath)
        {
            $email->attachFromPath($cvFullPath, 'CV Ibai Arotçarena', 'application/pdf');
        }
        if($motivationLetterFullPath)
        {
            $email->attachFromPath($motivationLetterFullPath, 'Lettre de motivation', 'application/pdf');
        }

        $this->sendEmail($email);
    }
}