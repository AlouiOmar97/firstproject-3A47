<?php

namespace App\Controller;

use App\Repository\AuthorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
        ]);
    }
}
