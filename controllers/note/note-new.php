<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_name'])) {
    header("Location: /login");
    exit();
}

require 'models/Database.php';

$requete = 'SELECT user_id, name FROM user';
$users = $connexion->query($requete)->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = [];

    $target_dir = "uploads/";

    if (isset($_FILES['fileToUpload']) && $_FILES['fileToUpload']['error'] === UPLOAD_ERR_OK) {
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        if (file_exists($target_file)) {
            $errors[] = "Le fichier existe déjà.";
            $uploadOk = 0;
        }

        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($imageFileType, $allowedExtensions)) {
            $errors[] = "Seuls les fichiers JPG, JPEG, PNG et GIF sont autorisés.";
            $uploadOk = 0;
        }

        if ($uploadOk == 1) {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                $successMessage = "Le fichier " . basename($_FILES["fileToUpload"]["name"]) . " a été téléchargé.";
            } else {
                $errors[] = "Désolé, une erreur s'est produite lors du téléchargement de votre fichier.";
            }
        }
    }

    $title = trim(filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $content = trim(filter_var($_POST['content'], FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $user = trim(filter_var($_POST['user'], FILTER_SANITIZE_NUMBER_INT));

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
        $errors[] = 'Contenu supérieur à 1000 caratéres !!!';
    }

    if (empty($_POST['user']) || strlen($_POST['user'] === 0)) {
        $errors[] = 'Aucun auteur séléctionné !!!';
    }

    if (empty($errors)) {
        $fileName = basename($_FILES["fileToUpload"]["name"]);

        $noteNew = $connexion->prepare('INSERT INTO note (title, content, user_id, file_name) VALUES (:title, :content, :user_id, :file_name)');
    
        $noteNew->bindParam(':title', $title, PDO::PARAM_STR);
        $noteNew->bindParam(':content', $content, PDO::PARAM_STR);
        $noteNew->bindParam(':user_id', $user, PDO::PARAM_INT);
        $noteNew->bindParam(':file_name', $fileName, PDO::PARAM_STR);
    
        try {
            $connexion->beginTransaction();
            $noteNew->execute();
            $lastInsertId = $connexion->lastInsertId();
            $connexion->commit();
        } catch (PDOException $e) {
            $connexion->rollBack();
            $errors[] = "Database error: " . $e->getMessage();
        }
    
        if (empty($errors) && $lastInsertId) {
            header('Location: /notes');
            exit();
        }
    }
}

include 'views/note/note-new.view.php';