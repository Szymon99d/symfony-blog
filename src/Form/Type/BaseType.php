<?php

namespace App\Form\Type;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

abstract class BaseType extends AbstractType
{
    public function __construct(protected EntityManagerInterface $em) {}

    public function buildForm(FormBuilderInterface $builder, array $options): void {}

    public function configureOptions(OptionsResolver $resolver): void {}
}
