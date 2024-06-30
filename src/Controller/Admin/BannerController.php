<?php

namespace App\Controller\Admin;

use App\Config\Message\MessageType;
use App\Entity\Banner;
use App\Form\Type\Entity\BannerType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BannerController extends AbstractController
{

    #[Route(['en' => '/admin/banner-panel', 'pl' => '/admin/panel-baneru'], name: 'app_admin_banner_panel')]
    public function dashboard(EntityManagerInterface $em): Response
    {
        $banner = $em->getRepository(Banner::class)->find(1);
        return $this->render('/admin/banner/banner_panel.html.twig', [
            'banner' => $banner,
        ]);
    }

    #[Route(['en' => '/admin/change-banner', 'pl' => '/admin/zmień-baner'], name: 'app_admin_banner_change')]
    public function change(EntityManagerInterface $em, Request $request): Response
    {
        $banner = empty($em->getRepository(Banner::class)->find(1)) ? new Banner() : $em->getRepository(Banner::class)->find(1);

        $form = $this->createForm(BannerType::class, $banner);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $this->addFlash(MessageType::SUCCESS, 'Image upload success!');
            }
            if (!empty($form->getErrors())) {
                foreach ($form->getErrors() as $error) {
                    $this->addFlash(MessageType::DANGER, $error->getMessage());
                }
            }
        }

        return $this->render('/admin/banner/change_banner.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route(['en' => '/admin/disable-banner/{banner}', 'pl' => '/admin/wyłącz-baner/{banner}'], name: 'app_admin_banner_disable')]
    public function disable(EntityManagerInterface $em, Banner $banner): Response
    {
        $banner->setActive(!$banner->getActive());
        $em->persist($banner);
        $em->flush();
        return $this->redirectToRoute("app_admin_banner_panel");
    }
}
