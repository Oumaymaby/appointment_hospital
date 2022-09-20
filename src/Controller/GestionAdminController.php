<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use App\Entity\Admin;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
/*use Symfony\HttpClientContracts\HttpClientInterface;*/
/*use Symfony\Component\HttpClient\CurlHttpClient;
use Symfony\Component\HttpClient\NativeHttpClient;*/

class GestionAdminController extends AbstractController
{
    /**
     * @Route("/gestion/admin", name="gestion_admin")
     */
    public function index(httpClientInterface $httpclient)
    {

        $response = $httpclient->request('GET','https://localhost:5000/api/admin');
  /*      $response1 = $httpclient->request('GET','https://localhost:5000/api/admin/'.$id);*/
        
        return $this->render('gestion_admin/admin.html.twig', [
            'controller_name' => 'GestionAdminController',
            'repos'=> $response->toArray(),/*
            'repo'=> $response->toArray(),*/
        ]);
    }


    
   /* public function show(httpClientInterface $httpclient,$id): Response
    {
        $response = $httpclient->request('GET','https://localhost:5000/api/admin/'.$id);

        return $this->render('gestion_admin/show.html.twig', [
            'repo' => $response->toArray(),
        ]);
    }*/

    /**
     * @Route("/delete/{id}", name="admin_delete")
     */
    public function delete(httpClientInterface $httpclient,$id): Response
    {
        /*var_dump('https://localhost:5000/api/Admin/'.$id);
        exit();*/
        /*$admin = new Admin();*/
        $response = $httpclient->request('DELETE','https://localhost:5000/api/Admin/'.$id);
        
        return $this->redirectToRoute('gestion_admin');
    }



    

     
}
