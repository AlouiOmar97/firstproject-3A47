<?php

namespace App\Controller;

use App\Entity\Author;
use App\Form\AddEditAuthorType;
use App\Repository\AuthorRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AuthorController extends AbstractController
{
    public $authors = array(
        array('id' => 1, 'picture' => '/images/Victor-Hugo.jpg','username' => 'Victor Hugo', 'email' =>
        'victor.hugo@gmail.com ', 'nb_books' => 100),
        array('id' => 2, 'picture' => '/images/william-shakespeare.jpg','username' => ' William Shakespeare', 'email' =>
        ' william.shakespeare@gmail.com', 'nb_books' => 200 ),
        array('id' => 3, 'picture' => '/images/Taha_Hussein.jpg','username' => 'Taha Hussein', 'email' =>
        'taha.hussein@gmail.com', 'nb_books' => 300),
        );
    #[Route('/author', name: 'app_author')]
    public function index(): Response
    {
        return $this->render('author/index.html.twig', [
            'controller_name' => 'AuthorController',
        ]);
    }

    #[Route('/author/list', name: 'app_author_list')]
    public function list(AuthorRepository $authorRepository): Response
    {   
        $authorsDB = $authorRepository->findAll();
        return $this->render('author/list.html.twig', [
            'authors' => $authorsDB,
        ]);
    }

    #[Route('/author/details/{id}', name: 'app_author_details')]
    public function details($id, AuthorRepository $authorRepository): Response{
        /*$author= null;
        foreach ($this->authors as $a) {
            if($a['id'] == $id){
                $author = $a;
                break;
            }
        }*/
        $author = $authorRepository->find($id);
        return $this->render('author/details.html.twig', [
            "author" => $author,
            "title" => "Author Details",
        ]);
    }

    #[Route("/author/search/{username}", name:"app_author_search")]
    public function searchAuthor($username, AuthorRepository $authorRepository){
        $author = $authorRepository->findOneByUsername($username);
        //dd($author);
        return $this->render('author/details.html.twig', [
            "author" => $author,
            "title"=> "Search Author",
        ]);
    }

    #[Route('/author/add/{email}', name: 'app_author_add')]
    public function addAuthor(Request $request,$email, EntityManagerInterface $em){
        $author = new Author();
        //$author->setEmail($request->get('email'));
        $author->setUsername('Albert Camus');
        $author->setEmail($email);
        $author->setPicture('test.png');
        $author->setNbBooks(50);
        $em->persist($author);
        $em->flush();
        dd($author);
    }

    #[Route('/author/create', name:'app_author_create')]
    public function createAuthor(Request $request, EntityManagerInterface $em){
        $author = new Author();
        //$author->setEmail('test@gmail.commmm');
        $form= $this->createForm(AddEditAuthorType::class, $author);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $em->persist($author);
            $em->flush();
            return $this->redirectToRoute('app_author_list');
        }
        return $this->render('author/form.html.twig', [
            "title" => "Create Author",
            "form" => $form
        ]);
    }

    #[Route('/author/edit/{id}', name:'app_author_edit')]
    public function editAuthor($id, EntityManagerInterface $em, AuthorRepository $authorRepository){
        $author = $authorRepository->find($id);
        $author->setNbBooks(150);
        //$em->persist($author);
        $em->flush();
        dd($author);
    }

    #[Route('/author/update/{id}', name:'app_author_update')]
    public function updateAuthor($id, Request $request, AuthorRepository $authorRepository, EntityManagerInterface $em){
        $author = $authorRepository->find($id);
        //$author->setEmail('test@gmail.commmm');
        $form= $this->createForm(AddEditAuthorType::class, $author);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            //$em->persist($author);
            $em->flush();
            return $this->redirectToRoute('app_author_list');
        }
        return $this->render('author/form.html.twig', [
            "title" => "Update Author",
            "form" => $form
        ]);
    }

    #[Route('/author/delete/{id}', name:'app_author_delete')]
    public function deleteAuthor($id, EntityManagerInterface $em, AuthorRepository $authorRepository){
        $author = $authorRepository->find($id);
        $em->remove($author);
        $em->flush();
        return $this->redirectToRoute('app_author_list');
        //dd("Author Deleted");
    }

}
