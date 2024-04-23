<?php

namespace App\Card;

class CardHand
{
    protected $cards;

    public function __construct(array $cardNames)
    {
        $this->cards = array_map(function ($name) {
            return new Card($name);
        }, $cardNames);
    }

    public function getHand(): array
    {
        return $this->cards;
    }

    public function getHandSymbols(): array
    {
        $symbols = [];
        foreach ($this->cards as $card) {
            $symbols[] = $card->getCardSymbol();
        }
        return $symbols;
    }
}

// Används såhär:
// Kommer uppdateras så att den även kan hantera slumpmässiga kort.
// $hand = new CardHand(['2 of Hearts', 'Ace of Diamonds', 'Jack of Clubs']);
// $handSymbols = $hand->getHandSymbols();
