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
    $sql = "SELECT note.id AS Note_ID, note.user_id AS User_ID, user.name AS Name, note.title AS Title, note.content AS Content, note.file_name AS File_Name
    FROM note
    LEFT JOIN user ON note.user_id = user.user_id";

    $result = $connexion->query($sql);

    if ($result) {
        $notes = $result->fetchAll();

        foreach ($notes as $key => $note) {
            $notes[$key]['Content'] = (mb_strlen($note['Content']) > 80) ? mb_substr($note['Content'], 0, 80) . '...' : $note['Content'];
        }
    } else {
        $notes = [];
        error_log("Error querying the database for notes.");
    }
} catch (PDOException $e) {
    error_log("Database Error: " . $e->getMessage());
}

require 'views/admin/admin.view.php';
