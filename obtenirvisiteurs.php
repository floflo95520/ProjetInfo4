<?php

session_start();

if (!isset($_SESSION['utilisateur'])) {
    header("Location: pageconnexion.html");
    exit();
}



// Charger le fichier JSON
$json = file_get_contents('clients.json');
$data = json_decode($json, true);


$visitors = [];

// Trouver l'utilisateur correspondant et récupérer ses visiteurs
foreach ($data['utilisateur'] as $user) {
    if ($user['Pseudo'] == $_SESSION['utilisateur']['Pseudo']) {
        $visitors = $user['Visites'];
        break;
    }
}

echo json_encode($visitors);
?>
