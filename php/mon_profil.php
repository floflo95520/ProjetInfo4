<?php
session_start();

// Lire le fichier JSON
$json = file_get_contents('clients.json');
$data = json_decode($json, true);

if ($data === null) {
    // En cas d'erreur lors de la lecture ou du décodage du fichier JSON
    echo json_encode(["error" => "Erreur lors de la lecture du fichier JSON"]);
    exit;
}

// Pseudo de l'utilisateur connecté
$pseudoConnecte = $_SESSION['utilisateur']['Pseudo'];  // Assurez-vous que ce champ existe dans la session

// Trouver les informations de l'utilisateur connecté
$utilisateur = null;
foreach ($data['utilisateur'] as $user) {
    if ($user['Pseudo'] === $pseudoConnecte) {
        $utilisateur = $user;
        break;
    }
}

if ($utilisateur === null) {
    echo json_encode(["error" => "Utilisateur non trouvé"]);
    exit;
}

// Envoi des données de l'utilisateur au format JSON
header('Content-Type: application/json');
echo json_encode($utilisateur, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
?>
