<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
if (!isset($_SESSION['utilisateur'])) {
    header("Location: pageconnexion.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $contenu_json = file_get_contents("clients.json");
        $donnees = json_decode($contenu_json, true);

        foreach ($donnees["utilisateur"] as &$utilisateur) {
            if ($utilisateur["Pseudo"] === $_SESSION["utilisateur"]["Pseudo"]) {
                
                $utilisateur["Abonné"] = "1"; 
                $_SESSION["utilisateur"]["Abonné"] = "1"; 
                break;
            }
        }

        
        file_put_contents("clients.json", json_encode($donnees, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

        echo "Vous êtes maintenant abonné!";
        header("Location:pageaccueil.html");
    } catch (Exception $e) {
        echo "Erreur :" . $e->getMessage();
    }
}
?>