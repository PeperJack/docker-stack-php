<?php
require_once 'includes/db.php';

// Requête POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login'] ?? '');
    $password = $_POST['password'] ?? ''; 
    $password_confirm = $_POST['password_confirm'] ?? '';  
    
    $errors = [];
    
    // Vérifications de base des champs
    if (strlen($login) < 3) {
        $errors[] = "L'identifiant doit contenir au moins 3 caractères.";
    }
    
    // Vérification du mot de passe
    $password_missing = [];

    if (strlen($password) < 6) {
        $password_missing[] = "au moins 6 caractères";
    }

    if (!preg_match('/[A-Z]/', $password)) {
        $password_missing[] = "une lettre majuscule";
    }

    if (!preg_match('/[0-9]/', $password)) {
        $password_missing[] = "un chiffre";
    }

    if (!preg_match('/[!@#$%^&*()_+\-=\[\]{}|;:\'",.><\/?\\\\~`]/', $password)) {
        $password_missing[] = "un caractère spécial";
    }

    if (!empty($password_missing)) {
        $errors[] = "Il manque : " . implode(", ", $password_missing) . ".";
    }
    
    if ($password !== $password_confirm) {
        $errors[] = "Les mots de passe ne correspondent pas.";
    }
    
    // On vérifie si l'utilisateur existe déjà
    if (empty($errors)) {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE login = :login");
        $stmt->execute(['login' => $login]);
        if ($stmt->fetch()) {
            $errors[] = "l'utilisateur existe déjà";
        }
    }
    
    // Création utilisateur
    if (empty($errors)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (login, password) VALUES (:login, :password)");
        
        try {
            $stmt->execute([
                'login' => $login,
                'password' => $hashedPassword
            ]);
            $success = true;
        } catch(PDOException $e) {
            $errors[] = "Erreur lors de la création du compte : " . $e->getMessage();
        }
    }
}


?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultat inscription</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .success {
            background: #d4edda;
            border-left: 3px solid #28a745;
            color: #155724;
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        .error {
            background: #f8d7da;
            border-left: 3px solid #dc3545;
            color: #721c24;
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Résultat de l'inscription</h2>
        
        <?php if (isset($success) && $success): ?>
            <div class="success">
                <strong>Compte crée avec succès</strong>
            </div>
            <div class="info">
                <strong>Identifiant :</strong> <?= htmlspecialchars($login) ?>
            </div>
            <a href="login.php" class="back-btn">Se connecter</a>
        <?php elseif (!empty($errors)): ?>
            <div class="error">
                <strong>Erreurs :</strong>
                <ul style="margin: 10px 0 0 20px;">
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <a href="register.php" class="back-btn">Retour au formulaire</a>
        <?php else: ?>
            <div class="error">
                <strong>Aucune donnée reçue</strong>
            </div>
            <a href="register.php" class="back-btn">Retour au formulaire</a>
        <?php endif; ?>
    </div>
</body>
</html>