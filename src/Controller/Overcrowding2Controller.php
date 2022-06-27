<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Overcrowding2Controller extends AbstractController
{
    #[Route('/overcrowding2', name: 'app_overcrowding2')]
    public function index(): Response
    {




        return $this->render('overcrowding2/index.html.twig', [
            'controller_name' => 'Overcrowding2Controller',
        ]);
    }
}
