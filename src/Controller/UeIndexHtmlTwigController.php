<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UeIndexHtmlTwigController extends AbstractController
{
    #[Route('/ue/index/html/twig', name: 'app_ue_index_html_twig')]
    public function index(): Response
    {
        return $this->render('ue_index_html_twig/index.html.twig', [
            'controller_name' => 'UeIndexHtmlTwigController',
        ]);
    }
}
