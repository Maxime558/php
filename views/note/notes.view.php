<?php require 'views/partials/header.php'; ?>
<title>Notes</title>
<h1 id="notes">Notes :</h1><hr id="hr1">
<ul>
  <?php foreach ($notes as $note) : ?>
    <li class="note">
      <a href="/note?id=<?= $note['id'] ?>"> <?= $note['title'] ?> </a>
      <button id="croix" href="/note-delete?id=<?= $note['id'] ?>" onclick="return confirm('Etes vous certain de vouloir supprimer cette note ?')"> X </button>
    </li>
  <?php endforeach; ?>
  <ul>
      <li id="new-note2">
        <button><a id="new-note" href="/note-new">Crée une nouvelle note</a></button>
      </li>
    </ul>
</ul>
<?php require 'views/partials/footer.php'; ?>