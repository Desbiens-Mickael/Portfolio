<?php

namespace App\Controller\admin;

use App\Entity\User;
use App\Form\EditPasswordType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class EditUserPasswordController extends AbstractController
{
    #[Route('/edit/user/password/{id<\d+>}', name: 'user_edit_password')]
    public function index(User $user,
                          Request $request,
                          UserPasswordHasherInterface $userPasswordHasher,
                          UserRepository $userRepository,
    ): Response
    {
        $form = $this->createForm(EditPasswordType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($userPasswordHasher->isPasswordValid($user, $form->get('password')->getData()) ) {
                $encodedPassword = $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                );

                $this->addFlash(
                    'success',
                    'Le mot de passe à bien été modifié.'
                );

                $user->setPassword($encodedPassword);
                $userRepository->add($user, true);

                return $this->redirectToRoute('user_index', [] ,Response::HTTP_SEE_OTHER);
            } else {
                $this->addFlash(
                    'warning',
                    'Le mot de passe renseigné est incorrect'
                );
            }
        }

        return $this->renderForm('admin/edit_user_password/index.html.twig', [
            'form' => $form,
        ]);
    }
}
