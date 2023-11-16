<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_name'])) {
    header("Location: /login");
    exit();
}

require 'models/Database.php';

$id = $_GET['id'];

$note = $connexion->prepare('SELECT note.*, user.name AS author_name FROM note LEFT JOIN user ON note.user_id = user.user_id WHERE note.id = :id');
$note->bindParam(':id', $id);
$note->execute();
$note = $note->fetch();

$imagePath = 'uploads/' . $note['file_name'];
$imageTag = '';

if (!empty($note['file_name']) && file_exists($imagePath)) {
    $imageTag = '<img src="' . $imagePath . '" alt="Image de la note">';
}

require 'views/note/note.view.php';