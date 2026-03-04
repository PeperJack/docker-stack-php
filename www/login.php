<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page de connexion</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h2>Connexion</h2>
        <form action="traitement.php" method="POST">
            <div class="form-group">
                <label for="login">Identifiant :</label>
                <input type="text" id="login" name="login" required>
            </div>
            <div class="form-group">
                <label for="password">Mot de passe :</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Se connecter</button>
        </form>
        <p style="text-align: center; margin-top: 20px;">
            Pas de compte ? <a href="register.php" style="color: #333;">S'inscrire</a>
        </p>
    </div>
</body>
</html>
