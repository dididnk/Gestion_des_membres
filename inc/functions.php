<?php

// permet d'afficher le message d'erreur
function debug($variable)
{
    echo "<pre>" . print_r($variable, true) . "</pre>";
}
// permet de génerer des caractères aléatoire lenght = 60
function str_random($lenght)
{
    $alphabet = "0123jesusgbamednkkoyapoloEMMANUELELOHIM456789yhwh"; //notre alphabet
    // str_repeat: répète en mélangeant 60x l'alphabet; substr récupère que 60 premiers caractàres de ce mélange
    return substr(str_shuffle(str_repeat($alphabet, $lenght)), 0, $lenght);
}
