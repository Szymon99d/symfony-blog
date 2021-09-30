<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class SidebarController extends AbstractController
{
    
    public function renderSidebar(EntityManagerInterface $em) : Response
    {
        $categories = $em->getRepository(Category::class)->findAll();
        $posts = $em->getRepository(Post::class)->findBy([],['date'=>'DESC'],5);
        return $this->render('/blog_elements/sidebar.html.twig',[
            'categories'=>$categories,
            'posts'=>$posts
        ]);
    }
}
