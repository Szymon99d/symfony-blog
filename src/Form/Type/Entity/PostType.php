<?php

namespace App\Form\Type\Entity;

use App\Entity\Post;
use App\Form\Custom\Type\TinymceType;
use App\Form\EventSubscriber\Base\BaseEntityFormSubscriber;
use App\Form\Type\BaseType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
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
            ->add('published', CheckboxType::class, [
                'attr' => [
                    'class' => 'form-check-input',
                    'div_class' => 'mb-3'
                ],
                'label_attr' => [
                    'class' => 'form-check-label'
                ],
                'help' => 'When checked, post will be visible for everyone',
                'required' => false,
            ])
            ->add('shortDescription', TextareaType::class, [
                'attr' => ['class' => 'form-control mb-3'],
                'required' => true,
            ])
            ->add('content', TinymceType::class, [
                'required' => false,
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
