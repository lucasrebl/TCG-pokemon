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
        var_dump($_SESSION);
        $user = [
            'idUser' => $_SESSION['idUser']
        ];

        if ($user['idUser'] < 1) {
            echo "veuiller vous connecter ou créer un compte pour avoir accés a votre profil";
        }

        echo $this->twig->render('profil/profil.html.twig');
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
