<?php

namespace App\Controller;

use App\Entity\MediaObject;
use App\Service\UploadService;
use Doctrine\ORM\EntityManagerInterface;
use Error;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;


#[Route('/api/media_objects')]
class MediaObjectController extends AbstractController
{   
    
    public function __construct(private UploadService $uploadService, private EntityManagerInterface $entityManager, private MediaObject $mediaObject)
    {
        $this->uploadService = $uploadService;
        $this->entityManager =$entityManager;
        $this->mediaObject = $mediaObject;
    }

    #[Route('/create', name: 'app_create_media_object', methods:['POST'])]
    public function create(Request $request): JsonResponse
    {   
        $index = (int)$request->request->get('index');
        $chunkSize = (int) $request->request->get('chunkSize');
        $size = (int)$request->request->get('size');
        //$extension = $request->request->get('extension');

        try{ 
            $image = $this->uploadService->uploadChunk($request , $this->getParameter('upload_directory'));
            //$session->invalidate();
        }
        catch(Error $err){
            return $this->json(['error' => $err->getMessage()]);
        }
        

        if($index == ceil($size / $chunkSize) ){
            return $this->json([
                'message' => 'Vous avez enregistrée un média avec succès.',
                'data' => $image
            ], Response::HTTP_CREATED);
        }
        return $this->json(['message' => 'chunk chargée avec succès'], Response::HTTP_OK);
    }


    #[Route('/update/{id}', name: 'app_update_media_object' , methods:['POST'])]
    public function modify(Request $request , MediaObject $mediaObject):JsonResponse{
        $index = (int)$request->request->get('index');
        $chunkSize = (int) $request->request->get('chunkSize');
        $size = (int)$request->request->get('size');
        try{
            $update = $this->uploadService->uploadModifyChunk($request , $this->getParameter('upload_directory'), $mediaObject);

        }catch(Error $err){
            return $this->json(['error' => $err->getMessage()]);
        }
        if($index == ceil($size / $chunkSize) ){
            return $this->json([
                'message' => 'Vous avez modifiée le média avec succès.',
                'data' => $update
            ], Response::HTTP_CREATED);
        }
        return $this->json(['message' => 'chunk chargée avec succès.'], Response::HTTP_ACCEPTED);
    }


    #[Route('/all' , name: "app_all_media_object" , methods: ['GET'])]
    public function all(Request $request):JsonResponse {

        try{
            $all = $this->entityManager->getRepository(MediaObject::class)->findAll();
        }catch(Exception $error){
            return $this->json(['error' => $error->getMessage()]);
        }

        return $this->json(["message" => "vous accès à tout les médias avec succès" , "data" => $all], Response::HTTP_OK);
    }

    #[Route('/show/{id}' , name: "app_show_media_object" , methods:['GET'])]
    public function show(Request $request , int $id):JsonResponse {
        //dump($mediaObject);
        try{
            $mediaObject = $this->entityManager->getRepository(MediaObject::class)->findOneBy(['id' => $id]);
            if($mediaObject === null) return $this->json(['error' => 'le média n\'a pas été trouver'], Response::HTTP_NOT_FOUND);
        }
        catch(Exception $e){
            return $this->json(['erreur' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return $this->json(['message' => "vous avez récupérer le média correspondant", "data" => $mediaObject], Response::HTTP_OK);
    }

    #[Route('/delete/{id}' , name: 'app_delete_media_object' , methods:['DELETE'])]
    public function delete(Request $request, int $id):JsonResponse{
        try{
            $mediaObject = $this->entityManager->getRepository(MediaObject::class)->findOneBy(['id' => $id]);
            if($mediaObject === null) return $this->json(['error' => 'le média n\'a pas été trouver'], Response::HTTP_NOT_FOUND);
            $oldFilename = $mediaObject->getFilename();
            unlink($this->getParameter('upload_directory') . "/" . $oldFilename);
            $this->entityManager->remove($mediaObject);
            $this->entityManager->flush();
        }catch(Exception $e){
            return $this->json(['erreur' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return $this->json(['message' => 'vous avez supprimer le média ' . $oldFilename . ' avec succès.'], Response::HTTP_OK);
    }
}
