<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'app_homepage')]
    public function index(Request $request): Response
    {
        return $this->render('pages/homepage.html.twig', [
        ]);
    }
    #[Route(['en'=>'/about-me','pl'=>'/o-mnie'], name: 'app_about')]
    public function test(): Response
    {
        return $this->render('pages/homepage.html.twig', [
        ]);
    }
}
