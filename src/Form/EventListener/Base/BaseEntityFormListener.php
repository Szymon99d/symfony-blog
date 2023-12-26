<?php

namespace App\Form\EventListener\Base;

use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Event\SubmitEvent;
use Symfony\Component\Form\FormEvents;

class BaseEntityFormListener implements EventSubscriberInterface
{
    public function __construct(protected EntityManagerInterface $em) {}

    public static function getSubscribedEvents(): array
    {
        return [
            FormEvents::SUBMIT   => ['onSubmit', 0],
        ];
    }

    public function onSubmit(SubmitEvent $event): void
    {
        try{
            $this->em->persist($event->getData());
            $this->em->flush();
        } catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }
}