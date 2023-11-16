<?php
require 'models/Database.php';

function checkIfAdmin($user_id, $connexion) {
    $stmt = $connexion->prepare("SELECT is_admin FROM user WHERE user_id = :user_id");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result && $result['is_admin']) {
        return true;
    } else {
        return false; 
    }
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login_submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $connexion->prepare("SELECT * FROM user WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        if (password_verify($password, $user['password'])) {
            session_start();
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_id'] = $user['user_id'];
            $is_admin = checkIfAdmin($user['user_id'], $connexion);
            $_SESSION['is_admin'] = $is_admin;

            header("Location: /connected");
            exit();
        } else {
            $errors[] = "Mot de passe incorrect";
        }
    } else {
        $errors[] = "Utilisateur non trouvé";
    }
}

include 'views/user/login.view.php';
?>
