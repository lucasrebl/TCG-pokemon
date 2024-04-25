<?php

require_once './database/connect.php';


function insertIdOfCard($pokemonIds)
{
    try {
        // Vérifier si $pokemonIds est nul
        if ($pokemonIds === null) {
            echo "Aucune donnée à insérer.";
            return;
        }

        $dsn = new PDO("mysql:host=mysql;dbname=my_database", "my_user", "my_password");
        $dsn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Parcourir les IDs des cartes Pokémon
        foreach ($pokemonIds as $id) {
            // Vérifier si l'ID existe déjà dans la base de données
            $checkQuery = "SELECT COUNT(*) FROM card WHERE idApi = :idApi";
            $stmt = $dsn->prepare($checkQuery);
            $stmt->bindParam(':idApi', $id);
            $stmt->execute();
            $count = $stmt->fetchColumn();

            // Si l'ID n'existe pas, l'insérer
            if ($count == 0) {
                $insertQuery = "INSERT INTO card (idApi) VALUES (:idApi)";
                $stmt = $dsn->prepare($insertQuery);
                $stmt->bindParam(':idApi', $id);
                $stmt->execute();
            }
        }

        echo "Les données ont été insérées dans la base de données avec succès.";
    } catch (PDOException $e) {
        $error  = "error: " . $e->getMessage();
        echo $error;
    }
}

function buyPackOf5($idUser, $id5Card)
{
    try {
        $dsn = new PDO("mysql:host=mysql;dbname=my_database", "my_user", "my_password");
        $dsn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $baseName = "pack5_" . $idUser . "_"; // Base du nom du pack

        // Vérifier si un pack avec ce nom existe déjà
        $stmtCheck = $dsn->prepare("SELECT COUNT(*) FROM packs WHERE name LIKE :name");
        $stmtCheck->bindValue(':name', $baseName . '%');
        $stmtCheck->execute();
        $count = $stmtCheck->fetchColumn();

        if ($count > 0) {
            // Si un pack avec ce nom existe déjà, incrémentez le nombre
            $newName = $baseName . ($count + 1);
        } else {
            // Sinon, utilisez le nom de base
            $newName = $baseName . "1";
        }

        $stmt = $dsn->prepare("INSERT INTO packs (name, idUser) VALUES (:name, :idUser)");
        $stmt->bindParam(':name', $newName);
        $stmt->bindParam(':idUser', $idUser);

        if ($stmt->execute()) {
            // Récupérer l'ID du pack nouvellement créé
            $idPack = $dsn->lastInsertId();

            // Insérer les cinq ID de carte dans cardPacks
            $stmtInsertCards = $dsn->prepare("INSERT INTO cardPacks (idCard, idPacks) VALUES (:idCard, :idPack)");
            foreach ($id5Card as $idCard) {
                $stmtInsertCards->bindParam(':idCard', $idCard, PDO::PARAM_INT);
                $stmtInsertCards->bindParam(':idPack', $idPack, PDO::PARAM_INT);
                $stmtInsertCards->execute();
            }

            echo "Pack de 5 card acheté.";
        } else {
            echo "Échec de l'achat du pack de 5 card.";
        }
    } catch (PDOException $e) {
        $error  = "Erreur : " . $e->getMessage();
        echo $error;
    }
}

function buyPackOf10($id10Card, $idUser)
{
    try {
        $dsn = new PDO("mysql:host=mysql;dbname=my_database", "my_user", "my_password");
        $dsn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $baseName = "pack10_" . $idUser . "_";

        $stmtCheck = $dsn->prepare("SELECT COUNT(*) FROM packs WHERE name LIKE :name");
        $stmtCheck->bindValue(':name', $baseName . '%');
        $stmtCheck->execute();
        $count = $stmtCheck->fetchColumn();

        if ($count > 0) {
            $newName = $baseName . ($count + 1);
        } else {
            $newName = $baseName . "1";
        }

        $stmt = $dsn->prepare("INSERT INTO packs (name, idUser) VALUES (:name, :idUser)");
        $stmt->bindParam(':name', $newName);
        $stmt->bindParam(':idUser', $idUser);

        if ($stmt->execute()) {
            $idPack = $dsn->lastInsertId();

            $stmtInsertCards = $dsn->prepare("INSERT INTO cardPacks (idCard, idPacks) VALUES (:idCard, :idPack)");
            foreach ($id10Card as $idCard) {
                $stmtInsertCards->bindParam(':idCard', $idCard, PDO::PARAM_INT);
                $stmtInsertCards->bindParam(':idPack', $idPack, PDO::PARAM_INT);
                $stmtInsertCards->execute();
            }
            echo "Pack de 10 card acheté.";
        } else {
            echo "Échec de l'achat du pack de 10 card.";

        }
    } catch (PDOException $e) {
        $error  = "Erreur : " . $e->getMessage();
        echo $error;
    }
}


function buyPackOf15($id15Card, $idUser)
{
    try {
        $dsn = new PDO("mysql:host=mysql;dbname=my_database", "my_user", "my_password");
        $dsn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $baseName = "pack15_" . $idUser . "_";

        $stmtCheck = $dsn->prepare("SELECT COUNT(*) FROM packs WHERE name LIKE :name");
        $stmtCheck->bindValue(':name', $baseName . '%');
        $stmtCheck->execute();
        $count = $stmtCheck->fetchColumn();

        if ($count > 0) {
            $newName = $baseName . ($count + 1);
        } else {
            $newName = $baseName . "1";
        }

        $stmt = $dsn->prepare("INSERT INTO packs (name, idUser) VALUES (:name, :idUser)");
        $stmt->bindParam(':name', $newName);
        $stmt->bindParam(':idUser', $idUser);

        if ($stmt->execute()) {
            $idPack = $dsn->lastInsertId();

            $stmtInsertCards = $dsn->prepare("INSERT INTO cardPacks (idCard, idPacks) VALUES (:idCard, :idPack)");
            foreach ($id15Card as $idCard) {
                $stmtInsertCards->bindParam(':idCard', $idCard, PDO::PARAM_INT);
                $stmtInsertCards->bindParam(':idPack', $idPack, PDO::PARAM_INT);
                $stmtInsertCards->execute();
            }
            echo "Pack de 15 card acheté.";
        } else {
            echo "Échec de l'achat du pack de 15 card.";

        }
    } catch (PDOException $e) {
        $error  = "Erreur : " . $e->getMessage();
        echo $error;
    }
}
