<!DOCTYPE html>
<html>
<head>
    <title>S'inscrire</title>
    <link rel="stylesheet" href="public/assets/css/register.css">
    <link rel="icon" type="image/x-icon" href="public/assets/images/favicon.ico">
</head>
<body>
    <div id="login-box">
        <div class="left">
            <h1>Sign up</h1>
            <form method="post">
                <input type="text" name="username" placeholder="Username" required>
                <input type="text" name="email" placeholder="E-mail" required>
                <input type="password" name="password" placeholder="Password" required>
                <input type="submit" name="signup_submit" value="Sign me up">
            </form><br>
            <a href="login">Se connecter</a><hr>
            <a href="/">Retour a l'accueil</a>
        </div>
    </div>
</body>
<?php require 'views/partials/footer.php'; ?>