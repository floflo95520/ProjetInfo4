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

$users = $data["utilisateur"];

if(empty($users)){
    echo "Erreur : le tableau est vide";
}
else{
usort($users, function ($a, $b) {
    $dateA = new DateTime($a['Date_inscription']);
    $dateB = new DateTime($b['Date_inscription']);
    return $dateB <=> $dateA;
});

// Extraire les 20 derniers utilisateurs
$latestUsers = array_slice($users, 0, 20);
$jsonUsers= json_encode($latestUsers, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

// Afficher les résultats

echo $jsonUsers;

}
?>
