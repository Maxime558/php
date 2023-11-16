<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_name'])) {
    header("Location: /login");
    exit();
}

require 'models/Database.php';

$select_query = "SELECT * FROM `user`";
$stmt = $connexion->query($select_query);
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['user_id'])) {
        $user_id = $_POST['user_id'];

        $delete_query = "DELETE FROM `user` WHERE `user_id` = :user_id";
        $delete_stmt = $connexion->prepare($delete_query);
        $delete_stmt->bindParam(':user_id', $user_id);
        $delete_stmt->execute();

        header("Location: users");
        exit;
    }
}

include 'views/admin/users.view.php';