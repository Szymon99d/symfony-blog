<?php

namespace App\Form\Type;

use App\Entity\Post;
use App\Form\EventSubscriber\Base\BaseEntityFormSubscriber;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostType extends BaseType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'attr' => ['class' => 'form-control mb-3'],
            ])
            ->add('content', TextareaType::class, [
                'attr' => ['class' => 'form-control mb-3'],
            ])
            ->add('category', null, [
                'attr' => ['class' => 'form-select mb-3'],
            ])
            ->add('submit', SubmitType::class, [
                'attr' => ['class' => 'btn btn-success'],
            ])
            ->addEventSubscriber(new BaseEntityFormSubscriber($this->em))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
