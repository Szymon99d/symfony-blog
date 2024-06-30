<?php

namespace App\Controller\Admin;

use App\Config\Message\MessageType;
use App\Entity\Post;
use App\Form\Type\Entity\PostType;
use App\Service\MassActions\MassDeleteService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    public function __construct(protected EntityManagerInterface $em)
    {}

    #[Route(['en' => '/admin/post-panel/{page}', 'pl' => '/admin/panel-postów/{page}'], name: 'app_admin_post_panel',
        defaults: ['page' => 1]
    )]
    public function list(int $page): Response
    {
        $posts = $this->em->getRepository(Post::class)->findAllPaginated($page, 10);

        return $this->render('/admin/posts/post_panel.html.twig', [
            'posts' => $posts,
        ]);
    }

    #[Route(['en' => '/admin/edit/post/{post}', 'pl' => '/admin/edytuj/post/{post}'], name: 'app_admin_edit_post')]
    public function edit(Post $post, Request $request): Response
    {
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash(MessageType::SUCCESS, 'Record saved successfully');
        }

        return $this->render('/admin/posts/edit_post.html.twig', [
            'postForm' => $form,
            'post' => $post,
        ]);
    }

    #[Route(['en' => '/admin/create/post', 'pl' => '/admin/dodaj/post'], name: 'app_admin_create_post')]
    public function create(Request $request): Response
    {
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash(MessageType::SUCCESS, 'Record saved successfully');
            return $this->redirectToRoute("app_admin_edit_post", ['post' => $post->getId()]);
        }

        return $this->render('/admin/posts/edit_post.html.twig', [
            'postForm' => $form,
            'post' => $post,
        ]);
    }

    #[Route(['en' => '/admin/delete/post/{post}', 'pl' => '/admin/usuń/post/{post}'], name: 'app_admin_delete_post')]
    public function delete(Post $post): Response
    {
        $this->em->remove($post);
        $this->em->flush();
        return $this->redirectToRoute("app_admin_post_panel", ['page' => 1]);
    }

    #[Route(path: "/api/admin/massDelete/post", name: 'app_admin_mass_delete_post', methods: ['DELETE'], defaults: [
        '_api_operation_name' => '_api_/api/admin/massDelete/post',
    ])]
    public function massDelete(Request $request): JsonResponse
    {
        return (new MassDeleteService(json_decode($request->getContent(), true), $this->em))->process();
    }
}
