<?php

$contenu_json = file_get_contents("clients.json");


if ($contenu_json === false) {
    
    echo json_encode(["erreur" => "Impossible de charger les conversations"]);
    exit();
}


$conversations = json_decode($contenu_json, true);


if (!isset($_GET['utilisateur1']) || !isset($_GET['utilisateur2'])) {
    
    echo json_encode(["erreur" => "Paramètres utilisateur1 ou utilisateur2 manquants"]);
    exit();
}


$utilisateur1 = $_GET['utilisateur1'];
$utilisateur2 = $_GET['utilisateur2'];


$conversation = null;
foreach ($conversations["conversations"] as $conv) {
    if (in_array($utilisateur1, $conv['participants']) && in_array($utilisateur2, $conv['participants'])) {
        $conversation = $conv;
        break;
    }
}


if ($conversation === null) {
    echo json_encode(["erreur" => "Conversation introuvable"]);
    exit();
}


echo json_encode($conversation['messages']);
?>
