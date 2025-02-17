<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    

    #[Route('/home/welcome/{nom}' , name:'app_home_welcome')]
    public function welcome($nom){
        return new Response('Bonjouur! '. $nom);
    }

    #[Route('/bonjour/{prenom}', name:'app_home_bonjour')]
    public function bonjour($prenom): Response{
        return $this->render('home/bonjour.html.twig',[
            'p' => $prenom
        ]);
    }

    #[Route('/hello/nom/{nom}/age/{age}', name:'app_home_hello')]
    public function hello($nom, $age){
        $arr = ["Hello", "1CINFO1"];
        $x= 55;
        //dd($arr);
        
        return $this->render('home/hello.html.twig',[
            'nom' => $nom,
            'ag' => $age,
            't' => $arr
        ]);
    }

    #[Route('/home', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'classroom' => "1CINFO1"
        ]);
    }


    #[Route('/redirect', name:'app_home_redirect')]
    public function redirectToHome(){
        return $this->redirectToRoute('app_home');
    }
}
