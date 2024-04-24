<?php

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

require 'vendor/autoload.php';

class loginController
{
    protected $twig;
    private $loader;

    public function __construct()
    {
        $this->loader = new FilesystemLoader(__DIR__ . '/../views/templates');
        $this->twig = new Environment($this->loader);
    }

    public function login()
    {
        session_start();
        // var_dump($_SESSION);
        $isConnected = false;

        // Vérifie si l'utilisateur est connecté
        if (isset($_SESSION['idUser'])) {
            // Si l'utilisateur est connecté, setIsConnected à true
            $isConnected = true;
            
        }
        include __DIR__ . '/../model/loginModel.php';
        $this->getLogin();
        echo $this->twig->render('login/login.html.twig', ['isConnected' => $isConnected]);
    }

    public function getLogin()
    {
        if (isset($_POST['submit'])) {
            $login_email = $_POST['email'];
            $login_password = $_POST['passwordConnexion'];
            if (empty($login_email) || empty($login_password)) {
                echo "remplis tout les champs";
            }
            login($login_email, $login_password);
        }
    }
}
