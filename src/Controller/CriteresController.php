<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CritereRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Form\CriteresType;
use App\Form\Criteres2Type;
use App\Entity\Critere;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;


class CriteresController extends AbstractController
{

    /**
     * @Route("/criteres", name="criteres")
     */
    public function index()
    {
        return $this->render('criteres/formulaire.html.twig', [


            'controller_name' => 'CritereController',

        ]);
    }
   /**
     * @Route("/criteres/ajouter", name="criteres_ajouter")
     */

    public function add(CritereRepository $critereRepo, Request $rq, EntityManagerInterface $em, UserRepository $ur,TranslatorInterface $translator)
    {
        //$demande = new Criteres();
  
        $formDemande = $this->createForm(CriteresType::class);
        //Il crée le formulaire à partir du LivreType::class, d'où l'argument
        $formDemande->handleRequest($rq);
        //Permet de lier la requête HTTP à mon objet Formulaire. Voir si ça a été soumis?
        if ($formDemande->isSubmitted()) {
            //Si mon formulaire a été soumis
            if ($formDemande->isValid()) {
                //Je teste s'il est valide
                //S'il est valide je crée $nouvelleDemande
                $nouvelleDemande = $formDemande->getData();
                //getData va permettre de créer l'objet en récupérant les données


                $nouvelleDemande->setUser($this->getUser());
              
                $em->persist($nouvelleDemande);
                //On récupère
                $em->flush();
                //On lance
                $msg = $translator->trans('Your request has been registered.');
                $this->addFlash("success", $msg);
                //Permet d'envoyer des messages. Premier le type "error" => "danger", "success",... et ensuite on met le message
                return $this->redirectToRoute("criteres_ajouter");
                //Suite à tout ça, on redirige en mettant le name de la route où l'on souhaite rediriger
            } else {
                $msg = $translator->trans("The form is not valid.");
                $this->addFlash("danger", $msg);
                //Dans le cas où le formulaire n'est pas. "danger" et "succès" sont des classes à bootstrap.
            }
        }
        $formDemande = $formDemande->createView();
        return $this->render('criteres/formulaire.html.twig', compact("formDemande"));

    }
}
