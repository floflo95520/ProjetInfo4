<?php
session_start();

if (!isset($_SESSION['utilisateur'])) {
    header("Location: pageconnexion.html");
    exit();
}

$data = json_decode(file_get_contents("clients.json"), true);

if ($data === NULL) {
    die("Erreur de décodage : " . json_last_error_msg());
}

$users = $data["utilisateur"] ?? [];

$utilisateur_actuel = $_SESSION['utilisateur']['Pseudo'];

// Récupérer la liste des utilisateurs bloqués par l'utilisateur actuel
$utilisateurs_bloques = [];
foreach ($users as $utilisateur) {
    if ($utilisateur['Pseudo'] === $utilisateur_actuel) {
        if (isset($utilisateur['utilisateursbloqués'])) {
            $utilisateurs_bloques = $utilisateur['utilisateursbloqués'];
        }
        break;
    }
}

// Vérifier si la liste des utilisateurs est vide
if (empty($users)) {
    echo "Erreur : le tableau des utilisateurs est vide";
    exit();
}

// Trier les utilisateurs par date d'inscription (les plus récents en premier)
usort($users, function ($a, $b) {
    $dateA = new DateTime($a['Date_inscription']);
    $dateB = new DateTime($b['Date_inscription']);
    return $dateB <=> $dateA;
});

// Extraire les 20 derniers utilisateurs et exclure les utilisateurs bloqués
$latestUsers = array_slice($users, 0, 20);
$latestUsers = array_filter($latestUsers, function($user) use ($utilisateurs_bloques) {
    return !in_array($user['Pseudo'], $utilisateurs_bloques);
});

// Encoder les résultats en JSON
$jsonUsers = json_encode(array_values($latestUsers), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

// Afficher les résultats
echo $jsonUsers;
?>
