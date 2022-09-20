<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class GestionParametreController extends AbstractController
{
    /**
     * @Route("/gestion/parametre", name="gestion_parametre")
     */
    public function index(httpClientInterface $httpclient)
    {
        $response = $httpclient->request('GET','https://localhost:5000/api/initial');
        $response1 = $httpclient->request('GET','https://localhost:5000/api/Modification');
        return $this->render('gestion_parametre/param.html.twig', [
            'controller_name' => 'GestionParametreController',
            'repos'=> $response->toArray(),
            'respos'=> $response1->toArray(),

        ]);
    }

    /**
     * @Route("/gestion/parametre/{date}", name="gestion_parametredate")
     */
    public function getbyidsetting(httpClientInterface $httpclient,$date)
    {
        $response3 = $httpclient->request('GET','http://localhost:5001/Setting/'.$date);
        return $this->render('gestion_parametre/show.html.twig', [
            'pos'=> $response3->toArray(),

        ]);
    }

}
