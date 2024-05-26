<?php
session_start();

// Vérifiez que l'utilisateur est connecté
if (!isset($_SESSION['utilisateur']['Pseudo'])) {
    die("Utilisateur non connecté");
}

// Lire le fichier JSON
$json = file_get_contents('clients.json');
$data = json_decode($json, true);

if ($data === null) {
    die("Erreur lors de la lecture du fichier JSON");
}

// Pseudo de l'utilisateur connecté
$pseudoConnecte = $_SESSION['utilisateur']['Pseudo'];

// Récupérer les données envoyées par la requête AJAX
$input = json_decode(file_get_contents("php://input"), true);

// Trouver l'utilisateur dans le tableau et mettre à jour ses informations
foreach ($data['utilisateur'] as &$user) {
    if ($user['Pseudo'] === $pseudoConnecte) {
        $user['Sexe'] = $input['Sexe'];
        $user['Date_de_naissance'] = $input['Date_de_naissance'];
        $user['Signe_astrologique'] = $input['Signe_astrologique'];
        $user['Profession'] = $input['Profession'];
        $user['Département'] = $input['Département'];
        $user['Ville'] = $input['Ville'];
        $user['Situation'] = $input['Situation'];
        $user['Taille'] = $input['Taille'];
        $user['Poids'] = $input['Poids'];
        $user['Couleur_des_yeux'] = $input['Couleur_des_yeux'];
        $user['Couleur_des_cheveux'] = $input['Couleur_des_cheveux'];
        $user['Description'] = $input['Description'];
        $user['Nom'] = $input['Nom'];
        $user['Prenom'] = $input['Prenom'];
        $user['Mot_de_passe'] = password_hash($input['Mot_de_passe'], PASSWORD_DEFAULT);
        $user['Adresse'] = $input['Adresse'];
        break;
    }
}

// Enregistrer les données mises à jour dans le fichier JSON
file_put_contents('clients.json', json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

echo "Profil mis à jour avec succès";
?>
