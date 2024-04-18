<?php

namespace App\Card;

class Card
{
    protected $name;

const CARDS = [
    '2 of Hearts' => '&#127153;',
    '3 of Hearts' => '&#127154;',
    '4 of Hearts' => '&#127155;',
    '5 of Hearts' => '&#127156;',
    '6 of Hearts' => '&#127157;',
    '7 of Hearts' => '&#127158;',
    '8 of Hearts' => '&#127159;',
    '9 of Hearts' => '&#127160;',
    '10 of Hearts' => '&#127161;',
    'Jack of Hearts' => '&#127162;',
    'Queen of Hearts' => '&#127163;',
    'King of Hearts' => '&#127164;',
    'Ace of Hearts' => '&#127165;',
    '2 of Diamonds' => '&#127169;',
    '3 of Diamonds' => '&#127170;',
    '4 of Diamonds' => '&#127171;',
    '5 of Diamonds' => '&#127172;',
    '6 of Diamonds' => '&#127173;',
    '7 of Diamonds' => '&#127174;',
    '8 of Diamonds' => '&#127175;',
    '9 of Diamonds' => '&#127176;',
    '10 of Diamonds' => '&#127177;',
    'Jack of Diamonds' => '&#127178;',
    'Queen of Diamonds' => '&#127179;',
    'King of Diamonds' => '&#127180;',
    'Ace of Diamonds' => '&#127181;',
    '2 of Clubs' => '&#127185;',
    '3 of Clubs' => '&#127186;',
    '4 of Clubs' => '&#127187;',
    '5 of Clubs' => '&#127188;',
    '6 of Clubs' => '&#127189;',
    '7 of Clubs' => '&#127190;',
    '8 of Clubs' => '&#127191;',
    '9 of Clubs' => '&#127192;',
    '10 of Clubs' => '&#127193;',
    'Jack of Clubs' => '&#127194;',
    'Queen of Clubs' => '&#127195;',
    'King of Clubs' => '&#127196;',
    'Ace of Clubs' => '&#127197;',
    '2 of Spades' => '&#127137;',
    '3 of Spades' => '&#127138;',
    '4 of Spades' => '&#127139;',
    '5 of Spades' => '&#127140;',
    '6 of Spades' => '&#127141;',
    '7 of Spades' => '&#127142;',
    '8 of Spades' => '&#127143;',
    '9 of Spades' => '&#127144;',
    '10 of Spades' => '&#127145;',
    'Jack of Spades' => '&#127146;',
    'Queen of Spades' => '&#127147;',
    'King of Spades' => '&#127148;',
    'Ace of Spades' => '&#127149;',
];


    public function __construct($name)
    {
        $this->name = $name;
    }

    public function getCardSymbol(): string
{
    $symbol = self::CARDS[$this->name];
    // Extract the suit from the card name
    $suit_hearts = substr($this->name, -6);
    $suit_diamonds = substr($this->name, -8);
    
    // Check if the suit is hearts or diamonds and apply the corresponding CSS class
    if ($suit_hearts === "Hearts" || $suit_diamonds === "Diamonds") {
        // Add a CSS class for hearts and diamonds
        $symbol = '<span class="card-red">' . $symbol . '</span>';
    }
    
    return $symbol;
}

}
