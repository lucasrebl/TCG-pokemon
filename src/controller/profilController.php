<?php

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

require 'vendor/autoload.php';

class profilController
{
    protected $twig;
    private $loader;

    public function __construct()
    {
        $this->loader = new FilesystemLoader(__DIR__ . '/../views/templates');
        $this->twig = new Environment($this->loader);
    }

    public function profil()
    {
        session_start();
        $user = [
            'idUser' => $_SESSION['idUser']
        ];
        $isConnected = false;

        // Vérifie si l'utilisateur est connecté
        if (isset($_SESSION['idUser'])) {
            // Si l'utilisateur est connecté, setIsConnected à true
            $isConnected = true;
            
        }
        var_dump($_SESSION);

        if ($user['idUser'] < 1) {
            echo "veuiller vous connecter ou créer un compte pour avoir accés a votre profil";
        }

        echo $this->twig->render('profil/profil.html.twig', ['isConnected' => $isConnected]);
        $this->logOut();
    }

    public function logOut()
    {
        if (isset($_POST['logOut'])) {
            session_unset();
            session_unset();
            echo '<script>window.location.replace("/login");</script>';
        }
    }
}
