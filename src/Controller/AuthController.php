<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AuthController extends AbstractController
{
    #[Route('/authin', name: 'authin')]
    public function authIn(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUserName = $authenticationUtils->getLastUsername();
        return $this->render('auth/authentification.html.twig', [
            'error' => $error,
            'last_username'=> $lastUserName
        ]);
    }

    #[Route('/authout', name: 'authout')]
    public function authOut(): void
    {
        // changer response à void, symfony fait le reste

    }
}
