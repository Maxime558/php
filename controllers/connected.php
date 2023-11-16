<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_name'])) {
    header("Location: /login");
    exit();
}

require 'views/connected.view.php';
