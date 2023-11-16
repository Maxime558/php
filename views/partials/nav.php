<?php error_reporting(0);
ini_set('display_errors', 0); ?>

<nav>
    <ul>
        <?php
        if (isset($_SESSION['user_name'])) {
            echo '<li>Bonjour, ' . $_SESSION['user_name'] . '</li>';
            echo '<li><a href="/connected">Accueil</a></li>';

            if ($_SESSION['is_admin']) {
                echo '<li><a href="/admin">Admin</a></li>';
                echo '<li><a href="/users">User</a></li>';
            } else {
                echo '<li><a href="/notes">Notes</a></li>';
                echo '<li><a href="/note-new">Crée une note</a></li>';
                echo '<li><a href="/contact">Contact</a></li>';
            }

            echo '<li><a href="../controllers/user/disconnect.php">Se déconnecter</a></li>';
        } else {
            echo '<li><a href="/">Index</a></li>';
            echo `<li><a href="/register">S'inscrire</a></li>`;
            echo '<li><a href="/login">Login</a></li>';
        }
        ?>
    </ul>
</nav>