<?php

namespace App\Controller;

use DateTime;
use App\Entity\User;
use App\Entity\LifePlace;

use App\Repository\UserRepository;
use App\Controller\LifePlaceController;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\SerializationContext;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class UserController extends AbstractController
{

    private $userPasswordHasher;

    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userPasswordHasher = $userPasswordHasher;
    }


    #[Route('/user', name: 'app_user')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $date = new DateTime("now");
        $entityManager1 = $doctrine->getManager();
        $place   = new LifePlace;
        $place->setBathroom(1)
            ->setLivingRoom(1)
            ->setPieces(3)
            ->setWc(2)
            ->setRooms(3);
        $entityManager1->persist($place);
        $entityManager1->flush();


        $date = new DateTime("now");
        $entityManager = $doctrine->getManager();
        $user   = new User;
        $user->setName("Dominique")
            ->setFirstName("Clément")
            ->setZipCode(33800)
            ->setEmail("surtoutpas@gmail.com")
            ->setStreet("rue furtado")
            ->setPhone("0671778135")
            ->setLife($place)
            ->setDateIn($date)
            ->setPassword($this->userPasswordHasher->hashPassword($user, "password"));
        $entityManager->persist($user);
        $entityManager->flush();
        return new Response('Saved new user with id ' . $user->getId());
    }




    #[Route('/api/user', name: 'user_get', methods: ['GET'])]
    public function getPlace(UserRepository $UserRepository, SerializerInterface $serializer): JsonResponse
    {

        $user = $UserRepository->findAll();

        $jsonplaceOfList = $serializer->serialize($user, 'json');
        return new JsonResponse($jsonplaceOfList, Response::HTTP_OK, [], true);
    }


    #[Route('/api/user/registration', name: 'createUser', methods: ['POST'])]
    public function createPlace(Request $request,  SerializerInterface $serializer, EntityManagerInterface $em, UrlGeneratorInterface $urlGenerator): JsonResponse
    {


        $user = $serializer->deserialize($request->getContent(), User::class, 'json');


        $em->persist($user);
        $em->flush();
        $jsonplace = $serializer->serialize($user, 'json', ['groups' => 'getUser']);

        $location =  $urlGenerator->generate('user_get', ['id' => $user->getId()], UrlGenerator::ABSOLUTE_URL);

        return new JsonResponse(
            $jsonplace,
            Response::HTTP_CREATED,
            ["Location" => $location],

            true
        );
    }



    // /**
    //  * @Route("/api/login", name="api_login", methods={"POST"})
    //  */
    // public function login(AuthenticationUtils $authenticationUtils)
    // {

    //     $request = Request::createFromGlobals();
    //     // get the user credentials from the request
    //     $credentials = json_decode($request->getContent(), true);

    //     // get the user object from the database
    //     $user = $this->getDoctrine()
    //         ->getRepository(User::class)
    //         ->findOneBy(['email' => $credentials['email']]);

    //     // check if the user exists and the password is correct
    //     if (!$user || !password_verify($credentials['password'], $user->getPassword())) {
    //         return new JsonResponse(['error' => 'Invalid email or password'], Response::HTTP_UNAUTHORIZED);
    //     }

    //     // generate a JWT token for the user
    //     $token = $this->get('lexik_jwt_authentication.encoder')
    //         ->encode([
    //             'username' => $user->getUsername(),
    //             'exp' => time() + $this->getParameter('jwt_token_ttl')
    //         ]);

    //     return new JsonResponse(['token' => $token], Response::HTTP_OK);
    // }
}