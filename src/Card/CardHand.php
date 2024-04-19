<?php

namespace App\Card;

class CardHand extends Card
{
    protected $hand;

    public function __construct(array $hand)
    {
        $this->hand = $hand;
    }

    public function getHand(): array
    {
        return $this->hand;
    }

    public function getHandSymbols(): array
    {
        $symbols = [];
        foreach ($this->hand as $card) {
            $symbols[] = $this->getCardSymbol($card);
        }
        return $symbols;
    }
}

// Används såhär:
// Kommer uppdateras så att den även kan hantera slumpmässiga kort.
// $hand = new CardHand(['2 of Hearts', 'Ace of Diamonds', 'Jack of Clubs']);
// $handSymbols = $hand->getHandSymbols();
