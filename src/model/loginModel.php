<?php

if (!function_exists('login')) {
    function login($login_email, $login_password)
    {
        try {
            $dsn = new PDO("mysql:host=mysql;dbname=my_database", "my_user", "my_password");
            $dsn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $dsn->prepare("SELECT * FROM user WHERE email = :email");
            $stmt->bindParam("email", $login_email);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (password_verify($login_password, $user["passwordUser"])) {
                $_SESSION['idUser'] = $user['idUser'];
                $_SESSION['lastName'] = $user['lastName'];
                $_SESSION['firstName'] = $user['firstName'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['passwordUser'] = $user['passwordUser'];
                $_SESSION['isAdmin'] = $user['isAdmin'];

                echo "Login successful!";
            } else {
                echo "email ou mot de passe incorrect";
            }

        } catch (PDOException $e) {
            $error = "Error: " . $e->getMessage();
            echo $error;
        }
    }
}
