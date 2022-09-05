<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\ContactRepository;
use App\Service\RecaptchaManager;
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
        MailerInterface $mailer,
        RecaptchaManager $recaptchaManager
    ): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);
        $errors = [];
        if ($form->isSubmitted() && $form->isValid()) {
            $response = $recaptchaManager->fetchGoogleInformation($_POST['g-recaptcha-response']);
            if ($response['success']) {
                $contact->setDate(new \DateTime());
                $contactRepository->add($contact, true);

                $objet = $form->getData()->getObjet();
                $email = (new Email())
                    ->from($this->getParameter('mailer_from'))
                    ->to($this->getParameter('mailer_to'))
                    ->subject("$objet")
                    ->html($this->renderView('contact/newContactEmail.html.twig', ['contact' => $contact]));

                $mailer->send($email);

                $this->addFlash('success', 'Votre message a bien été envoyé.');
            }
            if (!empty($response['error-codes'])) {
                foreach ($response['error-codes'] as $error) {
                    $errors[] = $error;
                }
            }
        }
        return $this->renderForm('contact/index.html.twig', [
            'form' => $form,
            'errors' => $errors
        ]);
    }
}
