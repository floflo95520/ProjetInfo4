<?php
session_start();
if (!isset($_SESSION['utilisateur'])) {
    header("Location: pageconnexion.html");
    exit();
}
if($_SESSION['Abonné']== "0"){
    header("Location:pageabonnement.php");
}

$contenu_json = file_get_contents("clients.json");
$conversations = json_decode($contenu_json, true);

$utilisateur_actuel = $_SESSION['utilisateur']['Pseudo'];
$utilisateurs_converses = [];

foreach ($conversations['conversations'] as $conversation) {
    if (in_array($utilisateur_actuel, $conversation['participants'])) {
        foreach ($conversation['participants'] as $participant) {
            if ($participant !== $utilisateur_actuel && !in_array($participant, $utilisateurs_converses)) {
                $utilisateurs_converses[] = $participant;
            }
        }
    }
}
header('Content-Type: application/json');
echo json_encode($utilisateurs_converses);
?>

