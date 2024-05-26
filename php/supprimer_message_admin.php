<?php
// Vérifier si les données du message à supprimer ont été envoyées via la méthode POST
if (isset($_POST['message_id']) && isset($_POST['utilisateur1']) && isset($_POST['utilisateur2'])) {
    // Récupérer les données du message à supprimer
    $message_id = $_POST['message_id'];
    $utilisateur1 = $_POST['utilisateur1'];
    $utilisateur2 = $_POST['utilisateur2'];

    // Charger le contenu du fichier JSON des conversations
    $contenu_json = file_get_contents("clients.json");

    // Vérifier si le fichier JSON a été chargé avec succès
    if ($contenu_json === false) {
        // Gérer l'erreur de chargement du fichier JSON
        echo json_encode(["erreur" => "Impossible de charger les données"]);
        exit();
    }

    // Décoder le contenu JSON en tableau associatif
    $data = json_decode($contenu_json, true);

    // Parcourir les conversations pour trouver la bonne conversation
    foreach ($data['conversations'] as &$conversation) {
        // Vérifier si les participants correspondent à la conversation recherchée
        if (in_array($utilisateur1, $conversation['participants']) && in_array($utilisateur2, $conversation['participants'])) {
            // Parcourir les messages de la conversation
            foreach ($conversation['messages'] as $index => $message) {
                // Vérifier si le message correspond à celui à supprimer
                if ($message['id'] === $message_id) {
                    // Supprimer le message de la conversation
                    unset($conversation['messages'][$index]);
                    // Réencoder le tableau des conversations en JSON
                    $contenu_json = json_encode($data, JSON_PRETTY_PRINT);
                    // Sauvegarder le contenu JSON dans le fichier
                    file_put_contents("clients.json", $contenu_json);
                    // Envoyer une réponse de succès
                    echo json_encode(["succes" => "Message supprimé avec succès"]);
                    exit();
                }
            }
        }
    }

    // Si la conversation ou le message n'a pas été trouvé, envoyer une réponse d'erreur
    echo json_encode(["erreur" => "Conversation ou message non trouvé"]);
} else {
    // Si les paramètres requis ne sont pas présents, envoyer une réponse d'erreur
    echo json_encode(["erreur" => "Paramètres manquants"]);
}
?>
