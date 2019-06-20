<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\EditType;

use App\Form\RegistrationType;

use App\Form\ResetPasswordType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/registration", name="security_registration")
     */
    public function registration(Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder)
    {
        $user = new User();
        
        $form = $this->createForm(RegistrationType::class, $user); // Champs du formulaire binder (relier) avec ceux de l'utilisateur

        $form->handleRequest($request); // Analyse la requête HTTP

        if($form->isSubmitted() && $form->isValid()) {

            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);
            $user->setRoles(['ROLE_USER']);

            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('security_login');
        }

        return $this->render('security/registration.html.twig' ,[
            'formRegister' => $form->createView()
        ]);
    }

    /**
     * @Route("/login", name="security_login", methods="GET|POST")
     */
    public function login(AuthenticationUtils $authenticationUtils)
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error,
        ]);
    }

    /**
     * @Route("/logout", name="security_logout")
     */
    public function logout() {} 

    /**
     * @Route("/admin/settings", name="security_settings")
     * @Route("/admin/user/{id}/edit", name="security_edit", requirements={"id"="\d+"})
     *
     * @param UserInterface $user
     * @param Request $request
     * @param ObjectManager $manager
     * @param UserPasswordEncoderInterface $encoder
     * @return void
     */
    public function editUser(UserInterface $user, Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder){

        $form = $this->createForm(EditType::class, $user);

        $form->handleRequest($request); // Analyse la requête HTTP

        if($form->isSubmitted() && $form->isValid()) {
            
            $manager->persist($user);
            $manager->flush();
            $this->addFlash('success', 'Les modifications ont bien été enregistré');

            return $this->redirectToRoute('security_settings');
        }

        $formResetPassword = $this->createForm(ResetPasswordType::class, $user);

        $formResetPassword->handleRequest($request);

        if($formResetPassword->isSubmitted() && $formResetPassword->isValid()) {
            
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);

            $manager->persist($user);
            $manager->flush();
            $this->addFlash('success', 'Le mot de passe a bien été modifié');

            return $this->redirectToRoute('security_settings');
        }

        return $this->render('security/settings.html.twig', [
            'formEdit' => $form->createView(),
            'formResetPassword' => $formResetPassword->createView()
        ]);
    }
}
