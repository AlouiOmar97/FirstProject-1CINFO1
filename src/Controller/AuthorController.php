<?php

namespace App\Controller;

use App\Entity\Author;
use App\Repository\AuthorRepository;
use Doctrine\ORM\EntityManagerInterface;
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
    public function listAuthor(AuthorRepository $authorRepository){ 
        $authorsDB= $authorRepository->findAll();
        return $this->render('author/list.html.twig',[
            'authors' => $authorsDB
        ]);
    }

    #[Route('/author/add/{us}', name:'app_author_add')]
    public function addAuthor(EntityManagerInterface $em, $us){
        $author = new Author();
        $author->setUsername($us);
        $author->setEmail('abc@gmail.com');
        $author->setPicture('/images/Victor-Hugo.jpg');
        $author->setNbBooks(250);
        $em->persist($author);
        $em->flush();
        dump("Ajout d'un nouvel auteur !");
        dump($author);
        die();
        //dd($author);

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
