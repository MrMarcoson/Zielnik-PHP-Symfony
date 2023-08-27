<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GlagoliticController extends AbstractController
{
    #[Route('/glagolitic', name: 'app_glagolitic')]
    public function index(): Response
    {
        return $this->render('glagolitic/index.html.twig', [
            'controller_name' => 'GlagoliticController',
        ]);
    }
}
