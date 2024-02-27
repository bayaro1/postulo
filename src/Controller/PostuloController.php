<?php
namespace App\Controller;

use App\Email\PostuloEmail;
use App\File\MotivationLetter\MotivationLetterCreator;
use App\File\Pdf\PdfManager;
use App\Form\DataModel\PostuloModel;
use App\Form\PostuloType;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PostuloController extends AbstractController
{
    public function __construct(
        private MotivationLetterCreator $motivationLetterCreator,
        private PdfManager $pdfManager,
        private PostuloEmail $postuloEmail
    )
    {
        
    }

    #[Route('/', name: 'postulo', methods: ['GET', 'POST'])]
    public function postulo(Request $request): Response
    {
        $postuloModel = new PostuloModel;
        $form = $this->createForm(PostuloType::class, $postuloModel);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            //on crée la lettre de motivation
            $motivationLetterFullPath = $this->motivationLetterCreator->create($postuloModel);
            if(!$motivationLetterFullPath)
            {
                throw new Exception('Erreur lors de la création de la lettre de motivation');
            }
            //on récupére le bon cv d'après les paramètres du form
            $cvFullPath = $this->pdfManager->getPath(
                'cv' . DIRECTORY_SEPARATOR . $postuloModel->getSearch() . DIRECTORY_SEPARATOR . $postuloModel->getLocalisation(),
                'cv'
            );
            if(!$cvFullPath)
            {
                throw new Exception('Impossible de récupérer le CV avec les critères demandés');
            }
            //on envoie l'email
            $this->postuloEmail->send($postuloModel, $cvFullPath, $motivationLetterFullPath);
            $this->addFlash('success', 'Email envoyé à ' . $postuloModel->getEnterpriseName() . ' - ' . $postuloModel->getEnterpriseEmail());
            return $this->redirectToRoute('postulo');
        }

        return $this->render('postulo/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}