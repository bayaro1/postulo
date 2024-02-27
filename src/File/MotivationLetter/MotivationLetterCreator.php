<?php
namespace App\File\MotivationLetter;

use App\File\Pdf\PdfManager;
use App\Form\DataModel\PostuloModel;
use Symfony\Component\String\Slugger\SluggerInterface;
use Twig\Environment;

class MotivationLetterCreator
{
    public const STORAGE_RELATIVE_DIR = 'motivation_letter';


    public function __construct(
        private PdfManager $pdfManager,
        private Environment $environment,
        private SluggerInterface $slugger
    )
    {
        
    }

    /**
     * @return ?string $motivationLetterFullPath
     */
    public function create(PostuloModel $postuloModel): ?string
    {
        $html = $this->environment->render('pdf/motivation_letter.html.twig', [
            'enterpriseName' => $postuloModel->getEnterpriseName(),
            'enterpriseCity' => $postuloModel->getEnterpriseCity(),
            'enterpriseParaph' => $postuloModel->getMotivationLetterEnterpriseParaph(),
            'localisation' => $postuloModel->getLocalisation(),
            'search' => $postuloModel->getSearch()
        ]);

        $slug = strtolower($this->slugger->slug($postuloModel->getEnterpriseName(), '_', 'fr'));

        $this->pdfManager->createFromHtml(
            $html, 
            self::STORAGE_RELATIVE_DIR, 
            $slug
        );

        return $this->pdfManager->getPath(self::STORAGE_RELATIVE_DIR, $slug);
    }
}