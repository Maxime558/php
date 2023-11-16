<?php require 'views/partials/header.php'; ?>

<title>Tableau de bord des utilisateurs</title>
<h1>Tableau de bord des utilisateurs</h1>
<button><a href="create-user">Créer un nouvel utilisateur</a></button>
<table>
    <tr>
        <th>Nom</th>
        <th>ID</th>
        <th>Email</th>
        <th>Action</th>
    </tr>
    <?php foreach ($users as $user) : ?>
        <?php if ($user['is_admin'] != 1) : ?>
            <tr>
                <td><?php echo $user['name']; ?></td>
                <td><?php echo $user['user_id']; ?></td>
                <td><?php echo $user['email']; ?></td>
                <td>
                    <button> <a href="edit-user?user_id=<?php echo $user['user_id']; ?>">Modifier</a> </button>
                    <form method="POST">
                        <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">
                        <button type="submit">Supprimer</button>
                    </form>
                </td> 
            </tr>
        <?php endif; ?>
    <?php endforeach; ?>
</table>

<?php require 'views/partials/footer.php' ?>
