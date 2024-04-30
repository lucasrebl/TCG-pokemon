<?php

require_once 'database/connect.php';
require 'vendor/autoload.php';

$dsn = new PDO("mysql:host=mysql;dbname=my_database", "my_user", "my_password");
$dsn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$createTableUser = ("CREATE TABLE IF NOT EXISTS
`user` (
  `idUser` int(11) NOT NULL AUTO_INCREMENT,
  `lastName` varchar(255) DEFAULT NULL,
  `firstName` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `passwordUser` varchar(255) DEFAULT NULL,
  `isAdmin` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`idUser`),
  CONSTRAINT unique_email UNIQUE (`email`)
) ENGINE = InnoDB AUTO_INCREMENT = 14 DEFAULT CHARSET = latin1");
$dsn->exec($createTableUser);

$createTableCard = ("CREATE TABLE IF NOT EXISTS
`card` (
  `idCard` int(11) NOT NULL AUTO_INCREMENT,
  `idApi` varchar(255) DEFAULT NULL,
  `small_image_url` VARCHAR(255),
  `large_image_url` VARCHAR(255),
  PRIMARY KEY (`idCard`),
  CONSTRAINT unique_idApi UNIQUE (`idApi`)
) ENGINE = InnoDB AUTO_INCREMENT = 14 DEFAULT CHARSET = latin1");
$dsn->exec($createTableCard);

$createTablePacks = ("CREATE TABLE IF NOT EXISTS
`packs` (
  `idPacks` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `idUser` int(11) DEFAULT NULL,
  `isOpen` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`idPacks`),
  CONSTRAINT unique_name UNIQUE (`name`),
  CONSTRAINT fk_idUser FOREIGN KEY (`idUser`) REFERENCES user (`idUser`)
) ENGINE = InnoDB AUTO_INCREMENT = 14 DEFAULT CHARSET = latin1");
$dsn->exec($createTablePacks);

$createTableCardPacks = ("CREATE TABLE IF NOT EXISTS
`cardPacks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idCard` int(11) DEFAULT NULL,
  `idPacks` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT fk_idCard FOREIGN KEY (`idCard`) REFERENCES card (`idCard`),
  CONSTRAINT fk_idPacks FOREIGN KEY (`idPacks`) REFERENCES packs (`idPacks`)
) ENGINE = InnoDB AUTO_INCREMENT = 14 DEFAULT CHARSET = latin1");
$dsn->exec($createTableCardPacks);

$createTableCollection = ("CREATE TABLE IF NOT EXISTS
`collection` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idUser` int(11) DEFAULT NULL,
  `idCard` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT fk_idUser2 FOREIGN KEY (`idUser`) REFERENCES user (`idUser`),
  CONSTRAINT fk_idCard2 FOREIGN KEY (`idCard`) REFERENCES card (`idCard`)
) ENGINE = InnoDB AUTO_INCREMENT = 14 DEFAULT CHARSET = latin1");
$dsn->exec($createTableCollection);
