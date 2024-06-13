<?php

namespace App\Controller;

use App\Dto\CategoryDto;
use App\Entity\Category;
use DateTimeImmutable;
use DateTimeZone;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route("/api/categories")]
class CategoryController extends AbstractController
{   

    public function __construct(private SluggerInterface $slugger , private EntityManagerInterface $entityManager, private SerializerInterface $serializer)
    {
        $this->slugger = $slugger;
        $this->entityManager = $entityManager;
        $this->serializer = $serializer;
    }



    #[Route('/create', name: 'app_create_category', methods: ['POST'])]
    public function create(#[MapRequestPayload(
        acceptFormat: 'json',
        validationFailedStatusCode: Response::HTTP_BAD_REQUEST
    )] CategoryDto $categoryDto): JsonResponse
    {   
        if($this->entityManager->getRepository(Category::class)->findOneBy(['title' => $categoryDto->title])) return $this->json(['error' => 'le titre de la catégorie existe déjà']);

        $category = new Category();
        $category
        ->setTitle($categoryDto->title)
        ->setSlug($this->slugger->slug($categoryDto->title , "-"))
        ->setCreatedAt(new DateTimeImmutable('now' , new DateTimeZone('Europe/Paris')))
        ;
        $this->entityManager->persist($category);
        $this->entityManager->flush();
        return $this->json([
            'message' => 'Vous créer une catégorie avec succès.',
            'data' => $this->serializeCategory($category , ['category_create'])
        ], Response::HTTP_CREATED);
    }


    #[Route('/update/{id}' , name:'app_update_category' , methods: ['PUT'])]
    public function update(#[MapRequestPayload(
        acceptFormat: 'json',
        validationFailedStatusCode: Response::HTTP_BAD_REQUEST
    )] CategoryDto $categoryDto , int $id):JsonResponse {
        $category = $this->entityManager->getRepository(Category::class)->findOneBy(['id' => $id]);
        if(!$category) return $this->json(['error' => 'la catégorie à modier n\'a pas été trouvé']);
        if($this->entityManager->getRepository(Category::class)->findOneBy(['title' => $categoryDto->title])) return $this->json(['error' => 'le titre de la catégorie existe déjà'], Response::HTTP_NOT_FOUND);
        if($category->getTitle() !== $categoryDto->title){
            $category
            ->setTitle($categoryDto->title);
        }
        $category->setSlug($this->slugger->slug($categoryDto->title , '-'));
        $category->setUpdatedAt(new DateTimeImmutable('now' , new DateTimeZone('Europe/Paris')));
        $this->entityManager->flush();
        return $this->json(['message' => 'vous avez modifiée une catégorie avec succès', 'data' => $this->serializeCategory($category , ['category_modify'])], Response::HTTP_OK);
    }

    #[Route("/all" , name: "app_all_category", methods: ['GET'])]
    public function all():JsonResponse{
        $categories = $this->entityManager->getRepository(Category::class)->findAll();
        return $this->json(['message' => 'vous avez récupérer toute les catégories avec succès.' , 'data' => $this->serializeCategory($categories , ['category_read'])], Response::HTTP_OK);
    }

    #[Route('/show/{id}' , name: 'app_show_category' , methods:['GET'])]
    public function show(int $id):JsonResponse{
        $category = $this->entityManager->getRepository(Category::class)->findOneBy(['id' => $id]);
        if(!$category) return $this->json(['error' => 'la catégorie n\'a pas été trouvée'], Response::HTTP_NOT_FOUND);
        return $this->json(['message'  => 'vous avez récupérer la catégorie avec succès.' , 'data' => $this->serializeCategory($category , ['category_read'])], Response::HTTP_OK);
    }

    #[Route('/delete/{id}' , name: 'app_delete_category' , methods:['DELETE'])]
    public function delete(int $id):JsonResponse{
        $category = $this->entityManager->getRepository(Category::class)->findOneBy(['id' => $id]);
        if(!$category) return $this->json(['error' => 'la catégorie n\'a pas été trouvée'], Response::HTTP_NOT_FOUND);
        $this->entityManager->remove($category);
        $this->entityManager->flush();
        return $this->json(['message' => 'vous avez supprimer la catégorie avec succès'] , Response::HTTP_OK);

    }



    private function serializeCategory(mixed $data , array $groups):mixed{
        return json_decode($this->serializer->serialize($data , 'json' , ['groups' => $groups]));
    }
}
