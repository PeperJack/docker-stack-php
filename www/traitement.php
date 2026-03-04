<?php
require_once 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = $_POST['login'] ?? '';
    $password = $_POST['password'] ?? '';
    
    $stmt = $pdo->prepare("SELECT * FROM users WHERE login = :login");
    $stmt->execute(['login' => $login]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user && password_verify($password, $user['password'])) {
        if (!empty($user['disabled_at'])) {
            $success = false;
            $message = "Ce compte est désactivé.";
        } else {
            $success = true;
            $message = "Connexion ok";
        }
    } else {
        $success = false;
        $message = "login ou mot de passe incorrect";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultat</title>
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
        <h2>Résultat de connexion</h2>
        
        <?php if (isset($success)): ?>
            <div class="<?= $success ? 'success' : 'error' ?>">
                <strong><?= $message ?></strong>
            </div>
            
            <?php if ($success): ?>
                <div class="info">
                    <strong>Utilisateur :</strong> <?= htmlspecialchars($user['login']) ?>
                </div>
                <div class="info">
                    <strong>ID :</strong> <?= htmlspecialchars($user['id']) ?>
                </div>
                <div class="info">
                    <strong>Inscrit le :</strong> <?= htmlspecialchars($user['created_at']) ?>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <p class="error">Donné non reçu</p>
        <?php endif; ?>
        
        <a href="login.php" class="back-btn">Retour au formulaire</a>
    </div>
</body>
</html>