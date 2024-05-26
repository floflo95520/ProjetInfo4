<?php
session_start();


$json = file_get_contents('clients.json');
$data = json_decode($json, true);

if ($data === null) {
    
    echo json_encode(["error" => "Erreur lors de la lecture du fichier JSON"]);
    exit;
}


$pseudoConnecte = $_SESSION['utilisateur']['Pseudo'];  


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


header('Content-Type: application/json');
echo json_encode($utilisateur, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
?>
