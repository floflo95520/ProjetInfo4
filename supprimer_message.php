<?php
session_start();
if (!isset($_SESSION['utilisateur'])) {
    header("Location: pageconnexion.html");
    exit();
}
if($_SESSION["utilisateur"]['Abonné']=== "0"){
    header("Location:pageabonnement.php");
    exit();
}

$utilisateur_actuel = $_SESSION['utilisateur']['Pseudo'];
$message_id = $_POST['message_id'];
$destinataire = $_POST['recipient'];

$contenu_json = file_get_contents("clients.json");
$conversations = json_decode($contenu_json, true);


if (json_last_error() !== JSON_ERROR_NONE) {
    echo "Erreur lors de la lecture du fichier JSON: " . json_last_error_msg();
    exit();
}

$conversation_trouvee = false;

foreach ($conversations['conversations'] as &$conversation) {
    if (in_array($utilisateur_actuel, $conversation['participants']) && in_array($destinataire, $conversation['participants'])) {
        $conversation_trouvee = true;
        foreach ($conversation['messages'] as $key => $message) {
            if ($message['id'] == $message_id && $message['sender'] == $utilisateur_actuel) {
                unset($conversation['messages'][$key]);
                $conversation['messages'] = array_values($conversation['messages']);
                break;
            }
        }
        break;
    }
}

if ($conversation_trouvee) {
    if (file_put_contents("clients.json", json_encode($conversations, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)) === false) {
        echo "Erreur lors de l'écriture dans le fichier JSON";
        exit();
    }
    echo "Message supprimé avec succès";
} else {
    echo "Conversation ou message non trouvé";
}
?>
