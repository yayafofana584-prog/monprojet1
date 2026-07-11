<?php
// =============================================
// dashboard.php — Page après connexion
// =============================================

session_start();

// Si l'utilisateur n'est pas connecté, le renvoyer au formulaire
if (!isset($_SESSION["user_id"])) {
    header("Location: formulaire.php?err_login=Veuillez+vous+connecter.&form=login");
    exit();
}

$prenom = htmlspecialchars($_SESSION["user_prenom"]);
$nom    = htmlspecialchars($_SESSION["user_nom"]);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>AutoLux — Tableau de bord</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #0f0c29, #302b63, #24243e);
            display: flex; align-items: center; justify-content: center;
            font-family: 'DM Sans', sans-serif;
        }
        .card {
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: 20px;
            padding: 3rem 2.5rem;
            text-align: center;
            max-width: 460px;
            width: 90%;
            color: #f1f5f9;
        }
        .logo {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            color: #c9a96e;
            margin-bottom: 0.5rem;
        }
        h2 { font-size: 1.4rem; margin-bottom: 0.5rem; }
        p  { color: #94a3b8; margin-bottom: 2rem; font-size: 0.95rem; }
        .badge {
            display: inline-block;
            background: rgba(201,169,110,0.15);
            border: 1px solid #c9a96e;
            color: #c9a96e;
            padding: 0.4rem 1.2rem;
            border-radius: 50px;
            font-size: 0.85rem;
            margin-bottom: 2rem;
        }
        .btn-logout {
            display: inline-block;
            padding: 0.75rem 2rem;
            background: #c9a96e;
            color: #0f0c29;
            border-radius: 10px;
            font-weight: 700;
            text-decoration: none;
            font-size: 0.95rem;
            transition: opacity 0.2s;
        }
        .btn-logout:hover { opacity: 0.85; }
    </style>
</head>
<body>
    <div class="card">
        <div class="logo">AutoLux</div>
        <div class="badge">✅ Connecté</div>
        <h2>Bienvenue, <?= $prenom ?> <?= $nom ?> !</h2>
        <p>Vous êtes connecté à votre espace AutoLux.<br>Votre spécialiste en véhicules premium à Abidjan.</p>
        <a href="deconnexion.php" class="btn-logout">Se déconnecter</a>
    </div>
</body>
</html>
