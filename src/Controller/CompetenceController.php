<?php

namespace App\Controller;

use App\Entity\Techno;
use App\Repository\TechnoRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CompetenceController extends AbstractController
{
    #[Route('/competence', name: 'competence')]
    public function index(UserRepository $userRepository, TechnoRepository $technoRepository): Response
    {
        $technologies = $technoRepository->findAll();
        $user = $userRepository->find(1);
        return $this->render('competence/index.html.twig', [
            'user' => $user,
            'technologies' => $technologies,
        ]);
    }
}
