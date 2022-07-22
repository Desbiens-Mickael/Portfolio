<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(UserRepository $userRepository, RequestStack $requestStack): Response
    {
        $session = $requestStack->getSession();
        $user = $userRepository->find(1);
        $session->set('user', $user);
        return $this->render('home/index.html.twig', [
            'user' => $user
        ]);
    }
}
