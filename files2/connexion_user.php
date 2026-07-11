<?php
// =============================================
// connexion_user.php — Traitement de la connexion
// =============================================

session_start();
require_once "connexion_bdd.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: formulaire.php");
    exit();
}

// --- 1. Récupérer les données ---
$email = trim($_POST["email"] ?? '');
$mdp   = $_POST["mot_de_passe"] ?? '';

// --- 2. Validations basiques ---
if (empty($email) || empty($mdp)) {
    header("Location: formulaire.php?err_login=Veuillez+remplir+tous+les+champs.&form=login");
    exit();
}

// --- 3. Chercher l'utilisateur dans la BDD ---
$sql = $conn->prepare("SELECT id, nom, prenom, mot_de_passe FROM clients WHERE email = ?");
$sql->bind_param("s", $email);
$sql->execute();
$result = $sql->get_result();

if ($result->num_rows === 0) {
    // Email introuvable
    header("Location: formulaire.php?err_login=Email+ou+mot+de+passe+incorrect.&form=login");
    exit();
}

$user = $result->fetch_assoc();

// --- 4. Vérifier le mot de passe ---
if (!password_verify($mdp, $user["mot_de_passe"])) {
    header("Location: formulaire.php?err_login=Email+ou+mot+de+passe+incorrect.&form=login");
    exit();
}

// --- 5. Connexion réussie → Créer la session ---
$_SESSION["user_id"]  = $user["id"];
$_SESSION["user_nom"] = $user["nom"];
$_SESSION["user_prenom"] = $user["prenom"];

// --- 6. Rediriger vers le tableau de bord ---
header("Location: dashboard.php");
exit();

$sql->close();
$conn->close();
?>
