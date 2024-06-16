<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin-dashboard', name: 'app_admin')]
    public function adminDashboard(): Response
    {
        return $this->render('/admin/admin_dashboard.html.twig');
    }
}
