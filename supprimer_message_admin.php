<?php

if(!$_SESSION["Admin"]){
    header("location:pageaccueil.html");
}

if (isset($_POST['message_id']) && isset($_POST['utilisateur1']) && isset($_POST['utilisateur2'])) {
    $message_id = $_POST['message_id'];
    $utilisateur1 = $_POST['utilisateur1'];
    $utilisateur2 = $_POST['utilisateur2'];
    $contenu_json = file_get_contents("clients.json");

    
    if ($contenu_json === false) {
        echo json_encode(["erreur" => "Impossible de charger les données"]);
        exit();
    }
    $data = json_decode($contenu_json, true);
    foreach ($data['conversations'] as &$conversation) {
        if (in_array($utilisateur1, $conversation['participants']) && in_array($utilisateur2, $conversation['participants'])) {
            foreach ($conversation['messages'] as $index => $message) {
                if ($message['id'] === $message_id) {
                    unset($conversation['messages'][$index]);
                    $contenu_json = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
                    file_put_contents("clients.json", $contenu_json);
                    echo json_encode(["succes" => "Message supprimé avec succès"]);
                    exit();
                }
            }
        }
    }

    echo json_encode(["erreur" => "Conversation ou message non trouvé"]);
} else {
    echo json_encode(["erreur" => "Paramètres manquants"]);
}
?>
