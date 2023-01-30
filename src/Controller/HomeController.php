<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/', name: 'home')]

class HomeController extends AbstractController {
    #[Route('/')]
    public function index(): Response
    {
        return $this->render('user/delete.html.twig');
    }
}
