<?php
namespace App\File;

use Symfony\Component\HttpKernel\KernelInterface;

class FileStorage
{
    /**
     * Cette fonction crée le directory s'il n'existe pas encore
     *
     * @param string $directoryAbsolutePath
     * @param string $filename
     * @param mixed $content
     * @return boolean true if success, false if failure
     */
    public function storeFile(string $directoryAbsolutePath, string $filename, mixed $content): bool
    {
        //si le dossier n'existe pas encore, on le crée
        if(!is_dir($directoryAbsolutePath))
        {
            mkdir($directoryAbsolutePath, 0777, true); // true -> récursivement si nécessaire
        }

        //on crée le fichier en y insérant le contenu
        $bytes = file_put_contents(
            $directoryAbsolutePath . DIRECTORY_SEPARATOR . $filename, 
            $content
        );

        return $bytes !== false;
    }

    public function getPathOrNull(string $absolutePath): ?string
    {
        if(file_exists($absolutePath))
        {
            return $absolutePath;
        }
        return null;
    }
}