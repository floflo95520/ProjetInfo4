<?php

session_start();

if (!isset($_SESSION['utilisateur'])) {
    header("Location: pageconnexion.html");
    exit();
}



// Charger le fichier JSON
$json = file_get_contents('database.json');
$data = json_decode($json, true);

$pseudo = $_GET['pseudo'];
$visitors = [];

// Trouver l'utilisateur correspondant et récupérer ses visiteurs
foreach ($data['users'] as $user) {
    if ($user['pseudo'] == $pseudo) {
        $visitors = $user['visites'];
        break;
    }
}

echo json_encode($visitors);
?>
