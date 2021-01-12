<?php

namespace App\Controller;


use App\Entity\PasswordUpdate;
use App\Entity\User;
use App\Form\AccountType;
use App\Form\RegistrationType;

use App\Form\PasswordUpdateType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AccountController extends AbstractController
{
    /**
     * permet d'afficher et de gerer le formulaire de connexion
     */
    /**
     * @Route("/connexion", name="account_connexion")
     */
    public function connexion( AuthenticationUtils  $utils): Response
    {
        $error= $utils->getLastAuthenticationError();
        $username= $utils->getLastUsername();
        return $this->render('account/connexion.html.twig', [
            'controller_name' => 'AccountController',
            'hasError'=>$error!==null,
            'username'=>$username,
        ]);
    }
    /**
     * permet de se deconnecter
     */
    /**
     * @Route("/logout", name="account_logout")
     */
    public function logout()
    {
        // rien juste pour se deconnecter
    }

    /**
     * permet d'afficher le formulaire d'inscription

     */
    /**
     * @Route("/register", name="account_register")
     */
    public function register(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder)
    {
$user = new user();
$form= $this->createForm(RegistrationType::class, $user);
$form->handleRequest($request);
if($form->isSubmitted()&& $form->isValid()){
    $hash= $encoder->encodePassword($user, $user->getHash());

    $user->setHash($hash);

    $manager->persist($user);
    $manager->flush();
    $this->addFlash('success', "votre compte à été bien enregistré!vous pouvez maintenant se connecter!");
    return $this->redirectToRoute('account_connexion');
}



return $this->render('account/registration.html.twig',[
    'form'=>$form-> createView()]
 );

    }
    /**
     * afficher un formulaire qui permet de modifier le profil de l'utilisateur
     */
    /**
     * @Route("/profile", name="account_profile")
     * @IsGranted ("ROLE_USER")
     */
    public function profile(Request $request,EntityManagerInterface $manager)
    {$user= $this->getUser();

        $form= $this->createForm(AccountType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted()&& $form->isValid())
        {$manager->persist($user);
        $manager->flush();
        $this->addFlash('success',"les données du profil ont été enregistrées avec succès!");

        }

        return $this->render('account/profile.html.twig',[
            'form'=>$form->createView()
        ]);
    }
    /**
     * afficher le formulaire qui permet de modifier le mot de passe de l'utilisateur
     */
    /**
     *@Route("/updatepass", name="account_updatepass")
     * @IsGranted("ROLE_USER")
     */

    public function updatepass(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder)
    {
        $passwordUpdate = new PasswordUpdate();
        $user=$this->getUser();
        $form= $this->createForm(PasswordUpdateType::class, $passwordUpdate);
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid())

        { // verifier si l'ancien mdp correspond au mdp de l'utilisateur
 //if(!$encoder->isPasswordValid($user, $passwordUpdate->getOldPassword())){
            if(!password_verify($passwordUpdate->getOldPassword(),$user->getHash())) {

                // gerer l 'erreur
                $form->get('oldpassword')->addError(new FormError("votre mdp n est pas l mdp actuel!"));

            }else{

                $newPassword= $passwordUpdate->getNewPassword();
                $hash= $encoder->encodePassword($user ,$newPassword);
                $user->setHash($hash);

            }

            $manager->persist($user);
            $manager->flush();
            $this->addFlash('success',"votre mdp a été bien modifie");
            return $this->redirectToRoute("blog");
        }
       return $this->render('account/updatepass.html.twig',[
           'form'=>$form->createView()
       ]) ;
    }

    /**
     * permet d'afficher mon propre compte d'utilisateur( le profil d'utilisateur connecté)
     */
    /**
     * @Route("/account", name="account_index")
     * @IsGranted("ROLE_USER")
     */
    public function myAccount()
    {
return $this->render('user/index1.html.twig', [
   'user'=>$this->getUser()
]);
    }
}
