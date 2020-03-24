<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CritereRepository;
use App\Repository\DiagnosticRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Diagnostic;
use JMS\Serializer\SerializerBuilder;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;

class DiagnosticController extends AbstractController
{
    /**
     * @Route("/diagnostic", name="diagnostic")
     */
    public function index(){
        return $this->render('diagnostic/index.html.twig', [
            'controller_name' => 'DiagnosticController',
        ]);
    }

     /**
     * @Route("/diagnostic/ajouter/{id}", name="diagnostic_ajouter")
     */
    public function add(Request $rq, EntityManagerInterface $em,CritereRepository $critereRepo, int $id){

        $cr=$critereRepo->find($id);
        $surface=$cr->getNbMCarre();

        //Ici on determine le prix du diagnostic en fonction de la surface
        if( $surface <= 25){
            $prix=50;
        }
        if( ($surface > 25) && ($surface <= 50) ){
            $prix=90;
        }
        if( ($surface > 50) && ($surface <= 90) ){
            $prix=150;
        }
        if( ($surface > 90) && ($surface <= 120) ){
            $prix=200;
        }
        
        //ici on gère le chargement du pdf contenant le diagnostic
        if( $rq->isMethod("POST") ){
            $pdf = $rq->files->get("pdfExpertise")->getData();
            dd($pdf);
            $destination = $this->getParameter("dossier_images");
        }
        else{
            $pdf="diagnostic.pdf";
        }

        //Creation de l'objet diagnostic
        $diagnostic = new Diagnostic; 
        $diagnostic->setDate(new \DateTime('now'));
        $diagnostic->setPrix($prix);
        $diagnostic->setStatutPaiement(true);
        $diagnostic->setStatutExpertise(true);
        $diagnostic->setExpertise($pdf);
        $diagnostic->setCritere($cr);

        //Insertion dans la table Diagnostic
        $em->persist($diagnostic);
        $em->flush();

        return $this->redirectToRoute("gestion");
        
    }

    /**
    * @Route("/admin/gestion/listeDiagnostic", name="liste_diagnostic")   
    * @IsGranted("ROLE_ADMIN") 
    */
    public function afficheListeDiagnostic(DiagnosticRepository $dg, SerializerInterface $serializer)
    {
        //Je récupère les diagnostics
        $diagnostics=$dg->findAll();

        //Je serialize les donnee (objets) au format json pour être envoyé en methode ajax
        //J'ai fait cela pour éviter les soucis liées aux relations entre les entités
        $data = $serializer->serialize($diagnostics, 'json');

        //Je crée une "Reponse" pour pouvoir envoyer les données  
        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
        
    }

  
}
