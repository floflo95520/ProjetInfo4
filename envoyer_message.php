<?php
session_start();
if (!isset($_SESSION['utilisateur'])) {
    header("Location: pageconnexion.html");
    exit();
}
if($_SESSION["Abonné"]=="0"){
    header("Location:pageabonnement.php");
}

$utilisateur_actuel = $_SESSION['utilisateur']['Pseudo'];
$message = $_POST['message'];
$destinataire = $_POST['recipient'];

// Vérification des données reçues
if (empty($message) || empty($destinataire)) {
    echo "Message ou destinataire manquant";
    exit();
}

$contenu_json = file_get_contents("clients.json");
$conversations = json_decode($contenu_json, true);

// Vérification que le fichier JSON a été correctement décodé
if (json_last_error() !== JSON_ERROR_NONE) {
    echo "Erreur lors de la lecture du fichier JSON: " . json_last_error_msg();
    exit();
}

$conversation_trouvee = false;

foreach ($conversations['conversations'] as &$conversation) {
    if (in_array($utilisateur_actuel, $conversation['participants']) && in_array($destinataire, $conversation['participants'])) {
        $conversation_trouvee = true;
        $conversation['messages'][] = [
            'id' => uniqid(),
            'sender' => $utilisateur_actuel,
            'content' => $message,
            'timestamp' => date('Y-m-d H:i:s')
        ];
        break;
    }
}

if (!$conversation_trouvee) {
    $conversations['conversations'][] = [
        'participants' => [$utilisateur_actuel, $destinataire],
        'messages' => [
            [
                'id' =>uniqid(),
                'sender' => $utilisateur_actuel,
                'content' => $message,
                'timestamp' => date('Y-m-d H:i:s')
            ]
        ]
    ];
}

// Sauvegarder la mise à jour dans le fichier JSON
if (file_put_contents("clients.json", json_encode($conversations, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)) === false) {
    echo "Erreur lors de l'écriture dans le fichier JSON";
    exit();
}

echo "Message envoyé avec succès";
?>
