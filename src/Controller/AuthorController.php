<?php

namespace App\Controller;

use App\Repository\AuthorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AuthorController extends AbstractController
{
    public $authors = array( 

        array('id' => 1, 'picture' => '/images/Victor-Hugo.jpg','username' => 'Victor Hugo', 'email' => 'victor.hugo@gmail.com ', 'nb_books' => 100), 
        
        array('id' => 2, 'picture' => '/images/william-shakespeare.jpg','username' => ' William Shakespeare', 'email' =>  ' william.shakespeare@gmail.com', 'nb_books' => 200 ), 
        
        array('id' => 3, 'picture' => '/images/Taha_Hussein.jpg','username' => 'Taha Hussein', 'email' => 'taha.hussein@gmail.com', 'nb_books' => 300), 
        
        ); 
    #[Route('/author', name: 'app_author')]
    public function index(): Response
    {
        return $this->render('author/index.html.twig', [
            'controller_name' => 'AuthorController',
        ]);
    }

    #[Route('/author/name/{name}', name:'app_author_name')]
    public function showAuthor($name){
        return $this->render('author/show.html.twig',[
            'n' => $name
        ]);
    }

    #[Route('/author/list', name:'app_author_list')]
    public function listAuthor(AuthorRepository $aR){ 
        $authors = $aR->findAll();
        dd($authors);
        return $this->render('author/list.html.twig',[
            'authors' => $this->authors
        ]);
    }

    #[Route('/author/details/{id}', name: 'app_author_details')]
    public function details($id){
        $author= null;
        foreach ($this->authors as  $authorr) {
            //dd($author['id']);
            if($id == $authorr['id']){
                $author = $authorr;
            }
        }
        //dd($author);
        return $this->render('author/details.html.twig',[
            'author' => $author
        ]);
    }
}
