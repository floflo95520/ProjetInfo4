<?php
session_start();

if (!isset($_SESSION['utilisateur'])) {
    header("Location: pageconnexion.html");
    exit();
}

$data = json_decode(file_get_contents("clients.json"), true);

if ($data == NULL) {
    die("Erreur de décodage : " . json_last_error_msg());
}

$signalements = $data["signalements"] ?? [];

echo json_encode($signalements, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
?>
