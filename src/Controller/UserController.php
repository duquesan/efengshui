<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface as EMI;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Form\UserSubsFormType;
use App\Security\LoginFormAuthenticator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;

class UserController extends AbstractController
{
  
  /**
     * @Route("/inscription", name="user_subs")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, GuardAuthenticatorHandler $guardHandler, LoginFormAuthenticator $authenticator): Response
    {
        $user = new User();
        $form = $this->createForm(UserSubsFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            // do anything else you need here, like send an email

            return $guardHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $authenticator,
                'main' // firewall name in security.yaml
            );
        }

        return $this->render('user/index.html.twig', [
            'UserSubsForm' => $form->createView(),
          
        ]);
    }

  
     /**
     * @Route("/user", name="compte_user")    
     */
    public function compte_user()
    {
        return $this->render('user/compte_user.html.twig');
    }

        /**
        * @Route("/admin/user", name="gestion")    
        */
    public function compte_admin(UserRepository $ur)
        {
            return $this->render('user/compte_admin.html.twig', [ "user" => $ur->findAll() ]);
        }
    /**
 * @Route("/admin/user/ajouter", name="user_add")
 * @IsGranted("ROLE_ADMIN")
 */
public function add(UserRepository $ur, EMI $em, Request $request)
{
    $bouton = "add";

    if($request->isMethod("POST")){ 
        $nom = $request->request->get('nom');
        $prenom = $request->request->get('prenom');
        $email = $request->request->get('email');
        $mdp = $request->request->get('password');
        $mdp = password_hash($mdp, PASSWORD_DEFAULT);
        $user = new User; 
        $user->setEmail($nom);
        $user->setPassword($mdp);

        $em->persist($user);
        $em->flush();

        return $this->redirectToRoute("gestion");

    }else{
        return $this->render('user/compte_admin.html.twig', ["bouton" => $bouton]); 
    }
    
}

/**
 * @Route("/admin/user/modifier/{id}", name="user_update")
 * @IsGranted("ROLE_ADMIN")
 */
public function update(UserRepository $ur, Request $request, EMI $em, int $id)
{
    $bouton = "update";
    $userAmodifier = $ar->find($id);

    if($request->isMethod("POST")){ 
        $nom = $request->request->get('nom');
        $prenom = $request->request->get('prenom');
        $email = $request->request->get('email');
        // trim supprime les espaces au début et à la fin d'une chaîne de caractères
        $mdp = trim($request->request->get('password'));
        if($mdp){
            $mdp = password_hash($mdp, PASSWORD_DEFAULT);
            $userAmodifier->setPassword($mdp);
        }
        $userAmodifier->setNom($nom);
        $userAmodifier->setPrenom($prenom);
        $userAmodifier->setEmail($email);

        $em->persist($userAmodifier);
        $em->flush();

        return $this->redirectToRoute("user_list");

    }
    return $this->render('user/formulaire.html.twig', ["user" => $userAmodifier, "bouton" => $bouton]); 

}

/**
 * @Route("/admin/user/supprimer/{id}", name="user_delete")
 * @IsGranted("ROLE_ADMIN")
 */
public function delete(UserRepository $ur, Request $request,EMI $em, int $id)
{
    $bouton = "delete";
    $userAsupprimer = $ar->find($id);
    
    if ($request->isMethod("POST")){
        $em->remove($userAsupprimer);
        $em->flush();
        return $this->redirectToRoute("user_list");
    }
    return $this->render('user/formulaire.html.twig', ["user" => $userAsupprimer, "bouton" => $bouton]);
} 

}
