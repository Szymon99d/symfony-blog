<?php 

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController{
    
    #[Route(['en'=>'/admin-dashboard','pl'=>'/panel-administratora'], name: 'app_admin')]
    public function adminDashboard(): Response{
        return $this->render('/admin/admin_dashboard.html.twig');
    }

}



?>