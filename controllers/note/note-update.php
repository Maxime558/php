<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_name'])) {
    header("Location: /login");
    exit();
}
require 'models/Database.php';

$requete = "SELECT user_id, name FROM user";
$users = $connexion->query($requete)->fetchAll();

if (!isset($_GET['id']) || !is_numeric($_GET['id']) || empty($_GET['id'])) {
    abort();
}

$id = $_GET['id'];

$noteUpdate = $connexion->prepare('SELECT n.id, u.user_id, n.title, n.content, n.created_at, u.name, n.file_name FROM note AS n INNER JOIN user AS u ON n.user_id = u.user_id WHERE n.id = :id');

$noteUpdate->bindParam(':id', $id);

$noteUpdate->execute();

$noteUpdate = $noteUpdate->fetch();

if (empty($noteUpdate) || $noteUpdate === false) {
    abort();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = [];
    $title = trim(filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $content = trim(filter_var($_POST['content'], FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $author = trim(filter_var($_POST['author'], FILTER_SANITIZE_NUMBER_INT));
    
    $fileToUpload = $_FILES['fileToUpload'];

    if ($fileToUpload['error'] === UPLOAD_ERR_OK) {
        
        $fileName = basename($fileToUpload['name']);
        $uploadPath = "uploads/" . $fileName;

        if (move_uploaded_file($fileToUpload['tmp_name'], $uploadPath)) {
            $noteUpdate['file_name'] = $fileName;
        } else {
            $errors[] = "Erreur lors de l'upload de l'image.";
        }
    }
    
    if (strlen($title) === 0) {
        $errors[] = 'Titre vide !!!';
    }

    if (strlen($title) >= 100) {
        $errors[] = 'Titre trop long !!!';
    }

    if (strlen($content) === 0) {
        $errors[] = 'Contenu vide !!!';
    }

    if (strlen($content) >= 1000) {
        $errors[] = 'Contenu supérieur à 1000 caractères !!!';
    }

    if (empty($_POST['author']) || strlen($_POST['author'] === 0)) {
        $errors[] = 'Aucun auteur sélectionné !!!';
    }

    if (empty($errors)) {
        $noteNew = $connexion->prepare('UPDATE note SET title = :title, content = :content, user_id = :user_id, file_name = :file_name WHERE id = :id');

        $noteNew->bindParam(':title', $title, PDO::PARAM_STR);
        $noteNew->bindParam(':content', $content, PDO::PARAM_STR);
        $noteNew->bindParam(':user_id', $author, PDO::PARAM_INT);
        $noteNew->bindParam(':file_name', $fileName, PDO::PARAM_STR);
        $noteNew->bindParam(':id', $id, PDO::PARAM_INT);

        $noteNew->execute();
        header('Location: /notes');
        exit();
    }
}

include 'views/note/note-update.view.php';
