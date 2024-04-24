<?php 

require_once './database/connect.php';

if (!function_exists('insertUser')) {
    function insertUser($first_Name, $last_Name, $email_, $hashed_password)
    {
        try {
            $dsn = new PDO("mysql:host=mysql;dbname=my_database", "my_user", "my_password");
            $dsn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $dsn->prepare("SELECT COUNT(*) FROM user WHERE email = :email");
            $stmt->bindParam(':email', $email_);
            $stmt->execute();

            if ($stmt->fetchColumn() > 0) {
                echo "email deja existant";
                return;
            } else {
                $stmt2 = $dsn->prepare("INSERT INTO user (firstName, lastName, email, passwordUser) VALUES (:firstName, :lastName, :email, :passwordUser)");
                $stmt2->bindParam(':lastName', $last_Name);
                $stmt2->bindParam(':firstName', $first_Name);
                $stmt2->bindParam(':email', $email_);
                $stmt2->bindParam(':passwordUser', $hashed_password);
                $stmt2->execute();
                echo "register OK";
            }

        } catch (PDOException $e) {
            $error  = "error: " . $e->getMessage();
            echo $error;
        }
    }
}