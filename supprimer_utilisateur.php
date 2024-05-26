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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userToDelete = $_POST['user'];

    foreach ($users as $key => $user) {
        if ($user['Pseudo'] === $userToDelete) {
            unset($users[$key]);
            $data['utilisateur'] = array_values($users);
            file_put_contents("clients.json", json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
            echo json_encode(['success' => true, 'message' => 'Utilisateur supprimé avec succès.']);
            exit();
        }
    }

    echo json_encode(['success' => false, 'message' => 'Utilisateur non trouvé.']);
}
?>
