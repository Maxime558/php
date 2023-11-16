<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_name'])) {
    header("Location: /login");
    exit();
}

require 'models/Database.php';

$notes = $connexion->query('SELECT * FROM note ORDER BY id DESC')->fetchAll();


require 'views/note/notes.view.php';
