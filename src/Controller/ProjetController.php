<?php

namespace App\Controller;

use App\Entity\Projet;
use App\Repository\ProjetRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/projet/prez', name: 'projet_prez_')]
class ProjetController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(
        ProjetRepository $projetRepository,
        PaginatorInterface $paginator,
        Request $request
    ): Response
    {
        $query = $projetRepository->findAll();

        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            3/*limit per page*/
        );

        return $this->render('projet/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    #[Route('/{slug}', name: 'show')]
    public function show(Projet $projet): Response
    {
        return $this->render('projet/show.html.twig', [
            'projet' => $projet,
        ]);
    }
}