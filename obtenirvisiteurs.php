<?php
session_start();


if (!isset($_SESSION['utilisateur']['Pseudo'])) {
    echo json_encode(["error" => "Utilisateur non connecté"]);
    exit;
}

if($_SESSION["utilisateur"]['Abonné']=== "0"){
    header("Location:pageabonnement.php");
    exit();
}


$json = file_get_contents('clients.json');
$data = json_decode($json, true);

if ($data === null) {
    
    echo json_encode(["error" => "Erreur lors de la lecture du fichier JSON"]);
    exit;
}


$pseudoConnecte = $_SESSION['utilisateur']['Pseudo'];


$visitors = [];


foreach ($data['utilisateur'] as $utilisateur) {
    if ($utilisateur['Pseudo'] === $pseudoConnecte) {
        if (isset($utilisateur['Visites'])) {
            $visitors = $utilisateur['Visites'];
        }
        break;
    }
}


header('Content-Type: application/json');
echo json_encode($visitors, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
?>
