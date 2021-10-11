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
    #[Route(['en'=>'/admin-edit-posts/{page}','pl'=>'/admin-edytuj-posty/{page}'], name: 'app_admin_edit_posts',
        defaults: ['page'=>1]
    )]
    public function adminEditPosts(EntityManagerInterface $em, int $page): Response{

        $posts = $em->getRepository(Post::class)->findAllPaginated($page,null);

        return $this->render('/admin/posts/edit_post.html.twig',[
            'posts'=>$posts,
        ]);
    }

}



?>