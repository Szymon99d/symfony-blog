<?php

namespace App\Controller\Admin;

use App\Config\Message\MessageType;
use App\Entity\Category;
use App\Form\Type\CategoryType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    public function __construct(protected EntityManagerInterface $em){}

    #[Route(['en' => '/admin/category-panel/{page}', 'pl' => '/admin/panel-kategorii/{page}'], name: 'app_admin_category_panel',
        defaults: ['page' => 1]
    )]
    public function list(int $page): Response
    {
        $category = $this->em->getRepository(Category::class)->findAllPaginated($page);

        return $this->render('/admin/category/category_panel.html.twig', [
            'category' => $category,
        ]);
    }

    #[Route(['en' => '/admin/edit/category/{category}', 'pl' => '/admin/edytuj/kategorię/{category}'], name: 'app_admin_edit_category')]
    public function edit(Category $category, Request $request): Response
    {
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash(MessageType::SUCCESS, 'Record saved successfully');
        }

        return $this->render('/admin/category/edit_category.html.twig', [
            'categoryForm' => $form,
            'category' => $category,
        ]);
    }

    #[Route(['en' => '/admin/create/category', 'pl' => '/admin/dodaj/kategorię'], name: 'app_admin_create_category')]
    public function create(Request $request): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash(MessageType::SUCCESS, 'Record saved successfully');
            return $this->redirectToRoute("app_admin_edit_category", ['category' => $category->getId()]);
        }

        return $this->render('/admin/category/edit_category.html.twig', [
            'categoryForm' => $form,
            'category' => $category,
        ]);
    }

    #[Route(['en' => '/admin/delete/category/{category}', 'pl' => '/admin/usuń/kategorię/{category}'], name: 'app_admin_delete_category')]
    public function delete(Category $category): Response
    {
        $category->removePosts();
        $this->em->remove($category);
        $this->em->flush();
        return $this->redirectToRoute("app_admin_category_panel", ['page' => 1]);
    }
}
