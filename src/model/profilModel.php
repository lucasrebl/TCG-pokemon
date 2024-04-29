<?php

require_once './database/connect.php';

function openPacksOfCard($packsName, $idUser)
{
    try {
        $dsn = new PDO("mysql:host=mysql;dbname=my_database", "my_user", "my_password");
        $dsn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmtGetIdPack = $dsn->prepare("SELECT idPacks FROM packs WHERE name = :name");
        $stmtGetIdPack->bindParam(':name', $packsName);
        $stmtGetIdPack->execute();
        $idPack = $stmtGetIdPack->fetch();

        if ($idPack !== false) { // Vérifiez si le résultat n'est pas faux
            $idPack = $idPack['idPacks'];
            var_dump($idPack);

            $stmtGetIdCard = $dsn->prepare("SELECT idCard FROM cardPacks WHERE idPacks = :idPack");
            $stmtGetIdCard->bindParam(':idPack', $idPack);
            $stmtGetIdCard->execute();
            $idCard = $stmtGetIdCard->fetchAll(PDO::FETCH_COLUMN);

            foreach ($idCard as $id) {
                $checkQuery = "SELECT COUNT(*) FROM collection WHERE idCard = :idCard AND idUser = :idUser";
                $stmt = $dsn->prepare($checkQuery);
                $stmt->bindParam(':idCard', $id);
                $stmt->bindParam(':idUser', $idUser);
                $stmt->execute();
                $count = $stmt->fetchColumn();

                if ($count == 0) {
                    $insertQuery = "INSERT INTO collection (idUser, idCard) VALUES (:idUser, :idCard)";
                    $stmt2 = $dsn->prepare($insertQuery);
                    $stmt2->bindParam(':idUser', $idUser);
                    $stmt2->bindParam(':idCard', $id);

                    if ($stmt2->execute()) {
                        $updateQuery = "UPDATE packs SET isOpen = 1 WHERE idPacks = :idPack";
                        $stmtUpdate = $dsn->prepare($updateQuery);
                        $stmtUpdate->bindParam(':idPack', $idPack);
                        $stmtUpdate->execute();

                        echo "pack ouvert,\n";
                    } else {
                        echo "echec ouverture du pack";
                    }
                }
            }
        } else {
            echo "id pack";
        }
    } catch (PDOException $e) {
        $error  = "error: " . $e->getMessage();
        echo $error;
    }
}
