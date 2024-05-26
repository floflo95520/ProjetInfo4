<?php
session_start();
if (!isset($_SESSION['utilisateur'])) {
    header("Location: pageconnexion.html");
    exit();
}
elseif($_SESSION["utilisateur"]['Abonné']=== "0"){
    header("Location:pageabonnement.php");
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
    
    $nouvelle_conversation = [
        'participants' => [$utilisateur_actuel, $autre_utilisateur],
        'messages' => []
    ];
    $conversations['conversations'][] = $nouvelle_conversation;

    
    file_put_contents("clients.json", json_encode($conversations, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
}

echo json_encode($messages);
?>
