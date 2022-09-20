<?php

namespace App\Controller;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\ChoiceList\ChoiceListInterface;
use Symfony\Component\Form\Extension\Core\ChoiceList\ChoiceList;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType; 
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Appointement;
use App\Entity\User;
use App\Entity\Creneau;

class GestionCreneauController extends AbstractController
{
    /**
     * @Route("/gestion/creneau", name="gestion_creneau")
     */
    public function index()
    {
        return $this->render('gestion_creneau/index.html.twig', [
            'controller_name' => 'GestionCreneauController',
        ]);
    }


    /**
     * @Route("/gestion/rdvcrn", name="gestion_rdvcrn")
     */
    public function rdvcrn(httpClientInterface $httpclient,Request $request)
    {
        $response = $httpclient->request('GET','https://localhost:5000/api/solt');
        $response1 = $httpclient->request('GET','https://localhost:5000/api/user');
        $response2 = $httpclient->request('GET','https://localhost:5000/api/admin');

        $content1= $response1->toArray();
        $content = $response->toArray();
        $content2 = $response2->toArray();

        $rdv=new Appointement();
        $datenow = new \DateTime('now');
        $date=$datenow->format('Y-m-d H:i:s');
        $choices =[];
        foreach ($content as $solt) {
            $choices[$solt['durationStart']]=$solt['idSolt'];
        }
        $choices1 =[];
        foreach ($content1 as $user) {
            $choices1[$user['firstName']]=$user['id'];
        }
        $choices2 =[];
        foreach ($content2 as $admin) {
            $choices2[$admin['firstName']]=$admin['id'];
        }

        $etat="on hold";
        $form=$this->createFormBuilder($rdv)
              ->add('date_rdv', DateType::class)
              ->add('idCreneau',ChoiceType::class,['choices'=>$choices])
              ->add('idUser',ChoiceType::class,['choices'=>$choices1])
              ->add('idAdmin',ChoiceType::class,['choices'=>$choices2])
              ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted()&& $form->isValid()) {
            $data = $form->getData();

            
            $response3 = $httpclient->request(
                'POST', 
                'http://localhost:5001/Appointment',[ 
                'headers' => ['Accept'=>'application/json','Content-Type' => 'application/json'],
                'json' => ['idAdmin'=>$data->getIdAdmin(),'idUser' => $data->getIdUser(),'idSolt' => $data->getIdCreneau(),'appointmentDate'=>$data->getDateRdv()->format('Y-m-d'),'requestDate' => $date,'appointmentState' => $etat]
                ]);
            $response3->getContent();  

            return $this->redirectToRoute('gestion_rdvcrn');
        }

        return $this->render('gestion_creneau/rdvcrn.html.twig', [
          'form' => $form->createView()
        ]);
    }

}
