<?php
// =============================================
// connexion_bdd.php — Connexion à MySQL
// =============================================

$hote       = "localhost";
$utilisateur = "root";
$mot_passe  = "";          // Vide par défaut sur WAMP
$base       = "autolux";   // Nom de votre base de données

$conn = new mysqli($hote, $utilisateur, $mot_passe, $base);

if ($conn->connect_error) {
    die("❌ Connexion BDD échouée : " . $conn->connect_error);
}

$conn->set_charset("utf8");
?>
