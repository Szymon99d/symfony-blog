<?php

namespace App\Form\EventSubscriber\Base;

use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Event\SubmitEvent;
use Symfony\Component\Form\FormEvents;

class BaseEntityFormSubscriber implements EventSubscriberInterface
{
    public function __construct(protected EntityManagerInterface $em)
    {}

    public static function getSubscribedEvents(): array
    {
        return [
            FormEvents::SUBMIT => ['onSubmit', 0],
        ];
    }

    public function onSubmit(SubmitEvent $event): void
    {
        try {
            $entity = $event->getData();
            if(method_exists($entity, 'beforeSave')){
                $entity = $entity->beforeSave();
            }
            $this->em->persist($entity);
            $this->em->flush();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
