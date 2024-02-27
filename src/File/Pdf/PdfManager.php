<?php
namespace App\File\Pdf;

use App\File\FileStorage;
use Dompdf\CanvasFactory;
use Dompdf\Dompdf;
use Dompdf\FontMetrics;
use Dompdf\Options;
use Symfony\Component\HttpKernel\KernelInterface;

class PdfManager
{
    public function __construct(
        private KernelInterface $kernel,
        private FileStorage $fileStorage
    )
    {
        
    }

    /**
     * @param string $html
     * @param string $relativeDir (ex: 2024/03/sales_invoice/1)
     * @param string $name (ex: invoice_1_fr)
     * @param string $paperSize
     * @param string $orientation (portrait | landscape)
     * @return bool true if success, false if failure
     */
    public function createFromHtml(string $html, string $relativeDir, string $name, string $paperSize = 'A4', $orientation = 'portrait'): bool
    {
        // instantiate and use the dompdf class
        $options = new Options();
                ;
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper($paperSize, $orientation);
        // Render the HTML as PDF
        $dompdf->render();
        // get pdf string
        $pdfContent = $dompdf->output();

        return $this->fileStorage->storeFile(
            $this->getPdfDirectory() . DIRECTORY_SEPARATOR . $relativeDir,
            $name . '.pdf',
            $pdfContent
        );
    }

    /**
     * @param string $relativeDir (ex: 2024/03/sales_invoice/1)
     * @param string $name (ex: invoice_1_fr)
     */
    public function getPath(string $relativeDir, string $name): ?string
    {
        return $this->fileStorage->getPathOrNull(
            $this->getPdfDirectory() . DIRECTORY_SEPARATOR . $relativeDir . DIRECTORY_SEPARATOR . $name . '.pdf'
        );
    }

    private function getPdfDirectory(): string
    {
        return $this->kernel->getProjectDir() . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'pdf';
    }
}