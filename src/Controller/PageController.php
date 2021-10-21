<?php 

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Page;
use App\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class PageController extends AbstractController{
    #[Route(['en'=>'/about-me','pl'=>'/o-mnie'], name: 'app_about')]
    public function aboutMe(EntityManagerInterface $em): Response
    {
        $page = $em->getRepository(Page::class)->find(2);
        return $this->render('pages/page.html.twig', [
            'page'=>$page
        ]);
    }
    #[Route('/portfolio', name: 'app_portfolio')]
    public function portfolio(EntityManagerInterface $em): Response
    {
        $page = $em->getRepository(Page::class)->find(3);

        return $this->render('pages/page.html.twig', [
            'page'=>$page
        ]);
    }
    #[Route('/blog/{page}', name: 'app_blog', defaults:['page'=>1])]
    public function blog(EntityManagerInterface $em, $page): Response
    {
        $posts = $em->getRepository(Post::class)->findAllPaginated($page,null);

        return $this->render('pages/blog.html.twig', [
            'posts'=>$posts,
            'currentPage'=>$page,
        ]);
    }
    #[Route('/category/{category}/{page}',name: 'app_blog_category', defaults:['page'=>1,'category'=>1])]
    public function blogCategory(EntityManagerInterface $em,int $page, Category $category): Response
    {
        $posts = $em->getRepository(Post::class)->findAllPaginated($page,$category);
        dump($posts);
        return $this->render('pages/blog.html.twig', [
            'posts'=>$posts,
            'currentPage'=>$page,
        ]);
    }
    #[Route('/blog/post/{id}', name: 'app_post_read')]
    public function post(Post $post): Response
    {
        return $this->render('pages/post.html.twig', [
            'post'=>$post
        ]);
    }
}

?>