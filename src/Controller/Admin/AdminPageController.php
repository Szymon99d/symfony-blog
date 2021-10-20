<?php 

namespace App\Controller\admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminPageController extends AbstractController{
    #[Route(['en'=>'/admin/page-panel','pl'=>'/admin/panel-stron'],name: 'app_admin_page_panel')]
    public function pagePanel(): Response{
        return $this->render('/admin/pages/page_panel.html.twig',[

        ]);
    }
   
}

?>