<?php

namespace App\Controller\admin;

use App\Entity\Techno;
use App\Form\KeywordSearchType;
use App\Form\TechnoType;
use App\Repository\TechnoRepository;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[IsGranted('ROLE_ADMIN')]
#[Route('/techno')]
class AdminTechnoController extends AbstractController
{
    #[Route('/', name: 'techno_index', methods: ['GET','POST'])]
    public function index(
        TechnoRepository $technoRepository,
        PaginatorInterface $paginator,
        Request $request
    ): Response{

        $form = $this->createForm(KeywordSearchType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $search = $form->getData()['search'];
            if (!empty($search)) {
                $query = $technoRepository->findLikeName($search);
            } else {
                $query = $technoRepository->findBy([], ['id' => 'DESC']);
            }
        } else {
            $query = $technoRepository->findBy([], ['id' => 'DESC']);
        }

        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );
        return $this->renderForm('admin/techno/index.html.twig', [
            'pagination' => $pagination,
            'form' => $form
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

            $this->addFlash('success', 'La nouvelle techno a bien été créée');

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

            $this->addFlash('success', 'La techno a bien été modifiée');

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
            $this->addFlash('success', 'La techno a bien été supprimée');
        }

        return $this->redirectToRoute('techno_index', [], Response::HTTP_SEE_OTHER);
    }
}
