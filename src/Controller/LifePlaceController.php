<?php




namespace App\Controller;



use App\Entity\LifePlace;
use App\Repository\LifePlaceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LifePlaceController extends AbstractController
{
    #[Route('/lifeplace', name: 'create_local_place')]
    public function createLife(ManagerRegistry $doctrine): Response
    {


        $entityManager = $doctrine->getManager();
        $place   = new LifePlace;
        $place->setBathroom(1)
            ->setLivingRoom(1)
            ->setPieces(3)
            ->setWc(2)
            ->setRooms(3);
        $entityManager->persist($place);
        $entityManager->flush();
        return new Response('Saved new life with id ' . $place->getId());
    }


    #[Route('/api/lifeplace', name: 'app_place_of_file', methods: ['GET'])]
    public function getPlace(LifePlaceRepository $lifePlaceRepository, SerializerInterface $serializer): JsonResponse
    {


        $placeOfLifeListe = $lifePlaceRepository->findAll();

        $jsonplaceOfList = $serializer->serialize($placeOfLifeListe, 'json');
        return new JsonResponse($jsonplaceOfList, Response::HTTP_OK, [], true);
    }



    #[Route('/api/lifeplace/{id}', name: 'detailPlace', methods: ['GET'])]
    public function getPlaceById(int $id, LifePlaceRepository $lifePlaceRepository, SerializerInterface $serializer): JsonResponse
    {

        $place = $lifePlaceRepository->find($id);


        if ($place) {
            $jsonplace = $serializer->serialize($place, 'json');
            return new JsonResponse($jsonplace, Response::HTTP_OK, [], true);
        }
        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }

    // #[IsGranted('ROLE_USER', message: 'Il faut etre enregister pour créer son lieu de vie')]
    #[Route('/api/lifeplace/post', name: 'createPlace', methods: ['POST'])]
    public function createPlace(Request $request,  SerializerInterface $serializer, EntityManagerInterface $em, UrlGeneratorInterface $urlGenerator): JsonResponse
    {

        $place = $serializer->deserialize($request->getContent(), LifePlace::class, 'json');

        $em->persist($place);
        $em->flush();
        $jsonplace = $serializer->serialize($place, 'json', ['groups' => 'getPlaces']);

        $location =  $urlGenerator->generate('detailPlace', ['id' => $place->getId()], UrlGenerator::ABSOLUTE_URL);

        return new JsonResponse(
            $jsonplace,
            Response::HTTP_CREATED,
            ["Location" => $location],

            true
        );
    }
}




// #[Route('/user', name: 'app_user')]
// public function index(ManagerRegistry $doctrine): Response
// {
//     $entityManager = $doctrine->getManager();
//     $place   = new LifePlace;
//     $place->setBathroom(1)
//         ->setLivingRoom(1)
//         ->setRooms(3);
//     $entityManager->persist($place);
//     $entityManager->flush();
//     return new Response('Saved new product with id ' . $place->getId());
// }


// return $this->json([
//     'message' => 'Welcome to your new controller!',
//     'path' => 'src/Controller/UserController.php',
// ]);