<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\ContactRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mime\Email;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'contact', methods: ['POST', 'GET'])]
    public function index(
        Request $request,
        ContactRepository $contactRepository,
        MailerInterface $mailer
    ): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contact->setDate(new \DateTime());
            $contactRepository->add($contact, true);

            $objet = $form->getData()->getObjet();
            $message = $form->getData()->getMessage();
            $email = (new Email())
                ->from('your_email@example.com')
                ->to('your_email@example.com')
                ->subject("$objet")
                ->html($this->renderView('contact/newContactEmail.html.twig', ['contact' => $contact]));

            $mailer->send($email);

            $this->addFlash('success', 'Votre message a bien été envoyé.');

            return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
        }


        return $this->renderForm('contact/index.html.twig', [
            'form' => $form,
        ]);
    }
}
