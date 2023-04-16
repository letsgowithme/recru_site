<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route('/connexion', name: 'security.login', methods: ['GET', 'POST'])]
    public function login(AuthenticationUtils $authenticationUtils): Response
    { 
        /**
        * This controller allows us to login
        *
        * @param AuthenticationUtils $authenticationUtils
        * @return Response
        */
   

        return $this->render('security/login.html.twig', [
            'last_username' => $authenticationUtils->getLastUsername(),
            'error' => $authenticationUtils->getLastAuthenticationError()
        ]);
    }

     /**
     * This controller allows us to logout
     *
     * @return void
     */

    #[Route('/deconnexion', name: 'app_logout')]
    public function logout() {
        // Nothing to do here
    }

}
