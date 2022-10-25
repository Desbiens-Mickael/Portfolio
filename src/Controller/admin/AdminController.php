<?php

namespace App\Controller\admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[IsGranted('ROLE_ADMIN')]
class AdminController extends AbstractController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $paths = ['images_projet_dir', 'images_techno_dir', 'pdf_cv_dir', 'images_cv_dir'];
        foreach ($paths as $path) {
            $path_dir = $this->getParameter($path);
            if (!file_exists("../public/$path_dir")){
                mkdir("../public/$path_dir");
            }
        }

        return $this->render('admin/home/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
}
