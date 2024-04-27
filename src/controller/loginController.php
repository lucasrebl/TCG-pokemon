<?php

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Google\Client;
use Google\Service\Oauth2;

require 'vendor/autoload.php';
require_once '.env'; 

// Charger les variables d'environnement
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

// Vérifier si les clés sont définies
if (!isset($_ENV['GOOGLE_CLIENT_ID'], $_ENV['GOOGLE_CLIENT_SECRET'], $_ENV['GOOGLE_REDIRECT_URI'])) {
    echo "Erreur: Clés Google non définies.";
    exit;
}

// Assigner les clés à des variables
$clientId = $_ENV['GOOGLE_CLIENT_ID'];
$clientSecret = $_ENV['GOOGLE_CLIENT_SECRET'];
$redirectUri = $_ENV['GOOGLE_REDIRECT_URI'];

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
        // Démarrer la session avant tout affichage
        session_start();

        // Inclure le modèle de connexion
        include __DIR__ . '/../model/loginModel.php';

        // Appel à la méthode pour traiter la connexion
        $this->getLogin();

        // Rendre le template Twig pour la page de connexion
        echo $this->twig->render('login/login.html.twig');
    }

    public function getLogin()
    {
        if (isset($_POST['submit'])) {
            $login_email = $_POST['email'];
            $login_password = $_POST['passwordConnexion'];
            if (empty($login_email) || empty($login_password)) {
                echo "Erreur: Veuillez remplir tous les champs.";
            }
            login($login_email, $login_password);
        }
    }

    public function getGoogleLogin()
    {
        // Vérifier si les clés sont définies
        if (!isset($_ENV['GOOGLE_CLIENT_ID'], $_ENV['GOOGLE_CLIENT_SECRET'], $_ENV['GOOGLE_REDIRECT_URI'])) {
            echo "Erreur: Clés Google non définies.";
            exit;
        }

        $client = new Client();
        $client->setClientId($_ENV['GOOGLE_CLIENT_ID']);
        $client->setClientSecret($_ENV['GOOGLE_CLIENT_SECRET']);
        $client->setRedirectUri($_ENV['GOOGLE_REDIRECT_URI']);
        $client->setScopes([Oauth2::USERINFO_EMAIL, Oauth2::USERINFO_PROFILE]);

        $oauth2Service = new Oauth2($client);

        if (isset($_GET['code'])) {
            $client->authenticate($_GET['code']);
            $accessToken = $client->getAccessToken();
            $client->setAccessToken($accessToken);
            $userInfo = $oauth2Service->userinfo->get();
            echo "Nom: " . $userInfo->getName() . "<br>";
            echo "Email: " . $userInfo->getEmail() . "<br>";
        } else {
            $authUrl = $client->createAuthUrl();
            echo '<a href="' . $authUrl . '">Se connecter avec Google</a>';
            exit;
        }
    }
}
