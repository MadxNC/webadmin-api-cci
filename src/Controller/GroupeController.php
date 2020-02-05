<?php

namespace App\Controller;

use App\Entity\Groupe;
use App\Form\GroupeType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class GroupeController extends AbstractController
{
    /**
     * @Route("/admin/groups", name="groups")
     */
    public function index()
    {
        $repository = $this->getDoctrine()->getRepository(Groupe::class);
        $groups = $repository->findAll();

        return $this->render('groupe/listing_groupes.html.twig', [ 'page_name' => 'Groupes', 'groups' => $groups]);
    }

    /**
     * @Route("/admin/groups/new", name="create_groupe")
     */
    public function create(Request $request){
        $groupe = new Groupe();
        $form = $this->createForm(GroupeType::class, $groupe);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($groupe);
            $em->flush();

            return $this->redirectToRoute('groups');
        }

        return $this->render('groupe/create.html.twig', [ 'page_name' => 'Nouveau groupe', 'form' => $form->createView()]);
    }

    /**
     * @Route("/admin/groups/edit/{group_id}", name="edit_groupe")
     */
    public function edit(Request $request, $group_id){
        $groupe = $this->getDoctrine()
            ->getRepository(Groupe::class)
            ->find($group_id);

        $form = $this->createForm(GroupeType::class, $groupe);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {


            // On enregistre l'utilisateur dans la base
            $em = $this->getDoctrine()->getManager();
            $em->persist($groupe);
            $em->flush();

            return $this->redirectToRoute('groups');
        }

        return $this->render('groupe/edit.html.twig', [ 'page_name' => 'Modifier un groupe', 'form' => $form->createView() ]);
    }

    /**
     * @Route("/admin/groups/delete/{group_id}", name="delete_groupe")
     */
    public function delete(Request $request, $group_id) {

        $groupe = $this->getDoctrine()
            ->getRepository(Groupe::class)
            ->find($group_id);

        $groupe_user = $this->getDoctrine()
            ->getRepository(Groupe::class)
            ->findOneByRole('ROLE_USER');

        foreach ($groupe->getUsers() as $user) {
            $user->setGroupe($groupe_user);
            $user->setRoles(array($groupe_user->getRole()));
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($groupe);
        $em->flush();

        return $this->redirectToRoute('groups');
    }


    /**
     * @Route("/admin/groups/{group_id}/members", name="groupe_members", condition="request.isXmlHttpRequest()")
     */
    public function groupe_members(Request $request, $group_id) {

        $groupe = $this->getDoctrine()
            ->getRepository(Groupe::class)
            ->find($group_id);

        $members = $groupe->getUsers();

        return $this->render('groupe/members_list.html.twig', array(
            'members' => $members
        ));

    }
}

