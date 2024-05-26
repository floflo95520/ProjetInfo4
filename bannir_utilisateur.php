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

$users = $data["utilisateur"] ?? [];
$bannis = $data["bannis"];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userToBan = $_POST['user'];

    foreach ($users as $user) {
        if ($user['Pseudo'] === $userToBan && !in_array($userToBan, $bannis)) {
            $bannis[]=$userToBan;
            $data["bannis"]=$bannis;
            file_put_contents("clients.json", json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
            echo json_encode(['success' => true, 'message' => 'Utilisateur banni avec succès.']);
            exit();
                   
        }
    }

    echo json_encode(['success' => false, 'message' => 'Utilisateur non trouvé ou déjà banni.']);
}
?>
