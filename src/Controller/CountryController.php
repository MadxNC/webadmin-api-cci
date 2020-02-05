<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CountryController extends AbstractController
{
    /**
     * @Route("/country", name="country")
     */
    public function index()
    {

        $em = $this->getDoctrine()->getManager();

        $RAW_QUERY = "SELECT * FROM dataco2 ORDER BY year2014 DESC";
        
        $statement = $em->getConnection()->prepare($RAW_QUERY);
        $statement->execute();

        $result = $statement->fetchAll();

        dd($result);

        return $this->render('country/index.html.twig', [
            'controller_name' => 'CountryController',
            'page_name' => 'Les pays',
            'countrys' => $result,
        ]);
    }
}
