<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiLoginController extends AbstractController
{
    #[Route('/api/login_check2', name: 'app_api_login',  methods: ['GET'])]
    public function index(Request $request, SerializerInterface $serializer, UrlGeneratorInterface $urlGenerator): JsonResponse
    {
        $user = $serializer->deserialize($request->getContent(), User::class, 'json');

        $location =  $urlGenerator->generate('user_get', ['id' => $user->getId()], UrlGenerator::ABSOLUTE_URL);
        return new JsonResponse([
            'username' => 'mrdomazcleemen@gmail.com',
            'password' => 'password',
            ["Location" => $location]
        ]);
    }
}
