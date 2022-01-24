<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'login')]
    public function index(AuthenticationUtils $authenticationUtils): Response
    {
        $erreur = $authenticationUtils->getLastAuthenticationError();
        $lastEmail = $authenticationUtils->getLastUsername();

        return $this->render('login/formLogin.html.twig', [
            'lastEmail' => $lastEmail,
            'erreur'         => $erreur,

        ]);
    }

    #[Route('/logout', name: 'deconnexion')]
    public function logout()
    {

    }

    #[Route('/user/new', name: 'user.new')]
    public function new(Request $request, UserPasswordHasherInterface $hasher, EntityManagerInterface $em) : Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            dump($user);
            $post = $request->get('user');
            dump($post);
            $user->addRole($post['role']);
            //$user->setRoles($post['role']);
            dump($user);
            $psw = $hasher->hashPassword($user, $post['password']);
            $user->setPassword($psw);
            dump($user);
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('user.new');

        }

        return $this->renderForm('login/formNew.html.twig', [
            'formNew' => $form,
        ]);

    }

    
        #[Route('/user/list', name : 'user.list')]
        public function list(UserRepository $repUser) : Response
        {

            $users = $repUser->findAll();
            return $this->render('login/list.html.twig', [
                'users' => $users,
            ]);


        }

    //     #[Route('user/{id}/edit', name: 'user.edit', methods: ['GET', 'POST'])]
    // public function edit(Request $request, User $user, EntityManagerInterface $entityManager): Response
    // {
    //     $form = $this->createForm(UserType::class, $user);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $entityManager->flush();

    //         return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->renderForm('login/formNew.html.twig', [
    //         'formNew' => $form,
    //     ]);
    // }

    #[Route('user/{id}/edit', name: 'user.edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {

        if ($request->getMethod() === 'POST') {
           $email = $request->get('email');
           
            if ($email !== $user->getEmail()) {
               $user->setEmail($email);
               $entityManager->flush();
               
            }
            return $this->redirectToRoute('user.list');
        }


        return $this->renderForm('login/formEdit.html.twig', [
            'user' => $user,
        ]);
    }


}
