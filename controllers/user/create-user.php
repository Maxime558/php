<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_name'])) {
    header("Location: /login");
    exit();
}

require 'models/Database.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    if (!empty($name) && !empty($email) && !empty($password)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $insert_query = "INSERT INTO `user` (`name`, `email`, `password`) VALUES (:name, :email, :password)";
        $stmt = $connexion->prepare($insert_query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashedPassword);

        if ($stmt->execute()) {
            header("Location: /users");
            exit;
        } else {
            echo "Erreur lors de l'insertion de l'utilisateur.";
        }
    } else {
        echo "Veuillez remplir tous les champs.";
    }
}

require 'views/user/create-user.view.php';