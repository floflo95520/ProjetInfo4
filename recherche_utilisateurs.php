<?php

$json = file_get_contents('clients.json');
$data = json_decode($json, true);


$texteRecherche = $_GET['texte'];


$suggestions = [];


foreach ($data['utilisateur'] as $utilisateur) {
    if (stripos($utilisateur['Pseudo'], $texteRecherche) !== false) {
        
        $suggestions[] = $utilisateur;
    }
}


header('Content-Type: application/json');
echo json_encode($suggestions);
?>
