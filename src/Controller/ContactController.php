<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route(['en' => '/contact', 'pl' => '/kontakt'], name: 'app_contact')]
    public function contact(Request $request, MailerInterface $mailer): Response
    {
        $defaultData = ['message' => ''];
        $form = $this->createFormBuilder($defaultData)
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'attr' => ['class' => 'form-control'],
            ])
            ->add('subject', TextType::class, [
                'label' => 'Subject',
                'attr' => ['class' => 'form-control'],
            ])
            ->add('message', TextareaType::class, [
                'label' => 'Message',
                'attr' => ['class' => 'form-control', 'rows' => '5'],
            ])
            ->add('send', SubmitType::class, [
                'label' => 'Send message',
                'attr' => ['class' => 'btn btn-success'],
            ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('success', 'Message was sent successfully');
            $data = $form->getData();
            $message = (new Email())
                ->from($data['email'])
                ->to('admin@localhost')
                ->subject($data['subject'])
                ->html("<p>" . $data['message'] . "</p>");

            try {
                $mailer->send($message);
            } catch (TransportExceptionInterface $e) {
                $this->addFlash('danger', 'Something went wrong, message was not sent.');
            }

        }
        return $this->render('pages/contact.html.twig', [
            'form' => $form,
        ]);
    }
}
