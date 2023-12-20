<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Entity\Post;
use App\Form\CategoryType;
use App\Form\PostType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{

    private EntityManagerInterface $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/admin-dashboard', name: 'app_admin')]
    public function adminDashboard(): Response
    {
        return $this->render('/admin/admin_dashboard.html.twig');
    }
    #[Route(['en' => '/admin/post-panel/{page}', 'pl' => '/admin/panel-postów/{page}'], name: 'app_admin_post_panel',
        defaults: ['page' => 1]
    )]
    public function adminPostPanel(int $page): Response
    {

        $posts = $this->em->getRepository(Post::class)->findAllPaginated($page);

        return $this->render('/admin/posts/post_panel.html.twig', [
            'posts' => $posts,
        ]);
    }
    #[Route(['en' => '/admin/edit/post/{post}', 'pl' => '/admin/edytuj/post/{post}'], name: 'app_admin_edit_post'
    )]
    public function adminEditPost(Post $post, Request $request): Response
    {

        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $post->setTitle($data->getTitle());
            $post->setContent($data->getContent());
            $post->setDate($data->getDate());
            $post->setCategory($data->getCategory());
            $this->em->persist($post);
            $this->em->flush();
        }

        return $this->render('/admin/posts/edit_post.html.twig', [
            'postForm' => $form,
            'post' => $post,
        ]);
    }
    #[Route(['en' => '/admin/create/post', 'pl' => '/admin/dodaj/post'], name: 'app_admin_create_post'
    )]
    public function adminCreatePost(Request $request): Response
    {

        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $post->setTitle($data->getTitle());
            $post->setContent($data->getContent());
            $post->setDate($data->getDate());
            $post->setCategory($data->getCategory());
            $this->em->persist($post);
            $this->em->flush();
            return $this->redirectToRoute("app_admin_post_panel", ['page' => 1]);
        }

        return $this->render('/admin/posts/edit_post.html.twig', [
            'postForm' => $form,
            'post' => $post,
        ]);
    }
    #[Route(['en' => '/admin/delete/post/{post}', 'pl' => '/admin/usuń/post/{post}'], name: 'app_admin_delete_post'
    )]
    public function adminDeletePost(Post $post): Response
    {
        $this->em->remove($post);
        $this->em->flush();
        return $this->redirectToRoute("app_admin_post_panel", ['page' => 1]);
    }

    #[Route(['en' => '/admin/category-panel/{page}', 'pl' => '/admin/panel-kategorii/{page}'], name: 'app_admin_category_panel',
        defaults: ['page' => 1]
    )]
    public function adminCategoryPanel(int $page): Response
    {

        $category = $this->em->getRepository(Category::class)->findAllPaginated($page);

        return $this->render('/admin/category/category_panel.html.twig', [
            'category' => $category,
        ]);
    }
    #[Route(['en' => '/admin/edit/category/{category}', 'pl' => '/admin/edytuj/kategorię/{category}'], name: 'app_admin_edit_category'
    )]
    public function adminEditCategory(Category $category, Request $request): Response
    {

        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $category->setName($data->getName());
            $this->em->persist($category);
            $this->em->flush();
        }

        return $this->render('/admin/category/edit_category.html.twig', [
            'categoryForm' => $form,
            'category' => $category,
        ]);
    }
    #[Route(['en' => '/admin/create/category', 'pl' => '/admin/dodaj/kategorię'], name: 'app_admin_create_category'
    )]
    public function adminCreateCategory(Request $request): Response
    {

        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $category->setName($data->getName());
            $this->em->persist($category);
            $this->em->flush();
            return $this->redirectToRoute("app_admin_category_panel", ['page' => 1]);
        }

        return $this->render('/admin/category/edit_category.html.twig', [
            'categoryForm' => $form,
            'category' => $category,
        ]);
    }
    #[Route(['en' => '/admin/delete/category/{category}', 'pl' => '/admin/usuń/kategorię/{category}'], name: 'app_admin_delete_category'
    )]
    public function adminDeleteCategory(Category $category): Response
    {
        $this->em->remove($category);
        $this->em->flush();
        return $this->redirectToRoute("app_admin_category_panel", ['page' => 1]);
    }
}
