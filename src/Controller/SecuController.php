<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Form\UserType;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecuController extends AbstractController
{
    /**
     * @Route("/inscription", name="security_registration")
     */
    public function registration(httpClientInterface $httpclient,Request $request,UserPasswordEncoderInterface $encoder)
    {
    	$user=new User();
         $form=$this->createFormBuilder($user)
              ->add('Email')
              ->add('password',PasswordType::class)
              ->add('confirm_password',PasswordType::class)
              ->add('username')
              ->add('lastName')
              ->add('numberPhone')
              ->add('birthDate', BirthdayType::class)
              ->getForm()
        ;

        $form->handleRequest($request);
        if ($form->isSubmitted()&& $form->isValid()) {
            $hash=$encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);

            $data = $form->getData();
            
            $user->setPassword($hash);
            $state='enattente';
            $response = $httpclient->request(
                'POST', 
                'https://localhost:5000/api/user',[ 
                'headers' => ['Accept'=>'application/json','Content-Type' => 'application/json'],
                'json' => ['userState'=>$state,'firstName' => $data->getUsername(),'lastName' => $data->getLastName(),'birthDate' => $data->getBirthDate()->format('Y-m-d'),'numberPhone' => $data->getNumberPhone(),'email' => $data->getEmail(),'password' => $data->getPassword()]
                ]);
            $response->getContent();
            

            return $this->redirectToRoute('security_registration');
        }

        return $this->render('secu/registration.html.twig',[
        	'form' => $form->createView()
        ]);
    }

   
}
