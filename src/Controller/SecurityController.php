<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{


    /**
     * @Route("/api/login_token", name="security_login_token", methods={"POST"})
     */
    public function login_token()
    {
    }

    /**
     * @Route("/logout", name="admin_security_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    /**
     * @Route("/", name="admin_security_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response


    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }



    /**
     * @Route("/login_success", name="login_success")
     */
    public function postLoginRedirectAction()
    {

        return $this->redirectToRoute("admin_index");
    }
}
