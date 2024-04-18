<?php

namespace App\Card;

class DeckOfCards
{
    protected $cards = [];

    public function __construct()
    {
        $this->initializeDeck();
    }

    protected function initializeDeck()
    {
        foreach (Card::CARDS as $name => $symbol) {
            $this->cards[] = new Card($name);
        }
    }

    public function getCards(): array
    {
        return $this->cards;
    }
}
