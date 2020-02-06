<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{
    /**
     * @Route("/", name="index")
     */
    public function index(Request $request)
    {
        $year = null;
        $limit = null;
        $result = null;

        if (isset($_GET['year'])) {
            $year = $_GET['year'];
        }

        if (isset($_GET['length'])) {
            $limit = $_GET['length'];
        }

        if (isset($_GET['length']) && isset($_GET['year'])) {
            $api = 'http://localhost:3000/api/data?key=u9zDkZNhfHrqF8ra8pkqZgGwJfXcZJR4cBDALR2Qr7EpXMaSA8krbpRRq2WUydVC&year='.$year.'&limit='.$limit;
            $result = json_decode(file_get_contents($api));
        }

        
        // dd($result);

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_REMEMBERED');
        return $this->render('home/index.html.twig', array(
            'page_name' => "Accueil",
            'datas' => $result,
            'year' => $year,
            'limit' => $limit
            
        ));
    }

    /**
     * @Route("/admin", name="admin")
     */
    public function admin()
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_REMEMBERED');
        return $this->render('admin/index.html.twig', array('page_name' => "Administration"));
    }

}
