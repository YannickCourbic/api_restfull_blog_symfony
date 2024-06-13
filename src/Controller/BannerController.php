<?php

namespace App\Controller;

use App\Dto\BannerDto;
use App\Entity\Banner;
use App\Entity\StyleSheet;
use App\Entity\MediaObject;
use App\Dto\BannerUpdateDto;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/api/banners')]
class BannerController extends AbstractController
{
    public function __construct(private Banner $banner, private EntityManagerInterface $entityManager, private SerializerInterface $serializer)
    {
        $this->banner = $banner;
        $this->entityManager = $entityManager;

    }
    
    #[Route('/create', name: 'app_create_banner', methods:['POST'])]
    public function create(#[MapRequestPayload(        
        acceptFormat: 'json',
        validationFailedStatusCode: Response::HTTP_BAD_REQUEST)] BannerDto $bannerDto): JsonResponse
    {   
        
        $style = $this->entityManager->getRepository(StyleSheet::class)->findOneBy(['id' => $bannerDto->style]);
        if(!$style) return $this->json(["error" => "Le style n'a pas été trouvée"] , Response::HTTP_NOT_FOUND);
        $media = $this->entityManager->getRepository(MediaObject::class)->findOneBy(['id' => $bannerDto->media]);
        if(!$media) return $this->json(["error" => "Le média n'a pas été trouvée"], Response::HTTP_NOT_FOUND);

        $exist = $this->entityManager->getRepository(Banner::class)->findOneBy(['title' => $bannerDto->title]);
        if($exist) return $this->json(['error' => 'Le titre existe déjà , veuillez en choisir un autre.'], Response::HTTP_BAD_REQUEST);

        $styleExist = $this->entityManager->getRepository(Banner::class)->findOneBy(['style' => $bannerDto->style]);
        //dd($styleExist);
        if($styleExist) return $this->json(['error' => 'le style sélectionnée est déjà prise par un autre composant.'], Response::HTTP_BAD_REQUEST);

        $banner = new Banner();
        $banner
        ->setTitle($bannerDto->title)
        ->setStyle($style)
        ->setMedia($media)
        ;

        $this->entityManager->persist($banner);
        $this->entityManager->flush();

        return $this->json([
            'message' => 'vous avez enregistrée la bannière avec succès.',
            "data" => json_decode($this->serializer->serialize($banner , "json" ,[ 'groups' =>  ['banner_read' , 'media_read' , 'style_read']]))
        ], Response::HTTP_CREATED);
    }


    #[Route('/update/{id}' , name: "app_update_banner", methods:['PUT'])]
    public function update(#[MapRequestPayload(        
        acceptFormat: 'json',
        validationFailedStatusCode: Response::HTTP_BAD_REQUEST)] BannerUpdateDto $bannerUpdateDto , int $id):JsonResponse{

        $banner = $this->entityManager->getRepository(Banner::class)->findOneBy(["id" => $id]);
        $media = $this->entityManager->getRepository(MediaObject::class)->findOneBy(['id' => $bannerUpdateDto->media]);
        //dd($banner);
        if(!$banner) return $this->json(["message" => "la bannière à modifiée est introuvable"], Response::HTTP_NOT_FOUND);
        if(!$media) return $this->json(["message" => "le média est introuvable"], Response::HTTP_NOT_FOUND);
        if($banner->getTitle() !== $bannerUpdateDto->title){
            $banner->setTitle($bannerUpdateDto->title);
        }
        
        if($banner->getMedia()->getId() !== $bannerUpdateDto->media){
            $banner->setMedia($media);
        }

        $this->entityManager->flush();

        return $this->json(["message" => "vous avez modifiée avec succès la bannière" , "data" => $this->serializeBanner($banner)], Response::HTTP_OK);
    }

    #[Route("/all" , name: "app_all_banner" , methods: ['GET'])]
    public function all():JsonResponse{

        $banners = $this->entityManager->getRepository(Banner::class)->findAll();
        return $this->json(["message" => "vous avez récupérer toutes les bannières avec succès." , "data" => $this->serializeBanner($banners)], Response::HTTP_OK);
    }

    #[Route("/show/{id}" , name: "app_show_banner" , methods:['GET'])]
    public function show(int $id):JsonResponse{
        $banner = $this->entityManager->getRepository(Banner::class)->findOneBy(['id' => $id]);
        if(!$banner) return $this->json(["error" => "Le banner n'a pas été trouver"]);
        return $this->json(['message' => 'vous avez récupérer la bannière avec succès.', 'data' => $this->serializeBanner($banner)], Response::HTTP_OK);
    }

    #[Route("/delete/{id}" , name: "app_delete_banner" , methods: ['DELETE'])]
    public function delete(int $id){
        $banner = $this->entityManager->getRepository(Banner::class)->findOneBy(['id' => $id]);
        if(!$banner) return $this->json(["error" => "Le banner n'a pas été trouver"]);
        $this->entityManager->remove($banner);
        $this->entityManager->flush();
        return $this->json(['message' => 'vous avez supprimer la bannière avec succès.'], Response::HTTP_OK);
    }


    private function serializeBanner(mixed $data):mixed{
        return json_decode($this->serializer->serialize($data , "json" ,[ 'groups' =>  ['banner_read' , 'media_read' , 'style_read']]));
    }
}
