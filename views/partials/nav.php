<?php error_reporting(0);
ini_set('display_errors', 0); ?>

<nav>
    <ul>
        <?php
        if (isset($_SESSION['user_name'])) {
            echo '<li>Bonjour, ' . $_SESSION['user_name'] . '</li>';
            echo '<li><a href="/connected">Accueil</a></li>';

            if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1) {

                echo '<li><a href="/admin">Toutes les notes</a></li>';
                echo '<li><a href="/users">Tous les utilisateurs</a></li>';
            } else {

                echo '<li><a href="/notes">Notes</a></li>';
                echo '<li><a href="/note-new">Créer une note</a></li>';
                echo '<li><a href="/contact">Contact</a></li>';
            }

            echo '<li><a href="../controllers/user/disconnect.php">Se déconnecter</a></li>';
        } else {

            echo '<li><a href="/">Index</a></li>';
            echo '<li><a href="/register">S\'inscrire</a></li>';
            echo '<li><a href="/login">Se connecter</a></li>';
        }
        ?>
    </ul>
</nav>
