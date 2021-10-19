<?php 

namespace App\Controller\admin;

use App\Entity\Banner;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BannerController extends AbstractController{
    
    #[Route(['en'=>'/admin/banner-panel','pl'=>'/admin/panel-baneru'], name: 'app_admin_banner_panel')]
    public function bannerDashboard(EntityManagerInterface $em): Response{
        
        $banner = $em->getRepository(Banner::class)->find(1);
        return $this->render('/admin/banner/banner_panel.html.twig',[
            'banner'=>$banner
        ]);
    }
    #[Route(['en'=>'/admin/change-banner','pl'=>'/admin/zmień-baner'], name: 'app_admin_banner_change')]
    public function bannerChange(EntityManagerInterface $em, Request $request): Response{
        
        $form = $this->createFormBuilder()
            ->add('image', FileType::class,[
                'attr'=>['accept'=>'.png, .jpg, .jpeg', 'class'=>'form-control mb-4'],
                'label'=>'Upload image'
            ])
            ->add('submit',SubmitType::class,[
                'attr'=>['class'=>'btn btn-success w-25']
            ])
            ->getForm();

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $image = $form->get('image')->getData();
            if($image->guessExtension()!="png" && $image->guessExtension()!="jpg" && $image->guessExtension()!="jpeg")
                {$this->addFlash('danger','Image upload failed!'); 
                dump($image->guessExtension());}
            else{
                try{
                    $fileName = 'default-banner.'.$image->guessExtension();
                    $image->move(
                    $this->getParameter('image_path'),
                    $fileName
                    );
                    $this->addFlash('success','Image upload success!');
                }catch(FileException $e){
                    $this->addFlash('danger','Image upload failed!');
                }
                $banner = $em->getRepository(Banner::class)->find(1);
                $banner->setImage($fileName);
                $em->persist($banner);
                $em->flush();
            }
        }
        
        return $this->render('/admin/banner/change_banner.html.twig',[
            'form'=>$form->createView()
        ]);
    }
    #[Route(['en'=>'/admin/disable-banner/{banner}','pl'=>'/admin/wyłącz-baner/{banner}'], name: 'app_admin_banner_disable')]
    public function bannerDisable(EntityManagerInterface $em, Banner $banner): Response{
        $banner->setActive(!$banner->getActive());
        $em->persist($banner);
        $em->flush(); 
        return $this->redirectToRoute("app_admin_banner_panel");
    }
}
?>