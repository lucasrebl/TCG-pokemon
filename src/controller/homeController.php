<?php

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

require 'vendor/autoload.php';

class homeController
{
    protected $twig;
    private $loader;

    public function __construct()
    {
        $this->loader = new FilesystemLoader(__DIR__ . '/../views/templates');
        $this->twig = new Environment($this->loader);
    }
    public function home()
    {
        session_start();
        // Initialise isConnected à false par défaut
        $isConnected = false;
        // Vérifie si l'utilisateur est connecté
        if (isset($_SESSION['idUser'])) {
            // Si l'utilisateur est connecté, setIsConnected à true
            $isConnected = true;
        }
        // Passer isConnected à la vue Twig
        echo $this->twig->render('home/home.html.twig', ['isConnected' => $isConnected]);
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
