<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Groupe;
use App\Form\UserType;
use App\Form\UserEditType;
use App\Form\UserChangePasswordType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class UserController extends AbstractController
{
    /**
     * @Route("/admin/users", name="users")
     */
    public function index()
    {

        $repository = $this->getDoctrine()->getRepository(User::class);
        $users = $repository->findAll();

        $count_admin = $this->getDoctrine()->getManager()->createQuery(
            'SELECT a 
            FROM App\Entity\User a
            WHERE a.groupe = 1'
        )->execute();

        return $this->render('user/listing_users.html.twig', [ 'page_name' => 'Utilisateurs', 'users' => $users, 'count_admin' => $count_admin]);
    }

    /**
     * @Route("/admin/users/new", name="user_create")
     */
    public function create(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $user = new User();
        $form = $this->createForm(UserType::class, $user, array(
            'entity_manager' => $entityManager,
        ));

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $password = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);

            $groupe = $this->getDoctrine()
                ->getRepository(Groupe::class)
                ->findOneByRole($user->getRoles()[0]);

            $user->setGroupe($groupe);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('users');
        }

        return $this->render('user/create.html.twig', [ 'page_name' => 'Nouvel utilisateur', 'form' => $form->createView()]);
    }

    /**
     * @Route("/admin/users/edit/{user_id}", name="user_edit")
     */
    public function edit(Request $request, UserPasswordEncoderInterface $passwordEncoder, $user_id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($user_id);

        $form = $this->createForm(UserEditType::class, $user, array(
            'entity_manager' => $entityManager,
        ));

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $password = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);

            $groupe = $this->getDoctrine()
                ->getRepository(Groupe::class)
                ->findOneByRole($user->getRoles()[0]);

            if ($user->getGroupe() != $groupe) {
                $user->setGroupe($groupe);
            }
            // On enregistre l'utilisateur dans la base
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('users');
        }

        return $this->render('user/edit.html.twig', [ 'page_name' => 'Modifier un utilisateur', 'form' => $form->createView(), 'user' => $user]);
    }

    /**
     * @Route("/admin/users/delete/{user_id}", name="user_delete")
     */
    public function delete($user_id)
    {

        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($user_id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();

        return $this->redirectToRoute('users');
    }

    /**
     * @Route("/admin/users/change_password/{user_id}", name="user_change_password")
     */
    public function changePassword(Request $request, $user_id, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($user_id);

        $form = $this->createForm(UserChangePasswordType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $password = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);

            // On enregistre l'utilisateur dans la base
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('users');
        }

        return $this->render('user/change_password.html.twig', [ 'page_name' => 'Changer le mot de passe', 'form' => $form->createView(), 'user' => $user]);
    }
}
