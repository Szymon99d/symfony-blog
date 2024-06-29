<?php

namespace App\Form\Type;

use App\Entity\Banner;
use App\Form\EventSubscriber\Base\BaseEntityFormSubscriber;
use App\Form\EventSubscriber\Entity\BannerEntityFormSubscriber;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BannerType extends BaseType
{
    public function __construct(protected EntityManagerInterface $em, protected ParameterBagInterface $parameterBagInterface) {}
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('image', FileType::class, [
                'attr' => ['accept' => '.png', 'class' => 'form-control mb-4'],
                'label' => 'Upload image',
                'data_class' => null,
            ])
            ->add('altText', TextType::class, [
                'label' => 'Alt text',
                'attr' => ['class' => 'form-control mb-3'],
            ])
            ->add('submit', SubmitType::class, [
                'attr' => ['class' => 'btn btn-success w-25'],
            ])
            ->addEventSubscriber(new BannerEntityFormSubscriber($this->em, $this->parameterBagInterface))
            ->addEventSubscriber(new BaseEntityFormSubscriber($this->em))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Banner::class,
        ]);
    }
}
