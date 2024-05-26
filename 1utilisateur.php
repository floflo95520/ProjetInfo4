<?php
session_start();

if (!isset($_SESSION['utilisateur'])) {
    header("Location: pageconnexion.html");
    exit();
}


if (isset($_GET["user"])) {
    $data = json_decode(file_get_contents("clients.json"), true);

    if ($data == NULL) {
        die("Erreur de décodage : " . json_last_error_msg());
    }

    $u = $_GET["user"];
    $utilisateurs = &$data["utilisateur"];

    if (empty($utilisateurs)) {
        echo "Erreur : le tableau est vide";
        exit();
    }

    
    $utilisateur_trouve = false;
    foreach ($utilisateurs as &$utilisateur) {
        if ($u === $utilisateur["Pseudo"]) {
            if (!in_array($_SESSION["utilisateur"]["Pseudo"], $utilisateur["Visites"]) && $_SESSION["utilisateur"]["Pseudo"]!== $u) {
                $utilisateur["Visites"][] = $_SESSION["utilisateur"]["Pseudo"];
            }
            $utilisateur_trouve = true;
            $utilisateur_a_retourner = $utilisateur; 
            break;
        }
    }

    
    if ($utilisateur_trouve) {
        file_put_contents("clients.json", json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    }

    
    if ($utilisateur_trouve) {
        echo json_encode($utilisateur_a_retourner);
    } else {
        echo json_encode(["message" => "Utilisateur non trouvé"]);
    }
} else {
    echo json_encode(["message" => "Aucun utilisateur spécifié"]);
}
?>
