<?php 

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController{
    
    private $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    
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
    public function adminEditPost(Post $post, Request $request): Response{

        $form = $this->createForm(PostType::class,$post);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $data = $form->getData();
            $post->setTitle($data->getTitle());
            $post->setContent($data->getContent());
            $post->setDate($data->getDate());
            $post->setCategory($data->getCategory());
            $this->em->persist($post);
            $this->em->flush();
        }
        
        return $this->render('/admin/posts/edit_post.html.twig',[
            'postForm'=>$form->createView(),
            'post'=>$post
        ]);
    }
    #[Route(['en'=>'/admin-create-post','pl'=>'/admin-dodaj-post'], name: 'app_admin_create_post'
    )]
    public function adminCreatePost(Request $request): Response{

        $post = new Post();
        $form = $this->createForm(PostType::class,$post);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $data = $form->getData();
            $post->setTitle($data->getTitle());
            $post->setContent($data->getContent());
            $post->setDate($data->getDate());
            $post->setCategory($data->getCategory());
            $this->em->persist($post);
            $this->em->flush();
            return $this->redirectToRoute("app_admin_post_panel",['page'=>1]);
        }
        
        return $this->render('/admin/posts/edit_post.html.twig',[
            'postForm'=>$form->createView(),
            'post'=>$post
        ]);
    }
    #[Route(['en'=>'/admin-delete-post/{post}','pl'=>'/admin-usuń-post/{post}'], name: 'app_admin_delete_post'
    )]
    public function adminDeletePost(Post $post): Response
    {
        $this->em->remove($post);
        $this->em->flush();
        return $this->redirectToRoute("app_admin_post_panel",['page'=>1]);
    }
}

?>