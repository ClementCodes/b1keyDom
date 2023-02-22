<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ApiLoginController extends AbstractController
{
    #[Route('/api/login_check2', name: 'app_api_login',  methods: ['GET'])]
    public function index(): JsonResponse
    {
        return $this->json([
            'username' => 'mrdomazcleemen@gmail.com',
            'password' => 'password',
        ]);
    }
}
