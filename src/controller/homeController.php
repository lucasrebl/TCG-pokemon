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
        $this->logOut();
        echo $this->twig->render('home/home.html.twig');
    }


    public function logOut()
    {
        if (isset($_POST['logOut'])) {
            session_unset();
            session_destroy();
            echo '<script>window.location.replace("/login");</script>';
        }
    }
}
