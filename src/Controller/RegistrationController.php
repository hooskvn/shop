<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    /* public function index(UserPasswordHasherInterface $passwordHasher)
    {
        // ... e.g. get the user data from a registration form
        $user = new User(...);
        $plaintextPassword = ...;

        // hash the password (based on the security.yaml config for the $user class)
        $hashedPassword = $passwordHasher->hashPassword(
            $user,
            $plaintextPassword
        );
        $user->setPassword($hashedPassword);

        // ...
    } */

    #[Route('/user/add', name: 'create_user', methods: 'POST')]
    public function createUser(
        UserRepository $userRepository,
        UserPasswordHasherInterface $passwordHasher,
        Request $request
    ): Response
    {
        $data = json_decode($request->getContent(), true);

        $user = new User();
        $user->setEmail($data['email']);
        $user->setRoles($data['role']);
        $hashedPassword = $passwordHasher->hashPassword(
            $user, # error : given User type or must be PasswordAuthenticatedUserInterface type
            $data['password']
        );
        $user->setPassword($hashedPassword);

        $userRepository->add($user, true);

        return new Response(
            sprintf(
                'Saved new user with id #%s',
                $user->getId()
            ),
            Response::HTTP_OK
        );
    }
}