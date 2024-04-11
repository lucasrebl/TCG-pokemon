<?php

require_once 'models/connect.php';
require 'vendor/autoload.php';

$dsn = new PDO("mysql:host=mysql;dbname=my_database", "my_user", "my_password");
$dsn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$createTable = ("CREATE TABLE IF NOT EXISTS
`user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lastName` varchar(255) DEFAULT NULL,
  `firstName` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `passwordUser` varchar(255) DEFAULT NULL,
  `isAdmin` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  CONSTRAINT unique_email UNIQUE (`email`)
) ENGINE = InnoDB AUTO_INCREMENT = 14 DEFAULT CHARSET = latin1");
$dsn->exec($createTable);