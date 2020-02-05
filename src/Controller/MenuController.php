<?php

namespace App\Controller;

use App\Entity\Groupe;
use App\Entity\Menu;
use App\Form\MenuType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Generator\UrlGenerator;


class MenuController extends AbstractController
{
    /**
     * @Route("/admin/menus", name="menus")
     */
    public function index()
    {

        $repository = $this->getDoctrine()->getRepository(Menu::class);
        $menus = $repository->findAll();

        return $this->render('menu/listing_menus.html.twig', [ 'page_name' => 'Menus', 'menus' => $menus]);
    }


    /**
     * @Route("/admin/menus/create", name="create_menu")
     */
    public function create(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $menu = new Menu();
        $form  = $this->createForm(MenuType::class, $menu, array(
            'entity_manager' => $entityManager,
        ));

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // On enregistre l'utilisateur dans la base

            $niveauPermission = 0;
            foreach ($menu->getGroupe() as $groupe) {
                if($niveauPermission < $groupe->getNiveau()){
                    $niveauPermission = $groupe->getNiveau();
                }
            }
            $menu->setNiveauPermission($niveauPermission);
            $em = $this->getDoctrine()->getManager();
            $admin_group = $em->getRepository(Groupe::class)->findOneByName('ADMIN');
            $menu->addGroupe($admin_group);
            $em->persist($menu);
            $em->flush();

            return $this->redirectToRoute('menus');
        }

        return $this->render('menu/create.html.twig', ['page_name' => 'Nouveau menu', 'form' => $form->createView()]);
    }

    /**
     * @Route("/admin/menus/edit/{menu_id}", name="edit_menu")
     */
    public function edit(Request $request, $menu_id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $menu = $this->getDoctrine()
            ->getRepository(Menu::class)
            ->find($menu_id);


        $form  = $this->createForm(MenuType::class, $menu, array(
            'entity_manager' => $entityManager,
        ));

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $niveauPermission = 0;
            foreach ($menu->getGroupe() as $groupe) {
                if(($niveauPermission < $groupe->getNiveau()) && ($groupe->getNiveau() != 100)){
                    $niveauPermission = $groupe->getNiveau();
                }
            }
            $menu->setNiveauPermission($niveauPermission);
            // On enregistre l'utilisateur dans la base
            $em = $this->getDoctrine()->getManager();
            $em->persist($menu);
            $em->flush();

            return $this->redirectToRoute('menus');
        }

        return $this->render('menu/edit.html.twig', ['page_name' => 'Modifier un menu', 'form' => $form->createView()]);
    }

    /**
     * @Route("/admin/menus/delete/{menu_id}", name="delete_menu")
     */
    public function delete(Request $request, $menu_id)
    {
        $menu = $this->getDoctrine()
            ->getRepository(Menu::class)
            ->find($menu_id);

        if($menu->getParent()) {
            $old_parent = $this->getDoctrine()
                ->getRepository(Menu::class)
                ->findOneById($menu->getParent());
            $old_parent->removeChild($menu);
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($menu);
        $em->flush();

        return $this->redirectToRoute('menus');
    }

    /**
     * @Route("/admin/menus/check/{menu_id}/{route_name}", name="check_route", condition="request.isXmlHttpRequest()")
     */
    public function check(Request $request, $route_name, $menu_id)
    {
        $menu = $this->getDoctrine()
            ->getRepository(Menu::class)
            ->find($menu_id);
        $em = $this->getDoctrine()->getManager();
        $router = $this->container->get('router');
        $routes = $router->getRouteCollection();

        if ($routes->get($route_name)){
            $menu->setIsRouteValid(true);
            $em->persist($menu);
            $em->flush();
            return new JsonResponse(array(
                'menuId'    =>  $menu_id,
                'icon'       =>  'm--font-success la la-check',
                'msg'       =>  '<span class="m--font-success">Route valide</span>'
            ));
        }else{
            $menu->setIsRouteValid(false);
            $em->persist($menu);
            $em->flush();
            return new JsonResponse(array(
                'menuId'   => $menu_id,
                'icon'      => 'm--font-danger la la-close',
                'msg'       =>  '<span class="m--font-danger">Route non valide</span>'
            ));
        }
    }


    public function menu(RequestStack $requestStack)
    {
        /*
         * Récupération de la route à partir du controller parent
         */
        $request = $requestStack->getMasterRequest();
        $currentRoute = $request->get('_route');

        $menus = $this->getDoctrine()
            ->getRepository(Menu::class)
            ->findBy(
                ['parent' => null],
                ['position' => 'ASC', 'id' => 'ASC']
            );

        $user_groupe = $this->getDoctrine()
            ->getRepository(Groupe::class)
            ->findOneById($this->getUser()->getGroupe());
        return $this->render('menu/menu.html.twig', ['menus' => $menus, 'user_groupe' => $user_groupe, 'current_route' => $currentRoute, 'request' => $request]);
    }

    /**
     * @Route("/admin/menus/children/{menu_id}", name="menu_children")
     */
    public function show_children(Request $request, $menu_id)
    {
        $menu = $this->getDoctrine()
            ->getRepository(Menu::class)
            ->find($menu_id);
        $children = $menu->getChildren();
        $groupes = $menu->getGroupe();

        return $this->render('menu/children.html.twig', ['page_name'=> 'Affichage des enfants','menu' => $menu, 'children' => $children, 'groupes' => $groupes]);
    }



}
