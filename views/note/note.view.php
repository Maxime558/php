<?php require 'views/partials/header.php'; ?>

<h1>Notes :</h1>
<hr>
<h2><?= $note['title'] ?></h2>
<p><?= $note['content'] ?></p>
<p>Publiée le : <?= $note['created_at'] ?> par : <?= $note['author_name'] ?> </p>
<?= $imageTag ?> 
<p><a href="/note-update?id=<?= $note['id'] ?>" class="btn">Modifier cette note</a></p>
<p><a href="/note-delete?id=<?= $note['id'] ?>" onclick="return confirm('Etes vous certain de vouloir supprimer cette note ?')">Supprimer cette note</a></p>

<?php
if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1) {
    echo '<p><a href="/admin">Retour à la liste des notes</a></p>';
} else {
    echo '<p><a href="/notes">Retour à la liste des notes</a></p>';
}

require 'views/partials/footer.php';
?>
