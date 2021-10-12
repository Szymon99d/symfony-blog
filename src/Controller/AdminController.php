<?php 

namespace App\Controller;

use App\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController{
    
    #[Route(['en'=>'/admin-dashboard','pl'=>'/panel-administratora'], name: 'app_admin')]
    public function adminDashboard(): Response{
        return $this->render('/admin/admin_dashboard.html.twig');
    }
    #[Route(['en'=>'/admin-post-panel/{page}','pl'=>'/admin-panel-postów/{page}'], name: 'app_admin_post_panel',
        defaults: ['page'=>1]
    )]
    public function adminPostPanel(EntityManagerInterface $em, int $page): Response{

        $posts = $em->getRepository(Post::class)->findAllPaginated($page,null);

        return $this->render('/admin/posts/post_panel.html.twig',[
            'posts'=>$posts,
        ]);
    }
    #[Route(['en'=>'/admin-edit-post/{post}','pl'=>'/admin-edytuj-post/{post}'], name: 'app_admin_edit_posts'
    )]
    public function adminEditPost(Post $post): Response{

        return $this->render('/admin/posts/edit_post.html.twig',[
            'post'=>$post,
        ]);
    }

}



?>