<?php

namespace App\Controller;

use App\Card\Card;
use App\Card\DeckOfCards;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CardGameJson
{
    #[Route("/api/deck", name:"api_deck")]
    public function jsonDeck(): Response
    {
        $cardNames = array_keys(Card::CARDS);

        $data = [
            "cards" => $cardNames,
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );

        return $response;
    }
    
    #[Route("/api/deck/shuffle", name: "api_deck_shuffle")]
    public function jsonDeckShuffle(SessionInterface $session): Response
    {
        $cardNames = array_keys(Card::CARDS);
    
        shuffle($cardNames);
    
        $session->set('shuffled_cards', $cardNames);
    
        $data = [
            "cards" => $cardNames,
        ];
    
        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
    
        return $response;
    }

    #[Route("/api/deck/get-shuffled-cards", name: "api_get_shuffled_cards")]
    public function getShuffledCards(SessionInterface $session): JsonResponse
    {
        $shuffledCards = $session->get('shuffled_cards');

        return new JsonResponse($shuffledCards);
    }


    #[Route("/api/deck/draw", name: "api_draw_card")]
    public function drawCard(SessionInterface $session): Response
    {
        $deck = $session->get('shuffled_cards', []);

        if (empty($deck)) {
            return new JsonResponse(['message' => 'No cards left in the deck'], Response::HTTP_NOT_FOUND);
        }

        $drawnCard = array_shift($deck);

        $session->set('shuffled_cards', $deck);

        $data = [
            'drawn_card' => $drawnCard,
            'remaining_cards' => count($deck),
        ];

        return new JsonResponse($data);
}

}
