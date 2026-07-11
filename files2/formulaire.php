<?php
// Afficher les messages d'erreur ou succès venant des scripts PHP
$message_inscription = isset($_GET['msg_signup']) ? $_GET['msg_signup'] : '';
$message_connexion   = isset($_GET['msg_login'])  ? $_GET['msg_login']  : '';
$erreur_inscription  = isset($_GET['err_signup']) ? $_GET['err_signup'] : '';
$erreur_connexion    = isset($_GET['err_login'])  ? $_GET['err_login']  : '';

// Si un formulaire a échoué, on réaffiche le bon formulaire
$show_login = isset($_GET['form']) && $_GET['form'] === 'login';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AutoLux — Inscription / Connexion</title>
    <link rel="stylesheet" href="stylebtn.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        .alert {
            padding: 0.75rem 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            font-size: 0.9rem;
            font-weight: 500;
        }
        .alert-success { background: #d1fae5; color: #065f46; border: 1px solid #6ee7b7; }
        .alert-error   { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }
    </style>
</head>
<body>

    <div class="page-wrapper">
        <div class="brand">
            <div class="logo">AutoLux</div>
            <p class="tagline">Votre spécialiste en véhicules premium à Abidjan</p>
        </div>

        <div class="form-box">
            <div class="toggle-buttons">
                <button id="showSignup" class="<?= !$show_login ? 'active' : '' ?>">Inscription</button>
                <button id="showLogin"  class="<?= $show_login  ? 'active' : '' ?>">Connexion</button>
            </div>

            <!-- ===================== FORMULAIRE INSCRIPTION ===================== -->
            <form id="signupForm"
                  action="inscription.php"
                  method="POST"
                  class="<?= $show_login ? 'hidden' : '' ?>">

                <?php if ($message_inscription): ?>
                    <div class="alert alert-success"><?= htmlspecialchars($message_inscription) ?></div>
                <?php endif; ?>
                <?php if ($erreur_inscription): ?>
                    <div class="alert alert-error"><?= htmlspecialchars($erreur_inscription) ?></div>
                <?php endif; ?>

                <div class="input-group">
                    <label>Nom</label>
                    <input type="text" name="nom" placeholder="Votre nom" required>
                </div>
                <div class="input-group">
                    <label>Prénom</label>
                    <input type="text" name="prenom" placeholder="Votre prénom" required>
                </div>
                <div class="input-group">
                    <label>Email</label>
                    <input type="email" name="email" placeholder="votre@email.com" required>
                </div>
                <div class="input-group">
                    <label>Mot de passe</label>
                    <input type="password" name="mot_de_passe" placeholder="••••••••" required>
                </div>
                <div class="input-group">
                    <label>Confirmer le mot de passe</label>
                    <input type="password" name="confirmer_mdp" placeholder="••••••••" required>
                </div>
                <div class="input-group">
                    <label>Genre</label>
                    <div class="radio-group">
                        <label class="radio-label">
                            <input type="radio" name="sexe" value="Homme" required>
                            <span>Homme</span>
                        </label>
                        <label class="radio-label">
                            <input type="radio" name="sexe" value="Femme">
                            <span>Femme</span>
                        </label>
                    </div>
                </div>
                <div class="input-group">
                    <label>Téléphone</label>
                    <input type="tel" name="telephone" placeholder="Ex: 0701020304" pattern="[0-9]{10}" required>
                </div>
                <button type="submit" class="btn">S'inscrire</button>
                <p class="form-note">Déjà un compte ? <a href="#" id="switchToLogin">Se connecter</a></p>
            </form>

            <!-- ===================== FORMULAIRE CONNEXION ===================== -->
            <form id="loginForm"
                  action="connexion_user.php"
                  method="POST"
                  class="<?= !$show_login ? 'hidden' : '' ?>">

                <?php if ($message_connexion): ?>
                    <div class="alert alert-success"><?= htmlspecialchars($message_connexion) ?></div>
                <?php endif; ?>
                <?php if ($erreur_connexion): ?>
                    <div class="alert alert-error"><?= htmlspecialchars($erreur_connexion) ?></div>
                <?php endif; ?>

                <div class="input-group">
                    <label>Email</label>
                    <input type="email" name="email" placeholder="votre@email.com" required>
                </div>
                <div class="input-group">
                    <label>Mot de passe</label>
                    <input type="password" name="mot_de_passe" placeholder="••••••••" required>
                </div>
                <a href="#" class="forgot">Mot de passe oublié ?</a>
                <button type="submit" class="btn">Se connecter</button>
                <p class="form-note">Pas encore de compte ? <a href="#" id="switchToSignup">S'inscrire</a></p>
            </form>
        </div>
    </div>

    <script>
        const signupForm = document.getElementById('signupForm');
        const loginForm  = document.getElementById('loginForm');
        const btnSignup  = document.getElementById('showSignup');
        const btnLogin   = document.getElementById('showLogin');

        btnSignup.addEventListener('click', function () {
            signupForm.classList.remove('hidden');
            loginForm.classList.add('hidden');
            btnSignup.classList.add('active');
            btnLogin.classList.remove('active');
        });

        btnLogin.addEventListener('click', function () {
            loginForm.classList.remove('hidden');
            signupForm.classList.add('hidden');
            btnLogin.classList.add('active');
            btnSignup.classList.remove('active');
        });

        document.getElementById('switchToLogin').addEventListener('click', function(e) {
            e.preventDefault();
            btnLogin.click();
        });

        document.getElementById('switchToSignup').addEventListener('click', function(e) {
            e.preventDefault();
            btnSignup.click();
        });
    </script>
</body>
</html>
