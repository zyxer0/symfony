<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class MainController extends AbstractController
{
    
    
    
    public function index() :Response
    {

        return $this->render('shortener/index.twig', [
            'var1' => 'foo',
            'var2' => 'bar',
        ]);
    }
    
    public function history() :Response
    {
        return new Response('history');
    }
}