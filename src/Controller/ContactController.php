<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Swift_Mailer;
use App\Form\ContactType;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index(Request $request, \Swift_Mailer $mailer)
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $contact = $form->getData();
            dd($contact);
            
            // Ici nous enverrons l'e-mail
            $message = (new \Swift_Message('Nouveau contact'))
            // On attribue l'expéditeur
            ->setFrom($contact['email'])

            // On attribue le destinataire
            ->setTo('test90wf3@gmail.com')

            // On crée le texte avec la vue
            ->setBody(
                $this->render(
                    'contact/formContact.html.twig', compact('contact')
                ),
                'text/html'
            );

            $mailer->send($message);
        
            //Confirmation de l'envoi
            $this->addFlash('message', 'Votre message a été transmis, nous vous répondrons dans les meilleurs délais.'); // Permet un message flash de renvoi
        }
        
        return $this->render('contact/formContact.html.twig',['contactForm' => $form->createView()]);

    }


}
