<?php
session_start();

if (!isset($_SESSION['utilisateur'])) {
    header("Location: pageconnexion.html");
    exit();
}

$utilisateur_actuel = $_SESSION['utilisateur']['Pseudo'];
$utilisateur_a_debloquer = $_POST['utilisateur'];

$contenu_json = file_get_contents("clients.json");
$donnees = json_decode($contenu_json, true);

// Vérifier et initialiser les listes de blocage si nécessaire
foreach ($donnees["utilisateur"] as &$utilisateur) {
    if (!isset($utilisateur["utilisateursbloqués"])) {
        $utilisateur["utilisateursbloqués"] = [];
    }
}

// Retirer l'utilisateur à débloquer de la liste de l'utilisateur actuel
foreach ($donnees["utilisateur"] as &$utilisateur) {
    if ($utilisateur["Pseudo"] === $utilisateur_actuel) {
        $index = array_search($utilisateur_a_debloquer, $utilisateur["utilisateursbloqués"]);
        if ($index !== false) {
            array_splice($utilisateur["utilisateursbloqués"], $index, 1);
        }
        break;
    }
}

// Retirer l'utilisateur actuel de la liste de l'utilisateur débloqué
foreach ($donnees["utilisateur"] as &$utilisateur) {
    if ($utilisateur["Pseudo"] === $utilisateur_a_debloquer) {
        $index = array_search($utilisateur_actuel, $utilisateur["utilisateursbloqués"]);
        if ($index !== false) {
            array_splice($utilisateur["utilisateursbloqués"], $index, 1);
        }
        break;
    }
}

file_put_contents("clients.json", json_encode($donnees, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

echo "Utilisateur débloqué avec succès";
?>
