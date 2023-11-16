<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_name'])) {
    header("Location: /login");
    exit();
}
require 'models/Database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST["user_id"];
    $newName = $_POST["name"];
    $newEmail = $_POST["email"];
    $newPassword = $_POST["password"];

    $update_query = "UPDATE `user` SET `name` = :name, `email` = :email";
    $parameters = [
        ':name' => $newName,
        ':email' => $newEmail,
    ];

    if (!empty($newPassword)) {
        $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);
        $update_query .= ", `password` = :password";
        $parameters[':password'] = $newPasswordHash;
    }

    $update_query .= " WHERE `user_id` = :user_id";
    $parameters[':user_id'] = $user_id;

    $stmt = $connexion->prepare($update_query);
    $stmt->execute($parameters);

    header("Location: users");
    exit;
}

if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    $stmt = $connexion->prepare("SELECT * FROM user WHERE user_id = :user_id");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        header("Location: users");
        exit;
    }
}

require 'views/user/edit_user.view.php';
