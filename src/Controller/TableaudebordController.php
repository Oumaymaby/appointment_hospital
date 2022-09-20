<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TableaudebordController extends AbstractController
{
    /**
     * @Route("/tableaudebord", name="tableaudebord")
     */
    public function index()
    {
        return $this->render('tableaudebord/index.html.twig', [
            'controller_name' => 'TableaudebordController',
        ]);
    }
}
