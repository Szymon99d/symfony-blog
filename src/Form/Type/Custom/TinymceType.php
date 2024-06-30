<?php

namespace App\Form\Custom\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class TinymceType extends AbstractType
{
    public function getBlockPrefix(): string
    {
        return 'tinymce';
    }

    public function getParent(): string
    {
        return TextareaType::class;
    }
}
