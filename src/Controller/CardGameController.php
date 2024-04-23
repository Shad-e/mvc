<?php

namespace App\Controller;

use App\Card\Card;
use App\Card\JokerCard;
use App\Card\DeckOfCards;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CardGameController extends AbstractController
{
    #[Route("/session", name: "session_page")]
    public function landingPage(SessionInterface $session): Response
    {
        $sessionData = $session->all();

        return $this->render('session.html.twig', [
            'remaining_cards' => $sessionData['remaining_cards'] ?? [],
        ]);
    }

    #[Route("/session/delete", name: "delete_session")]
    public function deleteSession(SessionInterface $session): Response
    {
        $session->clear();
        $this->addFlash(
            'success',
            'Session data was cleared!'
        );
        return $this->redirectToRoute('session_page');
    }

    #[Route("/card", name: "card_start")]
    public function home(): Response
    {
        return $this->render('card/home.html.twig');
    }


    #[Route("/card/draw", name: "draw_card")]
    public function drawCard(SessionInterface $session): Response
    {
        $session->remove('drawn_card');
        $remainingCards = $session->get('remaining_cards', array_keys(Card::CARDS));

        if (empty($remainingCards)) {
            $this->addFlash(
                'warning',
                'You have no cards left!'
            );

            return $this->render('card/no_cards_left.html.twig');
        } else {
            $randomCardName = $remainingCards[array_rand($remainingCards)];
            $key = array_search($randomCardName, $remainingCards);
            unset($remainingCards[$key]);

            $session->set('remaining_cards', $remainingCards);

            $card = new Card($randomCardName);

            $session->set('drawn_card', [
                'name' => $randomCardName,
                'symbol' => $card->getCardSymbol(),
            ]);

            $data = [
                "card" => $card->getCardSymbol(),
                "remaining_cards_count" => count($remainingCards),
            ];

            return $this->render('card/draw_card.html.twig', $data);
        }
    }

    #[Route("/card/deck", name: "card_deck")]
    public function deckOfCards(): Response
    {
        $deck = new DeckOfCards(false); // Skapar en kortlek utan jokrar
        $cards = $deck->getCards();

        $cardSymbols = [];
        foreach ($cards as $card) {
            $cardSymbols[] = $card->getCardSymbol();
        }

        $data = [
            "cards" => $cardSymbols,
        ];

        return $this->render('card/card_deck.html.twig', $data);
    }

    #[Route("/card/deck_with_joker", name: "card_deck_with_jokers")]
    public function deckOfCardsWithJokers(): Response
    {
        $deck = new DeckOfCards(true);
        $cards = $deck->getCards();

        $regularCards = [];
        $jokerCards = [];

        foreach ($cards as $card) {
            if ($card instanceof JokerCard) {
                $jokerCards[] = $card->getCardSymbol();
            } else {
                $regularCards[] = $card->getCardSymbol();
            }
        }

        $data = [
            "cards" => $regularCards,
            "jokers" => $jokerCards,
        ];

        return $this->render('card/card_deck_joker.html.twig', $data);
    }


    #[Route("/card/deck/shuffle", name: "card_deck_shuffle")]
    public function deckOfCardsShuffled(SessionInterface $session): Response
    {
        $session->clear(); // Clear the session

        $deck = new DeckOfCards();
        $cards = $deck->getCards();

        shuffle($cards);

        $cardSymbols = [];
        foreach ($cards as $card) {
            $cardSymbols[] = $card->getCardSymbol();
        }

        $data = [
            "cards" => $cardSymbols,
        ];

        $this->addFlash(
            'success',
            'Cards were shuffled! Session data cleared.'
        );
        return $this->render('card/card_deck_shuffle.html.twig', $data);
    }



    #[Route("/card/draw/{count}", name: "draw_cards", requirements: ["count" => "\d+"])]
    public function drawCards(int $count, SessionInterface $session): Response
    {
        $session->remove('drawn_cards');
        $remainingCards = $session->get('remaining_cards', array_keys(Card::CARDS));

        if (empty($remainingCards)) {
            $this->addFlash(
                'warning',
                'You have no cards left!'
            );

            return $this->render('card/no_cards_left.html.twig');
        } elseif (count($remainingCards) < $count) {
            $this->addFlash(
                'warning',
                'You are trying to draw more cards than available!'
            );

            return $this->redirectToRoute('draw_card'); // Redirect to draw a single card
        } else {
            $drawnCards = [];
            for ($i = 0; $i < $count; $i++) {
                $randomCardName = $remainingCards[array_rand($remainingCards)];

                $key = array_search($randomCardName, $remainingCards);
                unset($remainingCards[$key]);

                $card = new Card($randomCardName);

                $drawnCards[] = [
                    'name' => $randomCardName,
                    'symbol' => $card->getCardSymbol(),
                ];
            }

            $session->set('remaining_cards', $remainingCards);
            $session->set('drawn_cards', $drawnCards);

            $data = [
                "drawn_cards" => $drawnCards,
                "remaining_cards_count" => count($remainingCards),
            ];

            return $this->render('card/draw_many.html.twig', $data);
        }
    }

}
