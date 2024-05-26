<?php
session_start();
if (!isset($_SESSION['utilisateur'])) {
    header("Location: pageconnexion.html");
    exit();
}

$utilisateur_actuel = $_SESSION['utilisateur']['Pseudo'];
$utilisateur_a_bloquer = $_POST['utilisateur'];

$contenu_json = file_get_contents("clients.json");
$donnees = json_decode($contenu_json, true);

if ($donnees === null) {
    echo "Erreur de lecture du fichier JSON";
    exit();
}

$utilisateur_actuel_trouve = false;
$utilisateur_a_bloquer_trouve = false;

// Initialiser les listes de blocage si elles n'existent pas
foreach ($donnees["utilisateur"] as &$utilisateur) {
    if (!isset($utilisateur["Utilisateursbloqués"])) {
        $utilisateur["Utilisateursbloqués"] = [];
    }
}

foreach ($donnees["utilisateur"] as &$utilisateur) {
    if ($utilisateur["Pseudo"] === $utilisateur_actuel) {
        $utilisateur_actuel_trouve = true;
        if (!in_array($utilisateur_a_bloquer, $utilisateur["Utilisateursbloqués"])) {
            $utilisateur["Utilisateursbloqués"][] = $utilisateur_a_bloquer;
        }
    }
    if ($utilisateur["Pseudo"] === $utilisateur_a_bloquer) {
        $utilisateur_a_bloquer_trouve = true;
        if (!in_array($utilisateur_actuel, $utilisateur["Utilisateursbloqués"])) {
            $utilisateur["Utilisateursbloqués"][] = $utilisateur_actuel;
        }
    }
}

if ($utilisateur_actuel_trouve && $utilisateur_a_bloquer_trouve) {
    file_put_contents("clients.json", json_encode($donnees, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    echo "Utilisateur bloqué avec succès";
} else {
    if (!$utilisateur_actuel_trouve) {
        echo "Utilisateur actuel non trouvé dans le fichier JSON";
    }
    if (!$utilisateur_a_bloquer_trouve) {
        echo "Utilisateur à bloquer non trouvé dans le fichier JSON";
    }
}
?>
