<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    #[Route('/registration', name: 'user_registration')]
    public function register(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = new User();
        $userForm = $this->createForm(RegistrationFormType::class, $user);
        $userForm->handleRequest($request);
        if($userForm->isSubmitted() && $userForm->isValid()){
            $hashed = $passwordHasher->hashPassword($user, $user->getPassword());
            // $user->setRoles(array('ROLE_ADMIN'));
            $user->setPassword($hashed);
            $em->persist($user);
            $em->flush();
            $this->addFlash('success', 'Votre compte a bien été crée');
            return $this->redirectToRoute("admin_list");
        }

        return $this->render('registration/register.html.twig', [
            'userForm' => $userForm->createView(),
        ]);
    }
}
