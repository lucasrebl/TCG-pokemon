<?php

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

require 'vendor/autoload.php';

class registerController
{
    protected $twig;
    private $loader;

    public function __construct()
    {
        $this->loader = new FilesystemLoader(__DIR__ . '/../views/templates');
        $this->twig = new Environment($this->loader);
    }

    public function register()
    {
        include __DIR__ . '/../model/registerModel.php';
        $this->getRegister();
        echo $this->twig->render('register/register.html.twig');
    }

    public function getRegister()
    {
        if (isset($_POST['submit'])) {
            $first_Name = $_POST['firstName'];
            $last_Name = $_POST['lastName'];
            $email_ = $_POST['email'];
            $password_User = $_POST['passwordUser'];

            $hashed_password = password_hash($password_User, PASSWORD_DEFAULT);
            insertUser($first_Name, $last_Name, $email_, $hashed_password);
        }
    }
}
