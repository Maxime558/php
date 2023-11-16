<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_name'])) {
    header("Location: /login");
    exit();
}

require 'models/Database.php';

try {
    $sql = "SELECT note.id AS Note_ID, note.user_id AS User_ID, user.name AS Name, note.title AS Title, note.content AS Content 
            FROM note
            LEFT JOIN user ON note.user_id = user.user_id";

    $result = $connexion->query($sql);

    if ($result) {
        $notes = $result->fetchAll();

        foreach ($notes as &$note) {
            $note['Content'] = (strlen($note['Content']) > 80) ? substr($note['Content'], 0, 80) . '...' : $note['Content'];
        }
    } else {
        $notes = [];
        echo "Aucun résultat trouvé dans la table note.";
    }
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}

require 'views/admin/index.view.php';