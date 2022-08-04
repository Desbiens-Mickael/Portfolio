<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfilController extends AbstractController
{
    #[Route('/profil', name: 'profil')]
    public function index(
        UserRepository $userRepository,
    ): Response
    {
        $user = $userRepository->find(1);
        return $this->render('profil/index.html.twig', [
            'user' => $user,
        ]);
    }
}
