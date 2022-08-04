<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Vich\UploaderBundle\Handler\DownloadHandler;


class DownloadController extends AbstractController
{
    #[Route('/download', name: 'download')]
    public function downloadImageAction(UserRepository $userRepository, DownloadHandler $downloadHandler): Response
    {
        $user = $userRepository->find(1);
//        $fileName = 'cv_desbiens_mickael.pdf';

        return $downloadHandler->downloadObject($user, 'cvFile', null, null, false);
    }
}