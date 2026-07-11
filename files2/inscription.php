<?php
// =============================================
// inscription.php — Traitement de l'inscription
// =============================================

require_once "connexion_bdd.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: formulaire.php");
    exit();
}

// --- 1. Récupérer les données ---
$nom        = trim($_POST["nom"] ?? '');
$prenom     = trim($_POST["prenom"] ?? '');
$email      = trim($_POST["email"] ?? '');
$telephone  = trim($_POST["telephone"] ?? '');
$sexe       = trim($_POST["sexe"] ?? '');
$mdp        = $_POST["mot_de_passe"] ?? '';
$mdp_conf   = $_POST["confirmer_mdp"] ?? '';

// --- 2. Validations ---
if (empty($nom) || empty($prenom) || empty($email) || empty($mdp) || empty($sexe)) {
    header("Location: formulaire.php?err_signup=Tous+les+champs+sont+obligatoires.");
    exit();
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header("Location: formulaire.php?err_signup=Adresse+email+invalide.");
    exit();
}

if (strlen($mdp) < 6) {
    header("Location: formulaire.php?err_signup=Le+mot+de+passe+doit+faire+au+moins+6+caractères.");
    exit();
}

if ($mdp !== $mdp_conf) {
    header("Location: formulaire.php?err_signup=Les+mots+de+passe+ne+correspondent+pas.");
    exit();
}

// --- 3. Vérifier si l'email est déjà pris ---
$verif = $conn->prepare("SELECT id FROM clients WHERE email = ?");
$verif->bind_param("s", $email);
$verif->execute();
$verif->store_result();

if ($verif->num_rows > 0) {
    header("Location: formulaire.php?err_signup=Cet+email+est+déjà+utilisé.");
    exit();
}
$verif->close();

// --- 4. Chiffrer le mot de passe ---
$mdp_hash = password_hash($mdp, PASSWORD_BCRYPT);

// --- 5. Insérer dans la base ---
$sql = $conn->prepare("
    INSERT INTO clients (nom, prenom, genre, email, telephone, mot_de_passe)
    VALUES (?, ?, ?, ?, ?, ?)
");
$sql->bind_param("ssssss", $nom, $prenom, $sexe, $email, $telephone, $mdp_hash);

if ($sql->execute()) {
    header("Location: formulaire.php?msg_signup=Inscription+réussie+!+Bienvenue+$prenom+👋&form=login");
} else {
    header("Location: formulaire.php?err_signup=Erreur+lors+de+l'inscription.+Réessayez.");
}

$sql->close();
$conn->close();
?>
