<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RendezvousController extends AbstractController
{
    /**
     * @Route("/gestion/rendezvous", name="rendezvous")
     */
    public function index(httpClientInterface $httpclient)
    {
        $response = $httpclient->request('GET','https://localhost:5000/api/Appointment');
        
        return $this->render('rendezvous/rdv.html.twig', [
            'repos'=> $response->toArray(),
        ]);
    }
}
