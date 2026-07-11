<?php
// =============================================
// connexion_bdd.example.php — Modèle de configuration
// Copiez ce fichier en "connexion_bdd.php" et remplissez
// vos propres identifiants. Ce fichier exemple, lui,
// peut être publié sans risque sur GitHub.
// =============================================

$hote        = "localhost";
$utilisateur = "root";
$mot_passe   = "";
$base        = "autolux";

$conn = new mysqli($hote, $utilisateur, $mot_passe, $base);

if ($conn->connect_error) {
    die("❌ Connexion BDD échouée : " . $conn->connect_error);
}

$conn->set_charset("utf8");
?>
