<?php
session_start();

if (!isset($_SESSION['utilisateur'])) {
    header("Location: pageconnexion.html");
    exit();
}

$data = json_decode(file_get_contents("clients.json"), true);

if ($data == NULL) {
    die("Erreur de décodage : " . json_last_error_msg());
}

$utilisateurs = $data["utilisateur"];

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['user'])) {
    $pseudo = $_GET['user'];
    $utilisateurTrouve = null;

    foreach ($utilisateurs as $utilisateur) {
        if ($utilisateur['Pseudo'] === $pseudo) {
            $utilisateurTrouve = $utilisateur;
            break;
        }
    }

    if ($utilisateurTrouve !== null) {
        echo json_encode($utilisateurTrouve, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    } else {
        echo json_encode(["message" => "Utilisateur non trouvé"]);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postData = json_decode(file_get_contents('php://input'), true);

    foreach ($utilisateurs as &$utilisateur) {
        if ($utilisateur['Pseudo'] === $postData['Pseudo']) {
            $utilisateur['Signe_astrologique'] = $postData['Signe_astrologique'];
            $utilisateur['Sexe'] = $postData['Sexe'];
            $utilisateur['Date_de_naissance'] = $postData['Date_de_naissance'];
            $utilisateur['Profession'] = $postData['Profession'];
            $utilisateur['Situation'] = $postData['Situation'];
            $utilisateur['Ville'] = $postData['Ville'];
            $utilisateur['Poids'] = $postData['Poids'];
            $utilisateur['Taille'] = $postData['Taille'];
            $utilisateur['Couleur_des_yeux'] = $postData['Couleur_des_yeux'];
            $utilisateur['Couleur_des_cheveux'] = $postData['Couleur_des_cheveux'];
            $utilisateur['Description'] = $postData['Description'];
            $utilisateur['Nom'] = $postData['Nom'];
            $utilisateur['Prenom'] = $postData['Prenom'];
            if (!empty($postData['Mot_de_passe'])) {
                $utilisateur['Mot_de_passe'] = password_hash($postData['Mot_de_passe'], PASSWORD_DEFAULT);
            }
            $utilisateur['Adresse'] = $postData['Adresse'];
            $utilisateur['Date_inscription'] = $postData['Date_inscription'];
            $utilisateur['Abonné'] = $postData['Abonné'];
            $_SESSION["utilisateur"]["Abonné"] = $postData['Abonné'];
            $_SESSION["utilisateur"]["Pseudo"] = $postData['Pseudo'];
            $_SESSION["utilisateur"]["Mot_de_passe"] = password_hash($postData['Mot_de_passe'],PASSWORD_DEFAULT);
            break;
        }
    }

    $data["utilisateur"] = $utilisateurs; 

    file_put_contents("clients.json", json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    echo json_encode(["message" => "Profil mis à jour avec succès"]);
}
?>
