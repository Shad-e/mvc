<?php

namespace App\Card;

class DeckOfCards
{
    protected $cards = [];

    public function __construct($includeJokers = true)
    {
        $this->initializeDeck($includeJokers);
    }

    protected function initializeDeck($includeJokers)
    {
        foreach (Card::CARDS as $name => $symbol) {
            $this->cards[] = new Card($name);
        }

        if ($includeJokers) {
            foreach (JokerCard::JOKER_CARDS as $name => $symbol) {
                $this->cards[] = new JokerCard($name);
            }
        }
    }

    public function getCards(): array
    {
        return $this->cards;
    }
}
