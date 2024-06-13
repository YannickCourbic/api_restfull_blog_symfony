<?php

namespace App\Controller;

use App\Dto\ParagraphDto;
use App\Entity\MediaObject;
use App\Entity\Paragraph;
use App\Entity\StyleSheet;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route("/api/paragraphs")]
class ParagraphController extends AbstractController
{   

    public function __construct(private EntityManagerInterface $entityManager, private SerializerInterface $serializer)
    {
        $this->entityManager = $entityManager;
        $this->serializer = $serializer;
    }




    #[Route('/create', name: 'app_create_paragraph', methods:['POST'])]
    public function create(#[MapRequestPayload(
        acceptFormat: 'json',
        validationFailedStatusCode: Response::HTTP_BAD_REQUEST
    )] ParagraphDto $paragraphDto): JsonResponse
    {      

        $styleSheet = $this->entityManager->getRepository(StyleSheet::class)->findOneBy(['id' => $paragraphDto->style]);
        if(!$styleSheet) return $this->json(['message' => 'le style sélectionner est introuvable'], Response::HTTP_NOT_FOUND);
        $exist = $this->entityManager->getRepository(Paragraph::class)->findOneBy(['title' => $paragraphDto->title]);
        if($exist) return $this->json(['error' => 'le titre du paragraph existe déjà, veuillez en choisir un autre']);
        $paragraph = new Paragraph();
        $paragraph->setTitle($paragraphDto->title);
        $paragraph->setContent($paragraphDto->content);
        $paragraph->setDisplay($paragraphDto->display);
        $paragraph->setNode($paragraphDto->node);
        $paragraph->setStyleSheet($styleSheet);

        if(count($paragraphDto->medias) > 0){
            foreach ($paragraphDto->medias as $key => $media) {
                $mediaObj = $this->entityManager->getRepository(MediaObject::class)->findOneBy(['id' => $media]);
                if(!$mediaObj) return $this->json(['error' => 'le média sélectionnée n\'a pas été trouvée' ], Response::HTTP_NOT_FOUND);
                $paragraph->addMedia($mediaObj);
            }
        }
        //dump($paragraph);
        $this->entityManager->persist($paragraph);
        $this->entityManager->flush();
        return $this->json([
            'message' => 'Vous avez créer un paragraph avec succès.',
            'data' => $this->serializeEntity($paragraph , ['paragraph_create' , 'media_read' , 'style_read'])
        ], Response::HTTP_OK);
    }

    #[Route("/update/{id}" , name: "app_update_paragraph", methods:['PUT'])]
    public function update(#[MapRequestPayload(
        acceptFormat:'json',
        validationFailedStatusCode: Response::HTTP_BAD_REQUEST
    )] ParagraphDto $paragraphDto , int $id):JsonResponse{
        $styleSheet = $this->entityManager->getRepository(StyleSheet::class)->findOneBy(['id' => $paragraphDto->style]);
        if(!$styleSheet) return $this->json(['message' => 'le style sélectionner est introuvable'], Response::HTTP_NOT_FOUND);
        $exist = $this->entityManager->getRepository(Paragraph::class)->findOneBy(['title' => $paragraphDto->title]);
        if($exist) return $this->json(['error' => 'le titre du paragraph existe déjà, veuillez en choisir un autre'], Response::HTTP_NOT_FOUND);
        $paragraph = $this->entityManager->getRepository(Paragraph::class)->findOneBy(['id' => $id]);
        if(!$paragraph) return $this->json(["error" => "le paragraph à modifier est introuvable"], Response::HTTP_NOT_FOUND);

        if($paragraph->getTitle() !== $paragraphDto->title){
            $paragraph->setTitle($paragraphDto->title);
        }
        if($paragraph->getContent() !== $paragraphDto->content){
            $paragraph->setContent($paragraphDto->content);
        }
        if($paragraph->isDisplay() !== $paragraphDto->display){
            $paragraph->setDisplay($paragraphDto->display);
        }
        if($paragraph->getNode() !== $paragraphDto->node){
            $paragraph->setNode($paragraphDto->node);
        }
        if($paragraph->getStyleSheet()->getId() !== $paragraphDto->style){
            $paragraph->setStyleSheet($this->entityManager->getRepository(StyleSheet::class)->findOneBy(['id' => $paragraphDto->style]));
        }
        
        /**
         * je réinitialise la collection
        */
        $paragraph->getMedia()->clear();

        foreach ($paragraphDto->medias as $media) {
            $mediaObj = $this->entityManager->getRepository(MediaObject::class)->findOneBy(['id' => $media]);
            $paragraph->addMedia($mediaObj);
        }

        $this->entityManager->flush();

        return $this->json(["message" => "vous avez modifiée avec succès le paragraph" , 'data' => $this->serializeEntity($paragraph , ['paragraph_create' , 'media_read' , 'style_read'])], Response::HTTP_OK);
    }


    #[Route("/all" , name:"app_all_paragraph" , methods:['GET'])]
    public function all():JsonResponse{
        $paragraphs = $this->entityManager->getRepository(Paragraph::class)->findAll();
        
        return $this->json(["message" => "vous avez récupérer toute les paragraphs avec succès." , "data" =>  $this->serializeEntity($paragraphs , ['paragraph_read' , 'media_read' , 'style_read'])], Response::HTTP_OK);
    }

    #[Route("/show/{id}" , name: "app_show_paragraph" , methods:('GET'))]
    public function show(int $id):JsonResponse{
        $paragraph = $this->entityManager->getRepository(Paragraph::class)->findOneBy(['id' => $id]);
        if(!$paragraph) return $this->json(['error' => 'le paragraph est introuvable']);

        return $this->json(["message" => "vous avez récupérer le paragraph avec succès.", "data" => $this->serializeEntity($paragraph , ['paragraph_read' , 'media_read' , 'style_read'])], Response::HTTP_OK);
    }

    #[Route("/delete/{id}" , name: "app_delete_paragraph", methods: ['DELETE'])]
    public function delete(int $id):JsonResponse{
        $paragraph = $this->entityManager->getRepository(Paragraph::class)->findOneBy(['id' => $id]);
        if(!$paragraph) return $this->json(['error' => 'le paragraph est introuvable']);
        $this->entityManager->remove($paragraph);
        $this->entityManager->flush();
        return $this->json(['message' => 'vous avez supprimer le paragraph avec succès.']);
    }
    private function serializeEntity(mixed $data , array $groups):mixed{
        return json_decode($this->serializer->serialize($data , 'json' , ['groups' => $groups]));
    }
}
