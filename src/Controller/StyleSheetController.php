<?php

namespace App\Controller;

use App\Dto\StyleSheetDto;
use App\Entity\StyleSheet;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/styleSheets')]
class StyleSheetController extends AbstractController
{   
    public function __construct(private EntityManagerInterface $entityManager, private SerializerInterface $serializer, private StyleSheet $styleSheet)
    {
        $this->entityManager = $entityManager;
        $this->serializer = $serializer;
        $this->styleSheet = $styleSheet;
    }

    #[Route('/create', name: 'app_create_style_sheet',  format:"json" , methods:['POST'])]
    public function create(#[MapRequestPayload(
        acceptFormat: 'json',
        validationFailedStatusCode: Response::HTTP_BAD_REQUEST
    )] StyleSheetDto $styleSheetDto): JsonResponse
    {   

        $this->styleSheet
        ->setFontFamily($styleSheetDto->fontFamily)
        ->setFontSize($styleSheetDto->fontSize)
        ->setColor($styleSheetDto->color)
        ->setBackground($styleSheetDto->background)
        ->setBackgroundImage($styleSheetDto->backgroundImage)
        ->setBackgroundGradient($styleSheetDto->backgroundGradient)
        ->setBorder($styleSheetDto->border)
        ->setBorderRadius($styleSheetDto->borderRadius)
        ->setLineHeight($styleSheetDto->lineHeight)
        ->setLetterSpacing($styleSheetDto->letterSpacing)
        ->setShadow($styleSheetDto->shadow)
        ->setHeight($styleSheetDto->height)
        ->setWidth($styleSheetDto->width)
        ->setPositionType($styleSheetDto->positionType)
        ->setPositionBottom($styleSheetDto->positionBottom)
        ->setPositionLeft($styleSheetDto->positionLeft)
        ->setPositionRight($styleSheetDto->positionRight)
        ->setPositionTop($styleSheetDto->positionTop)
        ->setMarginBottom($styleSheetDto->marginBottom)
        ->setMarginLeft($styleSheetDto->marginLeft)
        ->setMarginRight($styleSheetDto->marginRight)
        ->setMarginTop($styleSheetDto->marginTop)
        ->setPaddingBottom($styleSheetDto->paddingBottom)
        ->setPaddingLeft($styleSheetDto->paddingLeft)
        ->setPaddingRight($styleSheetDto->paddingRight)
        ->setPaddingTop($styleSheetDto->paddingTop)
        ;
        dump($this->styleSheet);

        $this->entityManager->persist($this->styleSheet);
        $this->entityManager->flush();
        return $this->json(['message' => 'le stylesheets a été enregistrer avec succès.' , "data" => $this->styleSheet], Response::HTTP_CREATED);
    }


    #[Route("/update/{id}", name: "app_update_style_sheet" , format: "json" , methods: ['PUT'])]
    public function update(#[MapRequestPayload(
        acceptFormat: 'json',
        validationFailedStatusCode: Response::HTTP_BAD_REQUEST
    )] StyleSheetDto $styleSheetDto , int $id):JsonResponse {

        //dump($id);
        $styleSheet = $this->entityManager->getRepository(StyleSheet::class)->findOneBy(["id" => $id]);
        $styleSheet
        ->setFontFamily($styleSheetDto->fontFamily)
        ->setFontSize($styleSheetDto->fontSize)
        ->setColor($styleSheetDto->color)
        ->setBackground($styleSheetDto->background)
        ->setBackgroundImage($styleSheetDto->backgroundImage)
        ->setBackgroundGradient($styleSheetDto->backgroundGradient)
        ->setBorder($styleSheetDto->border)
        ->setBorderRadius($styleSheetDto->borderRadius)
        ->setLineHeight($styleSheetDto->lineHeight)
        ->setLetterSpacing($styleSheetDto->letterSpacing)
        ->setShadow($styleSheetDto->shadow)
        ->setHeight($styleSheetDto->height)
        ->setWidth($styleSheetDto->width)
        ->setPositionType($styleSheetDto->positionType)
        ->setPositionBottom($styleSheetDto->positionBottom)
        ->setPositionLeft($styleSheetDto->positionLeft)
        ->setPositionRight($styleSheetDto->positionRight)
        ->setPositionTop($styleSheetDto->positionTop)
        ->setMarginBottom($styleSheetDto->marginBottom)
        ->setMarginLeft($styleSheetDto->marginLeft)
        ->setMarginRight($styleSheetDto->marginRight)
        ->setMarginTop($styleSheetDto->marginTop)
        ->setPaddingBottom($styleSheetDto->paddingBottom)
        ->setPaddingLeft($styleSheetDto->paddingLeft)
        ->setPaddingRight($styleSheetDto->paddingRight)
        ->setPaddingTop($styleSheetDto->paddingTop)
        ;
        $this->entityManager->flush();

        return $this->json(['message' => 'le stylesheet a été modifier avec succès.' , 'data' => $styleSheet], Response::HTTP_OK);
    }

    #[Route("/all" , name: "app_all_style_sheet" , format: 'json' , methods: ['GET'])]
    public function all():JsonResponse {
        $styleSheets = $this->entityManager->getRepository(StyleSheet::class)->findAll();
        return $this->json(['message' => 'vous avez récupérée tout les styles avec succès.' , 'data' => $styleSheets ] , Response::HTTP_OK);
    }

    #[Route("/show/{id}" , name: "app_show_style_sheet" , format: "json" , methods: ['GET'])]
    public function show(int $id):JsonResponse{
        $styleSheet = $this->entityManager->getRepository(StyleSheet::class)->findOneBy(["id" => $id]);
        // dump($styleSheet);
        if(!$styleSheet) return $this->json(['error' => "vous n'avez pas trouvé le style."] , Response::HTTP_NOT_FOUND);
        return $this->json(['message' => 'vous avez récuperer le style n° ' . $styleSheet->getId() . " avec succès." , "data" => $styleSheet]);
    }

    #[Route("/delete/{id}" , name: "app_delete_style_sheet" , format: 'json' , methods: ['DELETE'])]
    public function delete(int $id):JsonResponse{
        $styleSheet = $this->entityManager->getRepository(StyleSheet::class)->findOneBy(["id" => $id]);
        // dump($styleSheet);
        if(!$styleSheet) return $this->json(['error' => "vous n'avez pas trouvé le style."] , Response::HTTP_NOT_FOUND);

        $this->entityManager->remove($styleSheet);
        $this->entityManager->flush();
        return $this->json(['message' => 'vous avez supprimer le style n° ' . $id . ' avec succès.'], Response::HTTP_OK);
    }
}
