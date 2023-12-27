<?php

namespace App\Form\EventSubscriber\Entity;

use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Event\SubmitEvent;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class BannerEntityFormSubscriber implements EventSubscriberInterface
{
    public function __construct(protected EntityManagerInterface $em, protected ParameterBagInterface $parameterBagInterface)
    {}

    public static function getSubscribedEvents(): array
    {
        return [
            FormEvents::SUBMIT => ['onSubmit', 0],
        ];
    }

    public function onSubmit(SubmitEvent $event): void
    {
        $form = $event->getForm();
        $banner = $event->getData();
        $image = $form->get('image')->getData();
        if ($image->guessExtension() != "png") {
            $form->addError(new FormError('Image upload failed! Invalid Extension'));
        } else {
            try {
                $fileName = 'banner.' . $image->guessExtension();
                $image->move(
                    $this->parameterBagInterface->get('image_path'),
                    $fileName
                );
                $banner->setImage($fileName);
            } catch (FileException $e) {
                $form->addError(new FormError("Image upload failed! Couldn't save file"));
            }
        }
    }
}
