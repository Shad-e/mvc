<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LuckyControllerJson
{
    #[Route("/api/quote", name:"api_quote")]
    public function jsonQuote(): Response
    {
        $quotes = [
            "The key to immortality is first living a life worth remembering - Bruce Lee",
            "Success is not final, failure is not fatal: It is the courage to continue that counts. - Winston Churchill",
            "It does not matter how slowly you go as long as you do not stop. - Confucius"
        ];


        $randomIndex = array_rand($quotes);
        $selectedQuote = $quotes[$randomIndex];


        date_default_timezone_set('Europe/Stockholm');

        $currentDate = date('Y-m-d');
        $currentTime = date('H:i:s');


        $data = [
            'quote' => $selectedQuote,
            'date' => $currentDate,
            'timestamp' => $currentTime
        ];


        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );

        return $response;
    }
}
