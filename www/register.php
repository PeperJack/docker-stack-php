<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h2>Créer un compte</h2>
        <form action="register_process.php" method="POST">
            <div class="form-group">
                <label for="login">Identifiant :</label>
                <input type="text" id="login" name="login" required minlength="3" maxlength="50">
            </div>
            <div class="form-group">
                <label for="password">Mot de passe :</label>
                <input type="password" id="password" name="password" required minlength="6">
                <div id="password-requirements" style="margin-top: 10px; font-size: 0.9em;">
                    <div id="req-length" class="requirement">
                        <span class="icon">X</span> Au moins 6 caractères
                    </div>
                    <div id="req-uppercase" class="requirement">
                        <span class="icon">X</span> Au moins une lettre majuscule
                    </div>
                    <div id="req-number" class="requirement">
                        <span class="icon">X</span> Au moins un chiffre
                    </div>
                    <div id="req-special" class="requirement">
                        <span class="icon">X</span> Au moins un caractère spécial (!@#$%^&*()_+-=[]{}|;:'",.<>?/\~`)
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="password_confirm">Confirmer le mot de passe :</label>
                <input type="password" id="password_confirm" name="password_confirm" required>
            </div>
            <button type="submit">S'inscrire</button>
        </form>
        <p style="text-align: center; margin-top: 20px;">
            Déjà un compte ? <a href="login.php" style="color: #333;">Se connecter</a>
        </p>
    </div>

    <script>
        const passwordInput = document.getElementById('password');
        const requirements = {
            length: document.getElementById('req-length'),
            uppercase: document.getElementById('req-uppercase'),
            number: document.getElementById('req-number'),
            special: document.getElementById('req-special')
        };

        passwordInput.addEventListener('input', function() {
            const password = this.value;

            // longueur check
            checkRequirement(requirements.length, password.length >= 6);

            // check la majuscule
            checkRequirement(requirements.uppercase, /[A-Z]/.test(password));

            // check si chiffre
            checkRequirement(requirements.number, /[0-9]/.test(password));

            // charactère spécial check
            checkRequirement(requirements.special, /[!@#$%^&*()_+\-=\[\]{}|;:'",.<>\/?\\~`]/.test(password));
        });

        function checkRequirement(element, isValid) {
            const icon = element.querySelector('.icon');
            if (isValid) {
                element.style.color = '#28a745';
                icon.textContent = '✓';
            } else {
                element.style.color = '#dc3545';
                icon.textContent = 'X';
            }
        }
    </script>

    <style>
        .requirement {
            padding: 5px 0;
            transition: color 0.3s;
            color: #dc3545;
        }
        .requirement .icon {
            font-weight: bold;
            margin-right: 5px;
        }
    </style>
</body>
</html>