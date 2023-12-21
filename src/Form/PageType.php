<?php

namespace App\Form;

use App\Entity\Page;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PageType extends BaseType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'attr' => ['class' => 'form-control mb-3'],
                'help' => 'Page title displayed above content',
                'help_attr' => ['class' => 'form-text'],
            ])
            ->add('content', TextareaType::class, [
                'attr' => ['class' => 'form-control mb-3', 'rows' => '25'],
                'help' => 'You can add HTML tags too e.g. <b>Bold text</b>',
                'help_attr' => ['class' => 'form-text'],
            ])
            ->add('pageName', TextType::class, [
                'attr' => ['class' => 'form-control mb-3'],
                'disabled' => true,
            ])
            ->add('submit', SubmitType::class, [
                'attr' => ['class' => 'btn btn-success'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Page::class,
        ]);
    }
}
