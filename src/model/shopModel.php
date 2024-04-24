<?php

require_once './database/connect.php';


function insertIdOfCard($pokemonIds)
{
    try {
        $dsn = new PDO("mysql:host=mysql;dbname=my_database", "my_user", "my_password");
        $dsn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Insertion des IDs des cartes Pokémon dans la base de données
        foreach ($pokemonIds as $id) {
            $insertQuery = "INSERT INTO card (idApi) VALUES (:idApi)";
            $stmt = $dsn->prepare($insertQuery);
            $stmt->bindParam(':idApi', $id);
            $stmt->execute();
        }

        echo "Les données ont été insérées dans la base de données avec succès.";
    } catch (PDOException $e) {
        $error  = "error: " . $e->getMessage();
        echo $error;
    }
}
