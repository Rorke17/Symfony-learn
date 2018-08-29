<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index(Request $request, \Swift_Mailer $mailer)
    {
        $form = $this->createForm(ContactType::class);

        $form->handleRequest($request);

        $this->addFlash('info', 'Some useful info');

        if ($form->isSubmitted() && $form->isValid()) {
            $contactFormData = $form->getData();

            dump($contactFormData);

            $message = (new \Swift_Message('You got Mail!'))
                ->setFrom($contactFormData['email'])
                ->setTo('wonderpie@mailinator.com')
                ->setBody(
                    $contactFormData['message'],
                    'text/plain'
                );
            $mailer->send($message);

            $this->addFlash('success', 'It sent!');

            return $this->redirectToRoute('contact');

        }

        return $this->render('contact/index.html.twig', [
            'our_form' => $form,
            'our_form' => $form->createView(),
        ]);
    }
}
