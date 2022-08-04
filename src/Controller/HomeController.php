<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home', methods: ['POST', 'GET'])]
    public function index(
        UserRepository $userRepository,
        RequestStack $requestStack,
    ): Response
    {
        $session = $requestStack->getSession();
        $linkedin = $userRepository->find(1)->getLinkedin();
        $github = $userRepository->find(1)->getGithub();
        $user = $userRepository->find(1);
        $session->set('linkedin', $linkedin);
        $session->set('github', $github);

        return $this->render('home/index.html.twig', [
            'user' => $user,
        ]);
    }
}
