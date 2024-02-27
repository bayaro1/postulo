<?php
namespace App\Controller;

use App\Email\PostuloEmail;
use App\File\MotivationLetter\MotivationLetterCreator;
use App\Form\DataModel\PostuloModel;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TestController extends AbstractController
{
    #[Route('/tests/motivation')]
    public function motivationLetter(): Response
    {
        $postuloModel = new PostuloModel;

        $postuloModel->setEnterpriseCity('13000 Marseille')
                    ->setEnterpriseName('Synergie Dev')
                    ;

        return $this->render('pdf/motivation_letter.html.twig', [
            'enterpriseName' => $postuloModel->getEnterpriseName(),
            'enterpriseCity' => $postuloModel->getEnterpriseCity(),
            'enterpriseParaph' => $postuloModel->getMotivationLetterEnterpriseParaph(),
            'localisation' => $postuloModel->getLocalisation(),
            'search' => $postuloModel->getSearch()
        ]);
    }

    #[Route('/tests/pdf')]
    public function pdf(MotivationLetterCreator $motivationLetterCreator): Response
    {
        $postuloModel = new PostuloModel;

        $postuloModel->setEnterpriseCity('13000 Marseille')
                    ->setEnterpriseName('Synergie Dev')
                    ;

        $motivationLetterCreator->create($postuloModel);

        return $this->json('ok');
    }

    #[Route('/tests/emailTemplate')]
    public function emailTemplate(): Response
    {
        $postuloModel = new PostuloModel;

        return $this->render('email/postulo_email.html.twig', [
            'enterpriseParaph' => $postuloModel->getEmailContentEnterpriseParaph(),
            'localisation' => $postuloModel->getLocalisation(),
            'search' => $postuloModel->getSearch()
        ]);
    }

    #[Route('/tests/email')]
    public function email(PostuloEmail $postuloEmail): Response
    {
        $postuloModel = new PostuloModel;

        $postuloModel->setEnterpriseCity('13000 Marseille')
                    ->setEnterpriseName('Synergie Dev')
                    ->setEnterpriseEmail('contact@synergie-dev.com')
                    ;

        $postuloEmail->send($postuloModel);

        return $this->json('ok');
    }
}