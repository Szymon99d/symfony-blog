<?php 

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BannerController extends AbstractController{
    
    #[Route(['en'=>'/admin/banner-panel','pl'=>'/admin/panel-baneru'], name: 'app_admin_banner_panel')]
    public function bannerDashboard(EntityManagerInterface $em): Response{
        
        return $this->render('/admin/admin_dashboard.html.twig');
    }
    #[Route(['en'=>'/admin/change-banner/{banner}','pl'=>'/admin/zmień-banner/{banner}'], name: 'app_admin_banner_change')]
    public function bannerChange(EntityManagerInterface $em, $banner): Response{
        
        return $this->render('/admin/admin_dashboard.html.twig');
    }
}
?>