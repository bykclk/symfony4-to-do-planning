<?php


namespace App\Controller;


use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class DefaultController
{
    public function index(Environment $twig, UserRepository $userRepository): Response
    {
        $response = new Response();

        $response->setContent($twig->render('default/index.html.twig', [
            'users' => $userRepository->findAll()
        ]));

        return $response;
    }
}