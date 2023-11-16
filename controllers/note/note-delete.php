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

if (isset($id)) {
    $deleteNote = $connexion->prepare('DELETE FROM note WHERE id = :id');
    $deleteNote->bindParam(':id', $id);

    if ($deleteNote->execute()) {
        if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1) {
            header('Location: /admin');
            exit();
        } else {
            header('Location: /notes');
            exit();
        }
    } else {
        echo "Error.";
    }
}

require 'views/note/note-delete.view.php';
