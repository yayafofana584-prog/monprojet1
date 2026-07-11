<?php
$username = 'root';
$servername = 'localhost';
$password = '';
$dbname = 'form';

// Connexion à la base de données
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");

if ($_SERVER["REQUEST_METHOD"] == 'POST') {

    $nom            = trim($_POST['nom'] ?? '');
    $prenom         = trim($_POST['prenom'] ?? '');
    $email          = trim($_POST['email'] ?? '');
    $mot_de_passe   = $_POST['mot_de_passe'] ?? '';
    $confirmation   = $_POST['confirmation'] ?? '';
    $genre          = $_POST['genre'] ?? '';
    $telephone      = trim($_POST['telephone_complet'] ?? $_POST['telephone'] ?? '');

    // Vérifications de base
    if ($nom === '' || $prenom === '' || $email === '' || $mot_de_passe === '' || $genre === '' || $telephone === '') {
        die("Erreur : tous les champs sont obligatoires.");
    }

    if ($mot_de_passe !== $confirmation) {
        die("Erreur : les mots de passe ne correspondent pas.");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Erreur : adresse email invalide.");
    }

    // Hash du mot de passe (jamais en clair dans la base)
    $mot_de_passe_hash = password_hash($mot_de_passe, PASSWORD_DEFAULT);

    // Requête préparée (sécurisée contre les injections SQL)
    $sql = "INSERT INTO personnels (nom, prenom, genre, email, telephone, mot_de_passe)
            VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Erreur de préparation : " . $conn->error);
    }

    $stmt->bind_param("ssssss", $nom, $prenom, $genre, $email, $telephone, $mot_de_passe_hash);

    if ($stmt->execute()) {
        echo "Inscription réussie ! Bienvenue " . htmlspecialchars($prenom) . ".";
    } else {
        if ($conn->errno == 1062) {
            echo "Erreur : cet email est déjà utilisé.";
        } else {
            echo "Erreur lors de l'enregistrement : " . $stmt->error;
        }
    }

    $stmt->close();
}

$conn->close();
?>
