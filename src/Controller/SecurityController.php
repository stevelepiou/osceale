<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class SecurityController extends AbstractController
{   
    
    #[Route('/connexion', name: 'app_security', methods:['GET','POST'])]
    public function index(AuthenticationUtils $authenticationUtils): Response
    {
        

        return $this->render('pages/security/login.html.twig', [
            'last_username' => $authenticationUtils->getLastUsername(),
            'error' => $authenticationUtils->getLastAuthenticationError()
        ]);
    }

    #[Route('/deconnexion', 'security.logout' )]
    public function logout()
    {

    }

    #[Route('/inscription','security.registration', methods:['GET','POST'])]
    public function registration(Request $request,EntityManagerInterface $manager, UserPasswordHasherInterface $passwordHasher): Response
    {

        $user=new User();
        $user-> setRoles(['ROLE_USER']);
        $form = $this->createForm(RegistrationType::class , $user); 
            

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $user = $form->getData();


            // hash the password (based on the security.yaml config for the $user class)
            $hashedPassword = $passwordHasher->hashPassword(
                $user,
                $user->getPlainPassword()
            );
            $user->setPassword($hashedPassword);

            $this->addFlash(
                'success',
                'Votre compte a été créé.'
            );

            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('app_security');
        }

        return $this->render('pages/security/registration.html.twig',[
            'form'=>$form->createView()
        ]);
    }
}
