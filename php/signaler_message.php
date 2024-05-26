<?php
session_start();
if (!isset($_SESSION['utilisateur'])) {
    header("Location:pageconnexion.html");
    exit();
}
if($_SESSION['Abonné']==="0"){
    header("Location:pageabonnement.php");
}

$utilisateur_actuel = $_SESSION['utilisateur']['Pseudo'];
$message_id = $_POST['messageId'];
$raison = $_POST['raison'];
$utilisateur_signale=$_POST['utilisateursignale'];

$contenu_json = file_get_contents("clients.json");
$signalements = json_decode($contenu_json, true);

$nouveau_signalement = [
    'signalé' => $utilisateur_signale,
    'signale_par' => $utilisateur_actuel,
    'message_id' => $message_id,
    'raison' => $raison,
    'heuresignalement' => date('Y-m-d H:i:s')
];

$signalements['signalements'][] = $nouveau_signalement;

file_put_contents("clients.json", json_encode($signalements, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

echo "Signalement envoyé avec succès";
?>
