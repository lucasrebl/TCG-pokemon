<?php

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

require 'vendor/autoload.php';

class shopController
{
    protected $twig;
    private $loader;

    public function __construct()
    {
        $this->loader = new FilesystemLoader(__DIR__ . '/../views/templates');
        $this->twig = new Environment($this->loader);
    }

    public function shop()
    {
        include __DIR__ . '/../model/shopModel.php';
        $this->insertCardID();
        echo $this->twig->render('shop/shop.html.twig');
    }

    public function insertCardID()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupérer les IDs des cartes Pokémon envoyées depuis JavaScript
            $pokemonIds = json_decode(file_get_contents('php://input'), true);
            
            // Insérer les IDs dans la base de données
            insertIdOfCard($pokemonIds);
        }
    }
}
