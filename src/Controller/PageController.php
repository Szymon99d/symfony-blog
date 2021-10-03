<?php 

namespace App\Controller;

use App\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;
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
    #[Route('/blog/{page}', name: 'app_blog', defaults:['page'=>1])]
    public function blog(EntityManagerInterface $em, $page): Response
    {
        $maxPages = ceil(11/5);
        $prevPage = 1;
        if($page-1>0)
            $prevPage = $page-1;
        $nextPage = $maxPages;
        if($page+1<$maxPages)
            $nextPage = $page+1;
        
        $posts = $em->getRepository(Post::class)->findBy([],['date'=>'DESC']);
        return $this->render('pages/blog.html.twig', [
            'posts'=>$posts,
            'currentPage'=>$page,
            'prevPage'=>$prevPage,
            'nextPage'=>$nextPage,
            'maxPages'=>$maxPages,
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