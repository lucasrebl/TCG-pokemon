<?php

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

require 'vendor/autoload.php';
require_once 'database/connect.php';

class shopController
{
    protected $twig;
    private $loader;
    private $dsn;

    public function __construct()
    {
        $this->loader = new FilesystemLoader(__DIR__ . '/../views/templates');
        $this->twig = new Environment($this->loader);
    }

    public function shop()
    {
        session_start();
        var_dump($_SESSION);
        include __DIR__ . '/../model/shopModel.php';
        $this->insertCardID();
        $this->buyPack5();
        echo $this->twig->render('shop/shop.html.twig');
    }

    public function connectDb()
    {
        $this->dsn = new PDO("mysql:host=mysql;dbname=my_database", "my_user", "my_password");
        $this->dsn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
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

    public function buyPack5()
    {
        $user = [
            'idUser' => $_SESSION['idUser']
        ];
        if (isset($_POST['pack5'])) {
            // $id5Card = $this->get5IdCardRandom();
            $idUser = $user['idUser'];
            buyPackOf5($idUser);
        }
    }

    public function get5IdCardRandom()
    {
        $this->connectDb();
        $query = "SELECT idCard FROM card ORDER BY RAND() LIMIT 5";
        $id5Card = $this->dsn->query($query);
        return $id5Card;
    }
}
