<?php
session_start();
if (!isset($_SESSION['utilisateur'])) {
    header("Location: pageconnexion.html");
    exit();
}

$utilisateur_actuel = $_SESSION['utilisateur']['Pseudo'];
$autre_utilisateur = $_GET['user'];

$contenu_json = file_get_contents("clients.json");
$conversations = json_decode($contenu_json, true);

$messages = [];
$conversation_existante=false;
foreach ($conversations['conversations'] as $conversation) {
    if (in_array($utilisateur_actuel, $conversation['participants']) && in_array($autre_utilisateur, $conversation['participants'])) {
        $messages = $conversation['messages'];
        $conversation_existante=true;
        break;
    }
}

if (!$conversation_existante) {
    // Créer une nouvelle conversation
    $nouvelle_conversation = [
        'participants' => [$utilisateur_actuel, $autre_utilisateur],
        'messages' => []
    ];
    $conversations['conversations'][] = $nouvelle_conversation;

    // Sauvegarder la nouvelle conversation dans le fichier JSON
    file_put_contents("clients.json", json_encode($conversations, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
}

echo json_encode($messages);
?>
