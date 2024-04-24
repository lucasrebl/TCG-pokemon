<?php

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

require 'vendor/autoload.php';

class shopController
{
    protected $twig;
    private $loader;

    public function __construct()
    {
        $this->loader = new FilesystemLoader(__DIR__ . '/../views/templates');
        $this->twig = new Environment($this->loader);
    }

    public function shop()
    {
        echo $this->twig->render('shop/shop.html.twig');
    }
}