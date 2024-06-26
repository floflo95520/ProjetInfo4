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

foreach ($donnees["utilisateur"] as &$utilisateur) {
    if (!isset($utilisateur["Utilisateursbloqués"])) {
        $utilisateur["Utilisateursbloqués"] = [];
    }
}


foreach ($donnees["utilisateur"] as &$utilisateur) {
    if ($utilisateur["Pseudo"] === $utilisateur_actuel) {
        $index = array_search($utilisateur_a_debloquer, $utilisateur["Utilisateursbloqués"]);
        if ($index !== false) {
            array_splice($utilisateur["Utilisateursbloqués"], $index, 1);
        }
        break;
    }
}


foreach ($donnees["utilisateur"] as &$utilisateur) {
    if ($utilisateur["Pseudo"] === $utilisateur_a_debloquer) {
        $index = array_search($utilisateur_actuel, $utilisateur["Utilisateursbloqués"]);
        if ($index !== false) {
            array_splice($utilisateur["Utilisateursbloqués"], $index, 1);
        }
        break;
    }
}

file_put_contents("clients.json", json_encode($donnees, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

echo "Utilisateur débloqué avec succès";
?>
