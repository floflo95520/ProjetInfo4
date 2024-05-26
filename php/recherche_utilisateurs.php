<?php
// Lecture du fichier JSON
$json = file_get_contents('clients.json');
$data = json_decode($json, true);

// Récupération du texte de recherche depuis la requête GET
$texteRecherche = $_GET['texte'];

// Tableau pour stocker les suggestions de recherche
$suggestions = [];

// Parcourir les utilisateurs et vérifier si leur pseudo correspond à la recherche
foreach ($data['utilisateur'] as $utilisateur) {
    if (stripos($utilisateur['Pseudo'], $texteRecherche) !== false) {
        // Si le pseudo de l'utilisateur contient le texte de recherche, l'ajouter aux suggestions
        $suggestions[] = $utilisateur;
    }
}

// Envoi des suggestions au format JSON
header('Content-Type: application/json');
echo json_encode($suggestions);
?>
