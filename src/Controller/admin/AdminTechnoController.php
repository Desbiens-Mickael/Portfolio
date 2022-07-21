<?php

namespace App\Controller\admin;

use App\Entity\Techno;
use App\Form\TechnoType;
use App\Repository\TechnoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/techno')]
class AdminTechnoController extends AbstractController
{
    #[Route('/', name: 'techno_index', methods: ['GET'])]
    public function index(TechnoRepository $technoRepository): Response
    {
        return $this->render('admin/techno/index.html.twig', [
            'technos' => $technoRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'techno_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TechnoRepository $technoRepository): Response
    {
        $techno = new Techno();
        $form = $this->createForm(TechnoType::class, $techno);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $technoRepository->add($techno, true);

            return $this->redirectToRoute('techno_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/techno/new.html.twig', [
            'techno' => $techno,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'techno_show', methods: ['GET'])]
    public function show(Techno $techno): Response
    {
        return $this->render('admin/techno/show.html.twig', [
            'techno' => $techno,
        ]);
    }

    #[Route('/{id}/edit', name: 'techno_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Techno $techno, TechnoRepository $technoRepository): Response
    {
        $form = $this->createForm(TechnoType::class, $techno);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $technoRepository->add($techno, true);

            return $this->redirectToRoute('techno_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/techno/edit.html.twig', [
            'techno' => $techno,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'techno_delete', methods: ['POST'])]
    public function delete(Request $request, Techno $techno, TechnoRepository $technoRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$techno->getId(), $request->request->get('_token'))) {
            $technoRepository->remove($techno, true);
        }

        return $this->redirectToRoute('techno_index', [], Response::HTTP_SEE_OTHER);
    }
}
