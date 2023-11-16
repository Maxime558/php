<?php
require 'models/Database.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['signup_submit'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $connexion->prepare("SELECT * FROM user WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $errors = "Utilisateur existant";
    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $insert = $connexion->prepare("INSERT INTO user (name, email, password) VALUES (:name, :email, :password)");
        $insert->bindParam(':name', $username);
        $insert->bindParam(':email', $email);
        $insert->bindParam(':password', $hashedPassword);

        if ($insert->execute()) {
            $stmt = $connexion->prepare("SELECT * FROM user WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];

            header("Location: /connected");
            exit();
        } else {
            $errors = "Erreur lors de l'inscription";
        }
    }
}

include 'views/user/register.view.php';
?>