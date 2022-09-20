<?php

namespace App\Controller;
use App\Form\UserType;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;



class GestionCompteController extends AbstractController
{
    

    /**
     * @Route("/gestion/getuser", name="gestion_compte")
     */
    public function index(httpClientInterface $httpclient)
    {
        $response = $httpclient->request('GET','https://localhost:5000/api/user');
        return $this->render('gestion_compte/Compte.html.twig', [
            'repos'=> $response->toArray(),
        ]);
    }

    /**
     * @Route("/gestion/geuserbyid/{id}", name="gestion_byiduser")
     */

    public function showbyid(httpClientInterface $httpclient,Request $request,$id): Response
    {

        $response = $httpclient->request('GET','https://localhost:5000/api/user/'.$id);
        
        $user=new User();
        $form=$this->createFormBuilder($user)
              ->add('Email')
              ->add('username')
              ->add('lastName')
              ->add('birthDate', BirthdayType::class)
              ->getForm()
        ;

        $form->handleRequest($request);
        if ($form->isSubmitted()&& $form->isValid()) {

            $data = $form->getData();
            $response = $httpclient->request(
                'PUT', 
                'https://localhost:5000/api/user/'.$id,[ 
                'headers' => ['Accept'=>'application/json','Content-Type' => 'application/json'],
                'json' => ['firstName' => $data->getUsername(),'lastName' => $data->getLastName(),'birthDate' => $data->getBirthDate()->format('Y-m-d'),'numberPhone' => $data->getNumberPhone(),'email' => $data->getEmail()]
                ]);
            $response->getContent();
            

            return $this->redirectToRoute('gestion_compte',[
                'id' => $id,
            ]);
        }

        return $this->render('gestion_compte/getbyiduser.html.twig', [
            'repos' => $response->toArray(),
            'form' => $form->createView(),
        ]);
    }

     /**
     * @Route("/compte_active/{id}", name="compte_active")
     */
    public function active(httpClientInterface $httpclient,$id): Response
    {
        
        $url='https://localhost:5000/api/onhold/'.$id;
        /*dd($url);*/
        
        $response = $httpclient->request('PUT',$url,[ 
                'headers' => ['Accept'=>'application/json','Content-Type' => 'application/json'],
                'json' => 'active'
                ]);
        $response->getContent();

        return $this->redirectToRoute('gestion_compte');
    }

    /**
     * @Route("/compte_onhold/{id}", name="compte_onhold")
     */
    public function onhold(httpClientInterface $httpclient,$id): Response
    {
        $response = $httpclient->request('PUT','https://localhost:5000/api/user/onhold/'.$id,[ 
                'headers' => ['Accept'=>'application/json','Content-Type' => 'application/json'],
                'json' =>'enattente'
                ]);
        $response->getContent();

        return $this->redirectToRoute('gestion_compte');
    }

    /**
     * @Route("/compte_banni/{id}", name="compte_banni")
     */
    public function banni(httpClientInterface $httpclient,$id): Response
    {
        $response = $httpclient->request('PUT','https://localhost:5000/api/user/onhold/'.$id,[ 
                'headers' => ['Accept'=>'application/json','Content-Type' => 'application/json'],
                'json' => 'banni'
                ]);
        $response->getContent();

        return $this->redirectToRoute('gestion_compte', [
                'id' => $id,
            ]);
    }
     
     /**
     * @Route("/compte_delete/{id}", name="compte_delete")
     */
    public function delete(httpClientInterface $httpclient,$id): Response
    {
        $response = $httpclient->request('DELETE','https://localhost:5000/api/user/'.$id);
        
        return $this->redirectToRoute('gestion_compte');
    }

    
    /**
    * @Route("/editget/{id}", name="put_compte",methods={"GET","POST"})
    */
    public function putuser(httpClientInterface $httpclient,Request $request,$id):Response
    {
        $response = $httpclient->request('GET','https://localhost:5000/api/user');
       
        $firstName = $request->query->get("firstName");
        $lastName = $request->query->get("lastName");
        $birthDate = $request->query->get("birthDate");
        $numberPhone = $request->query->get("numberPhone");
        $email = $request->query->get("email");
        $url=false;
        if('POST' === $request->getMethod() /*&& $form->isValid()*/){
        $url=true;
        }
        dd($url);

        
        $response = $httpclient->request(
                'PUT', 
                'https://localhost:5000/api/user/'.$id,[ 
                'headers' => ['Accept'=>'application/json','Content-Type' => 'application/json'],
                'json' => ['firstName' => $firstName,'lastName' => $lastName,'birthDate' => $birthDate ->format('Y-m-d'),'email' => $email,'numberPhone'=>$numberPhone]
                ]);

            $response->getContent();
            return $this->redirectToRoute('gestion_compte', [
                'id' => $id,
            ]);
        
        
         return $this->render('gestion_compte/Compte.html.twig', [
            'repos'=> $response->toArray(),
        ]);
    }



    /**
     * @Route("/gestion/gettest", name="gestion_test")
     */
    /*public function getuser1(httpClientInterface $httpclient,Request $request):Response
    {
        $compte = new User();
        $response = $httpclient->request('GET','https://localhost:5000/api/user');
        $form = $this->createForm(UserType::class,$compte);
        
        return $this->render('gestion_compte/test.html.twig', [
            'controller_name' => 'GestionCompteController',
            'repos'=> $response->toArray(),
            'form' => $form->createView(),
        ]);
    }*/

    /**
     * @Route("/gestion/postuser", name="post_compte",methods={"GET","POST"})
     */
   /* public function postuser(httpClientInterface $httpclient,Request $request):Response
    {
        $compte = new User();

        $form = $this->createForm(UserType::class,$compte);
        
        $form->handleRequest($request);

        if ($form->isSubmitted()&& $form->isValid()) {

            $data = $form->getData();

            $response = $httpclient->request(
                'POST', 
                'https://localhost:5000/api/user',[ 
                'headers' => ['Accept'=>'application/json','Content-Type' => 'application/json'],
                'json' => ['firstName' => $data->getFirstName(),'lastName' => $data->getLastName(),'birthDate' => $data->getBirthDate()->format('Y-m-d'),'numberPhone' => $data->getNumberPhone(),'email' => $data->getEmail(),'password' => $data->getPassword(),'role' =>$data->getRole()]
                ]);
            $response->getContent();
            

            return $this->redirectToRoute('gestion_compte');
        }

        return $this->render('gestion_compte/postuser.html.twig', [
            'controller_name' => 'GestionCompteController',
            'form' => $form->createView()
            ]);

    }*/
    
}



/*$response = $httpclient->request(
                'POST',
                'https://localhost:5001/api/user',
                [
                'headers' => ['Accept'=>'application/json','Content-Type' => 'application/json'],
                'body' => '{"firstName":" '.$data['firstName'].'","lastName":"" '.$data['lastName'].',"birthDate":"'.$data['birthDate']->format('Y-m-d').'","numberPhone":"'.$data['numberPhone'].'","email":"'.$data['numberPhone'].'","role":"'.$data['role'].'"}']);*/
          /*  $decodedPayload->send();*/


/*$res=$response->toArray();
        dd($res);*/
/*
        if ($request->isMethod('POST')){

        $firstName = $request->query->get("firstName");
        dd($request);
        $lastName = $request->query->get("lastName");
        $birthDate = $request->query->get("birthDate");
        $numberPhone = $request->query->get("numberPhone");
        $email = $request->query->get("email");
        $response = $httpclient->request(
                'PUT', 
                'https://localhost:5000/api/user/'.$id,[ 
                'headers' => ['Accept'=>'application/json','Content-Type' => 'application/json'],
                'json' => ['firstName' => $firstName,'lastName' => $lastName,'birthDate' => $birthDate ->format('Y-m-d'),'email' => $email,'numberPhone'=>$numberPhone]
                ]);

            $response->getContent();
            return $this->redirectToRoute('gestion_compte', [
                'id' => $id,
            ]);
        }*/