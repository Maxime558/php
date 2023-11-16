<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_name'])) {
    header("Location: /login");
    exit();
}

require 'models/Database.php';

// Assurez-vous que $_SESSION['user_id'] est défini, il devrait contenir l'ID de l'utilisateur connecté
if (!isset($_SESSION['user_id'])) {
    // Redirigez vers une page d'erreur ou gérez l'absence de user_id d'une manière appropriée
    header("Location: /error");
    exit();
}

$user_id = $_SESSION['user_id'];

// Utilisez une requête paramétrée pour éviter les attaques par injection SQL
$notes = $connexion->prepare('SELECT * FROM note WHERE user_id = :user_id ORDER BY id DESC');
$notes->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$notes->execute();
$notes = $notes->fetchAll();

require 'views/note/notes.view.php';