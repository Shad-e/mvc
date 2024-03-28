<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LuckyControllerTwig extends AbstractController
{   
    #[Route("/", name: "home")]
    public function home(): Response
    {
        return $this->render('home.html.twig');
    }

    #[Route("/about", name: "about")]
    public function about(): Response
    {
        return $this->render('about.html.twig');
    }

    #[Route("/report", name: "report")]
    public function report(): Response
    {
        return $this->render('report.html.twig');
    }

    #[Route("/lucky", name: "lucky_number")]
    public function number(): Response
    {
        $number = random_int(0, 100);

        $images = [
            'img/clown1.png',
            'img/clown2.png',
            'img/clown3.png',
            'img/clown4.png'
        ];

        $backgroundColors = [
            'red',
            'green',
            'blue',
            'yellow'
        ];

        $randomIndex = array_rand($images);
        $randomImage = $images[$randomIndex];

        $randomColor = $backgroundColors[array_rand($backgroundColors)];

        return $this->render('lucky_number.html.twig', [
            'number' => $number,
            'image' => $randomImage,
            'backgroundColor' => $randomColor
        ]);
    }

    #[Route("/api", name: "api")]
    public function api(): Response
    {
        return $this->render('api.html.twig');
    }
}