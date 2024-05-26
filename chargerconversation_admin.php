<?php
// Charger le contenu du fichier JSON des conversations
$contenu_json = file_get_contents("clients.json");

// Vérifier si le fichier JSON a été chargé avec succès
if ($contenu_json === false) {
    // Gérer l'erreur de chargement du fichier JSON
    echo json_encode(["erreur" => "Impossible de charger les conversations"]);
    exit();
}

// Décoder le contenu JSON en tableau associatif
$conversations = json_decode($contenu_json, true);

// Vérifier si les paramètres utilisateur1 et utilisateur2 ont été fournis dans l'URL
if (!isset($_GET['utilisateur1']) || !isset($_GET['utilisateur2'])) {
    // Gérer l'erreur des paramètres manquants
    echo json_encode(["erreur" => "Paramètres utilisateur1 ou utilisateur2 manquants"]);
    exit();
}

// Récupérer les noms d'utilisateur de l'URL
$utilisateur1 = $_GET['utilisateur1'];
$utilisateur2 = $_GET['utilisateur2'];

// Rechercher la conversation entre ces deux utilisateurs dans le tableau des conversations
$conversation = null;
foreach ($conversations["conversations"] as $conv) {
    if (in_array($utilisateur1, $conv['participants']) && in_array($utilisateur2, $conv['participants'])) {
        $conversation = $conv;
        break;
    }
}

// Vérifier si la conversation a été trouvée
if ($conversation === null) {
    // Gérer l'erreur de conversation introuvable
    echo json_encode(["erreur" => "Conversation introuvable"]);
    exit();
}

// Renvoyer les messages de la conversation au format JSON
echo json_encode($conversation['messages']);
?>
