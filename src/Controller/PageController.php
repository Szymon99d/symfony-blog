<?php 

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class PageController extends AbstractController{
    #[Route(['en'=>'/about-me','pl'=>'/o-mnie'], name: 'app_about')]
    public function aboutMe(): Response
    {
        return $this->render('pages/homepage.html.twig', [
        ]);
    }
    #[Route('/portfolio', name: 'app_portfolio')]
    public function portfolio(): Response
    {
        return $this->render('pages/homepage.html.twig', [
        ]);
    }
    #[Route('/blog', name: 'app_blog')]
    public function blog(): Response
    {
        return $this->render('pages/homepage.html.twig', [
        ]);
    }
    #[Route(['en'=>'/contact','pl'=>'/kontakt'], name: 'app_contact')]
    public function contact(): Response
    {
        return $this->render('pages/homepage.html.twig', [
        ]);
    }
}

?>