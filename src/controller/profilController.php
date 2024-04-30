<?php

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

require 'vendor/autoload.php';
require_once 'database/connect.php';

class profilController
{
    protected $twig;
    private $loader;
    private $dsn;

    public function __construct()
    {
        $this->loader = new FilesystemLoader(__DIR__ . '/../views/templates');
        $this->twig = new Environment($this->loader);
    }

    public function profil()
    {
        session_start();
        include __DIR__ . '/../model/profilModel.php';
        $user = [
            'idUser' => $_SESSION['idUser']
        ];
        if ($user['idUser'] < 1) {
            echo "veuiller vous connecter ou créer un compte pour avoir accés a votre profil";
        }

        $this->logOut();
        $packsName = $this->getPackByIdUser();
        $this->openPacks();
        $idCard = $this->readCardById();
        $cardDisplay = $this->displayCard($idCard); // Passer les identifiants des cartes à la méthode displayCard
        echo $this->twig->render('profil/profil.html.twig', [
            'readPacksName' => $packsName,
            'displayCard' => $cardDisplay,
        ]);
    }

    public function connectDb()
    {
        $this->dsn = new PDO("mysql:host=mysql;dbname=my_database", "my_user", "my_password");
        $this->dsn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function logOut()
    {
        if (isset($_POST['logOut'])) {
            session_unset();
            session_unset();
            echo '<script>window.location.replace("/login");</script>';
        }
    }

    public function getPackByIdUser()
    {
        $user = [
            'idUser' => $_SESSION['idUser']
        ];
        $idUser = $user['idUser'];

        $this->connectDb();

        $query = "SELECT * FROM packs WHERE idUser = :idUser";
        $stmt = $this->dsn->prepare($query);
        $stmt->bindParam(':idUser', $idUser, PDO::PARAM_INT);
        $stmt->execute();
        $packsName = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $packsName;
    }

    public function openPacks()
    {
        $user = [
            'idUser' => $_SESSION['idUser']
        ];

        if (isset($_POST['open_pack'])) {
            $packsName = $_POST['pack_name'];
            $idUser = $user['idUser'];
            openPacksOfCard($packsName, $idUser);
        }
    }

    public function readCardById()
    {
        $user = [
            'idUser' => $_SESSION['idUser']
        ];
        $idUser = $user['idUser'];

        $this->connectDb();

        $query = "SELECT idCard FROM collection WHERE idUser = :idUser";
        $stmt = $this->dsn->prepare($query);
        $stmt->bindParam(':idUser', $idUser, PDO::PARAM_INT);
        $stmt->execute();
        $idCards = $stmt->fetchAll(PDO::FETCH_COLUMN); // Utilisez FETCH_COLUMN pour obtenir directement une liste d'identifiants
        return $idCards;
    }

    public function displayCard($idCards)
    {
        $this->connectDb();

        if (empty($idCards)) {
            // Si la liste d'identifiants est vide, retournez une liste vide
            return [];
        }

        $idCardPlaceholders = implode(',', array_fill(0, count($idCards), '?')); // Créer les placeholders pour la clause IN

        $query = "SELECT * FROM card WHERE idCard IN ($idCardPlaceholders)";
        $stmt = $this->dsn->prepare($query);
        $stmt->execute($idCards); // Passer la liste d'identifiants comme paramètres
        $cardDisplay = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $cardDisplay;
    }
}
