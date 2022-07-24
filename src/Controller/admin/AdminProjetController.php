<?php

namespace App\Controller\admin;

use App\Entity\Projet;
use App\Form\KeywordSearchType;
use App\Form\ProjetType;
use App\Repository\ProjetRepository;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
#[IsGranted('ROLE_ADMIN')]
#[Route('/projet/admin')]
class AdminProjetController extends AbstractController
{
    #[Route('/', name: 'projet_index', methods: ['GET', 'POST'])]
    public function index(
        ProjetRepository $projetRepository,
        PaginatorInterface $paginator,
        Request $request
    ): Response {

        $form = $this->createForm(KeywordSearchType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $search = $form->getData()['search'];
            if (!empty($search)) {
                $query = $projetRepository->findLikeName($search);
            } else {
                $query = $projetRepository->findBy([], ['id' => 'DESC']);
            }
        } else {
            $query = $projetRepository->findBy([], ['id' => 'DESC']);
        }

        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );
        return $this->renderForm('admin/projet/index.html.twig', [
            'pagination' => $pagination,
            'form' => $form
        ]);
    }

    #[Route('/new', name: 'projet_new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        ProjetRepository $projetRepository,
        SluggerInterface $slugger,
    ): Response
    {
        $projet = new Projet();
        $form = $this->createForm(ProjetType::class, $projet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $projet->setSlug($slugger->slug(strtolower($form->getData()->getName())));
            $projetRepository->add($projet, true);

            $this->addFlash('success', 'Le nouveau projet a bien été créé');

            return $this->redirectToRoute('projet_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/projet/new.html.twig', [
            'projet' => $projet,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'projet_show', methods: ['GET'])]
    public function show(Projet $projet): Response
    {
        return $this->render('admin/projet/show.html.twig', [
            'projet' => $projet,
        ]);
    }

    #[Route('/{id}/edit', name: 'projet_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        Projet $projet,
        ProjetRepository $projetRepository,
        SluggerInterface $slugger,
    ): Response
    {
        $form = $this->createForm(ProjetType::class, $projet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $projet->setSlug($slugger->slug(strtolower($form->getData()->getName())));
            $projetRepository->add($projet, true);

            $this->addFlash('success', 'Le projet a bien été modifié');

            return $this->redirectToRoute('projet_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/projet/edit.html.twig', [
            'projet' => $projet,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'projet_delete', methods: ['POST'])]
    public function delete(Request $request, Projet $projet, ProjetRepository $projetRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$projet->getId(), $request->request->get('_token'))) {
            $projetRepository->remove($projet, true);
            $this->addFlash('success', 'Le projet a bien été supprimé');
        }

        return $this->redirectToRoute('projet_index', [], Response::HTTP_SEE_OTHER);
    }
}
