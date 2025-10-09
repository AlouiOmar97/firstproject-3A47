<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/hello/{name}', name:'app_home_hello')]
    public function hello($name): Response {
        $text="bonjour";
        return new Response('hello '. $name);
    }

    #[Route('/hello/{name}/{age}', name:'app_home_hello_name_age')]
    public function helloo(string $name, $age): Response{
        $products=[
            ["name"=>"Product1", "price"=>50],["name"=>"Product2", "price"=>60]
        ];
        //dd($products);
        //dump($products);
        //die();
        return $this->render('home/hello.html.twig', [
            "name" => $name,
            "age" => $age,
            "products" => $products
        ]);
    }

}
