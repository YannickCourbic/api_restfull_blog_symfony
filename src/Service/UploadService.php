<?php 
namespace App\Service;

use App\Entity\MediaObject;
use DateTimeImmutable;
use DateTimeZone;
use Doctrine\ORM\EntityManagerInterface;
use Error;
use Symfony\Component\Filesystem\Filesystem;

use Symfony\Component\HttpFoundation\Request;

class UploadService{
    public function __construct(private Filesystem $filesystem, private EntityManagerInterface $entityManager, private MediaObject $mediaObject)
    {
        $this->filesystem = $filesystem;
        $this->entityManager = $entityManager;
        $this->mediaObject = $mediaObject;
    }

    public  function uploadChunk(Request $request , string $dest):Error|MediaObject{
        $name = $request->request->get('name');
        $type = $request->request->get('type');
        $extension = $request->request->get('extension');
        $size = (int)$request->request->get('size');
        $chunkSize = (int) $request->request->get('chunkSize');
        $index = (int)$request->request->get('index');
        $chunk = $request->files->get('chunk');
        if(!$name || !$type || !$extension || !$size || !$chunkSize || !$index){
            throw new Error("les données formData n'ont pas été reçus correctement");
        }       
        $totalChunk = ceil($size / $chunkSize); 
        //je vais d'abord tout stocker dans un tableau de chunk
        
        //*vérification du fichier files
        if(!$request->files->count()){
            throw new Error("Aucun fichier binaire reçus.");
        }

        $chunkData = $chunk->getContent();
        //dump($chunk);
        $videoPath = $dest . "/" . $name . "." . $extension; 
        $nameTrim = str_replace(' ' , '', $name);

        
        
        //*je vérifie si le dossier exist ou non
        if(!$this->filesystem->exists($dest)){
            $this->filesystem->mkdir($dest);
        }
        //*je vérifie si le fichier existe
        if(!$this->filesystem->exists($videoPath)){
            $this->filesystem->touch($videoPath);
        }
        //*j'ouvre le fichier en mode lecture et écriture
        //dump($index);
        $handle = fopen($videoPath , 'r+');
        //fseek($handle, ())
        //* déplace le pointeur de fichier pour écrire à la position appropriée
        fseek($handle , (($index - 1) * $chunkSize));
        //*écriture du fichier à la position avec le chunk
        fwrite($handle , $chunkData);
        //*fin de l'écriture 
        fclose($handle);
        
        $this->mediaObject->setContentUrl($request->isSecure() ? 'https' : 'http' . "://"  . $request->getHttpHost() . "/uploads/medias/" . $name . "." . $extension);
        $this->mediaObject->setFilename($name . "." . $extension);
        $this->mediaObject->setMimetype($this->getType($type));
        $this->mediaObject->setSize($size);
        $this->mediaObject->setType($type);
        $this->mediaObject->setCreatedAt(new DateTimeImmutable('now' , new DateTimeZone('Europe/Paris')));
        //dump($this->mediaObject);
        if($index == $totalChunk){
            $this->entityManager->persist($this->mediaObject);
            $this->entityManager->flush();
        }
        //dump($totalChunk == $index);
        return $this->mediaObject;
    }

    private function getType(string $mimeType):string{
        if(preg_match('/^image\/(png|webp|jpg|jpeg|gif|avif|svg)$/', $mimeType)){
            return "image";
        }
        if(preg_match('/^video\/(mp4|x-matroska)$/' , $mimeType)){
            return "video";
        }


        return "";
    }


    public function uploadModifyChunk(Request $request , string $dest , MediaObject $modify):Error|MediaObject{
        $name = $request->request->get('name');
        $type = $request->request->get('type');
        $extension = $request->request->get('extension');
        $size = (int)$request->request->get('size');
        $chunkSize = (int) $request->request->get('chunkSize');
        $index = (int)$request->request->get('index');
        $chunk = $request->files->get('chunk');
        if(!$name || !$type || !$extension || !$size || !$chunkSize || !$index){
            throw new Error("les données formData n'ont pas été reçus correctement");
        }       
        $totalChunk = ceil($size / $chunkSize); 

        //*vérification du fichier files
        if(!$request->files->count()){
                throw new Error("Aucun fichier binaire reçus.");
        }
    
        $chunkData = $chunk->getContent();
        if($modify){
            $videoPath = $dest . "/" . $name . "." . $extension; 
            //*je vérifie si le dossier exist ou non
            if(!$this->filesystem->exists($dest)){
                $this->filesystem->mkdir($dest);
            }
            //*je vérifie si le fichier existe
            if(!$this->filesystem->exists($videoPath)){
                $this->filesystem->touch($videoPath);
            }
            //*j'ouvre le fichier en mode lecture et écriture
            //dump($index);
            $handle = fopen($videoPath , 'r+');
            //fseek($handle, ())
            //* déplace le pointeur de fichier pour écrire à la position appropriée
            fseek($handle , (($index - 1) * $chunkSize));
            //*écriture du fichier à la position avec le chunk
            fwrite($handle , $chunkData);
            //*fin de l'écriture 
            fclose($handle);
            //* après avoir upload le fichier je supprime l'ancien
            //$this->removeFiles($dest , $modify->getFilename());
            $oldFilename = $modify->getFilename();

            //dump($index);
            if($index == $totalChunk){
                $modify->setContentUrl($request->isSecure() ? 'https' : 'http' . "://"  . $request->getHttpHost() . "/uploads/medias/" . $name . "." . $extension);
                $modify->setFilename($name . "." . $extension);
                $modify->setMimetype($this->getType($type));
                $modify->setSize($size);
                $modify->setType($type);
                $modify->setUpdatedAt(new DateTimeImmutable('now' , new DateTimeZone('Europe/Paris')));
                $this->entityManager->persist($modify);
                $this->entityManager->flush();
                $this->removeFiles($dest , $oldFilename);
            }
            return $modify;
        }
    }

    
    private function removeFiles(string $dest , string $filename):void{
        unlink($dest . "/" . $filename);
    }

    
}




        
