<?php 

namespace App\Controller\admin;

use App\Entity\Page;
use App\Form\PageType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminPageController extends AbstractController{
    #[Route(['en'=>'/admin/page-panel','pl'=>'/admin/panel-stron'],name: 'app_admin_page_panel')]
    public function pagePanel(EntityManagerInterface $em): Response{
        $pages = $em->getRepository(Page::class)->findAll();
        return $this->render('/admin/pages/page_panel.html.twig',[
            'pages'=>$pages
        ]);
    }
    #[Route(['en'=>'/admin/page-edit/{page}','pl'=>'/admin/edytuj-stronę/{page}'],name: 'app_admin_page_edit')]
    public function pageEdit(EntityManagerInterface $em, Page $page, Request $request): Response{
        
        $form = $this->createForm(PageType::class,$page,[]);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $formData = $form->getData();
            $page->setTitle($formData['title']);
            $page->setContent($formData['content']);
            $em->persist($page);
            $em->flush();
            $this->addFlash('success','Page content updated successfully!');
        }
        
        return $this->render('/admin/pages/edit_page.html.twig',[
            'form'=>$form->createView()
        ]);
    }
   
}

?>