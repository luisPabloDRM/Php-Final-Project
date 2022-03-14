<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
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

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }


    #[Route(path: '/create/user')]
    public function createUser(EntityManagerInterface $doctrine, UserPasswordHasherInterface $hasher)
    {
        $user = new User();
        $user->setUsername('admin');
        $user->setPassword($hasher->hashPassword($user, '1234'));
        $user->setRoles(['ROLE_USER', 'ROLE_ADMIN']);

        $user2 = new User();
        $user2->setUsername('Luispa');
        $user2->setPassword($hasher->hashPassword($user, '1234'));
        $user2->setRoles(['ROLE_USER']);

        $doctrine->persist($user);
        $doctrine->persist($user2);
        $doctrine->flush();
    }

}
