<?php
session_start();

// Vérifiez que l'utilisateur est connecté
if (!isset($_SESSION['utilisateur']['Pseudo'])) {
    echo json_encode(["error" => "Utilisateur non connecté"]);
    exit;
}

// Lire le fichier JSON
$json = file_get_contents('clients.json');
$data = json_decode($json, true);

if ($data === null) {
    // En cas d'erreur lors de la lecture ou du décodage du fichier JSON
    echo json_encode(["error" => "Erreur lors de la lecture du fichier JSON"]);
    exit;
}

// Pseudo de l'utilisateur connecté
$pseudoConnecte = $_SESSION['utilisateur']['Pseudo'];

// Initialiser un tableau pour les visiteurs
$visitors = [];

// Parcourir les utilisateurs pour trouver le bon et récupérer ses visites
foreach ($data['utilisateur'] as $utilisateur) {
    if ($utilisateur['Pseudo'] === $pseudoConnecte) {
        if (isset($utilisateur['Visites'])) {
            $visitors = $utilisateur['Visites'];
        }
        break;
    }
}

// Envoi des visiteurs au format JSON
header('Content-Type: application/json');
echo json_encode($visitors, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
?>
