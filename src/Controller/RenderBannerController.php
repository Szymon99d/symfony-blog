<?php

namespace App\Controller;

use App\Entity\Banner;
use App\Entity\Category;
use App\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class RenderBannerController extends AbstractController
{
    public function renderBanner(EntityManagerInterface $em) : Response
    {
        $banner = $em->getRepository(Banner::class)->find(1);
        return $this->render('/blog_elements/banner.html.twig',[
            'banner'=>$banner
        ]);
    }
}
