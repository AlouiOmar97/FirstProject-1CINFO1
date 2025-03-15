<?php

namespace App\Controller;

use App\Entity\Author;
use App\Form\AddEditAuthorType;
use App\Repository\AuthorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/author/add', name:'app_author_add')]
    public function addAuthor(EntityManagerInterface $em, Request $request){
        $author=new Author();
        //$author->setEmail('default Email');
        $form= $this->createForm(AddEditAuthorType::class, $author);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $em->persist($author);
            $em->flush();
            return $this->redirectToRoute('app_author_list');
        }
        return $this->render('author/form.html.twig',[
            'title' => 'Add Author',
            'authorForm' => $form
        ]);
    }

    #[Route('/author/update/{id}', name:'app_author_update')]
    public function updateAuthor($id, AuthorRepository $authorRepository, EntityManagerInterface $em, Request $request){
        $author= $authorRepository->find($id);
        $form= $this->createForm(AddEditAuthorType::class, $author);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $em->flush();
            return $this->redirectToRoute('app_author_list');
        }
        return $this->render('author/form.html.twig',[
            'title' => 'Update Author',
            'authorForm' => $form
        ]);
    }

    #[Route('/author/add/{us}', name:'app_author_add_us')]
    public function addAuthorByUs(EntityManagerInterface $em, $us){
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

    #[Route('/author/edit/{id}', name:'app_author_edit')]
    public function editAuthor($id, AuthorRepository $authorRepository, EntityManagerInterface $em){
        $author= $authorRepository->find($id);
        $author->setEmail('updatedEmail2@gmail.com');
        $author->setNbBooks(123);
        $em->flush();
        dd($author);
    }

    #[Route('/author/delete/{id}', name:'app_author_delete')]
    public function deleteAuthor($id, AuthorRepository $authorRepository, EntityManagerInterface $em){
        $author= $authorRepository->find($id);
        $em->remove($author);
        $em->flush();
    }

    #[Route('/author/search/{email}', name:'app_author_search')]
    public function searchAuthor($email, AuthorRepository $authorRepository){
        //$author= $authorRepository->findOneByEmail($email);
        //$author= $authorRepository->findOneByNbBooks(650);
        //$author= $authorRepository->findOneByUsername('Salma');
        //dd($author);
        $authors= $authorRepository->findByEmail($email);
        dd($authors);
    }
    

    #[Route('/author/details/{id}', name: 'app_author_details')]
    public function details($id, AuthorRepository $authorRepository){
        /*
        $author= null;
        foreach ($this->authors as  $authorr) {
            //dd($author['id']);
            if($id == $authorr['id']){
                $author = $authorr;
            }
        }*/
        //dd($author);
        $author= $authorRepository->find($id);
        return $this->render('author/details.html.twig',[
            'author' => $author
        ]);
    }

    #[Route('/author/search/email/{email}', name:'app_author_search_email')]
    public function searchByEmail($email, AuthorRepository $authorRepository){
        $authors= $authorRepository->findAuthorByEmail($email);
        dd($authors);
    }

}
