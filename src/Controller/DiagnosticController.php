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
    // /**
    //  * @Route("/diagnostic", name="diagnostic")
    //  */
    // public function index()
    // {
    //     return $this->render('diagnostic/index.html.twig', [
    //         'controller_name' => 'DiagnosticController',
    //     ]);
    // }

     /**
     * @Route("admin/diagnostic/ajouter/{id}", name="diagnostic_ajouter")
     */

    public function add(DiagnosticRepository $diagRepo, Request $rq, EntityManagerInterface $em,CritereRepository $critereRepo, int $id){

        $cr=$critereRepo->find($id);
        $surface=$cr->getNbMCarre();

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
        
      
        $diagnostic = new Diagnostic; 
        $diagnostic->setDate(new \DateTime('now'));
        $diagnostic->setPrix($prix);
        $diagnostic->setStatutPaiement(true);
        $diagnostic->setStatutExpertise(true);
        $diagnostic->setExpertise("PDF");
        $diagnostic->setCritere($cr);

        $em->persist($diagnostic);
        $em->flush();

        return $this->redirectToRoute("gestion");

    
        //return $this->render('user/compte_admin.html.twig', ["bouton" => $bouton]); 
        
    }

    /**
    * @Route("/admin/gestion/listeDiagnostic", name="liste_diagnostic")   
    * @IsGranted("ROLE_ADMIN") 
    */
    public function afficheListeDiagnostic(DiagnosticRepository $dg, SerializerInterface $serializer)
    {
        
        $diagnostics=$dg->findAll();
        $data = $serializer->serialize($diagnostics, 'json');

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
        
    }
}
