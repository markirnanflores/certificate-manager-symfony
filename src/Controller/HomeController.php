<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends AbstractController
{
    #[Route('/', name: 'homepage', methods: ['GET'])]
    public function index(): Response
    {
        $htmlPath = dirname(__DIR__, 2) . '/public/index.html';
        if (file_exists($htmlPath)) {
            echo file_get_contents($htmlPath);
        }
        return new Response();
    }
}