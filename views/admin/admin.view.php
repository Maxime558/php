<?php require 'views/partials/header.php'; ?>


<h1>Dashboard</h1>
<button><a href="/note-new">Crée une nouvelle note</a></button>
<table border="1">
    <tr>
        <th>Note ID</th>
        <th>User ID</th>
        <th>Title</th>
        <th>Content</th>
        <th>Image</th>
        <th>User</th>
        <th>Actions</th>
    </tr>

    <?php if (!empty($notes)) : ?>
        <?php foreach ($notes as $note) : ?>
            <tr>
                <td><?= $note['Note_ID']; ?></td>
                <td><?= $note['User_ID']; ?></td>
                <td><?= $note['Title']; ?></td>
                <td><?= $note['Content']; ?></td>
                <td>
                    <?php
                    $imageName = $note['File_Name'];
                    if (!empty($imageName)) {
                        $imagePath = "/uploads/$imageName";
                        echo "<img src='$imagePath' alt='Image' style='max-width: 80px; max-height: 80px;'>";
                    } else {
                        echo "Aucune image";
                    }
                    ?>
                </td>

                <td><?= $note['Name']; ?></td>
                <td class="actions">
                    <?php
                    $noteId = $note['Note_ID'];
                    $viewLink = "note?id=$noteId";
                    $updateLink = "note-update?id=$noteId";
                    $deleteLink = "note-delete?id=$noteId";
                    ?>
                    <button><a href="<?= $viewLink ?>">Voir</a></button>
                    <button><a href="<?= $updateLink ?>">Modifier</a></button>
                    <button><a href="<?= $deleteLink ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette note ?')">Supprimer</a></button>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else : ?>
        <tr>
            <td colspan="7">Aucune note trouvée.</td>
        </tr>
    <?php endif; ?>
</table>

<?php require 'views/partials/footer.php'; ?>