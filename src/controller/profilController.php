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
        var_dump($_SESSION);
        $user = [
            'idUser' => $_SESSION['idUser']
        ];
        if ($user['idUser'] < 1) {
            echo "veuiller vous connecter ou créer un compte pour avoir accés a votre profil";
        }

        $this->logOut();
        $packsName = $this->getPackByIdUser();
        echo $this->twig->render('profil/profil.html.twig', [
            'readPacksName' => $packsName
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

        $query = "SELECT name FROM packs WHERE idUser = :idUser";
        $stmt = $this->dsn->prepare($query);
        $stmt->bindParam(':idUser', $idUser, PDO::PARAM_INT);
        $stmt->execute();
        $packsName = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $packsName;
    }
}
