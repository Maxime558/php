<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_name'])) {
    header("Location: /login");
    exit();
}

require 'models/Database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: /error");
    exit();
}

$user_id = $_SESSION['user_id'];

$notes = $connexion->prepare('SELECT * FROM note WHERE user_id = :user_id ORDER BY id DESC');
$notes->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$notes->execute();
$notes = $notes->fetchAll();

if (count($notes) > 0) {
    require 'views/note/notes.view.php';
} else {
    $errorMessage = "Aucune note n'a été trouvée.";
    require 'views/error.view.php'; 
}
?>
