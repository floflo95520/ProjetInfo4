<?php
session_start();

if (!isset($_SESSION['utilisateur'])) {
    header("Location: pageconnexion.html");
    exit();
}



if(isset($_GET["user"])){
$data= json_decode(file_get_contents("clients.json"),true);

if ($data == NULL) {
    die("Erreur de décodage : " . json_last_error_msg());
}

$u=$_GET["user"];
$utilisateurs=$data["utilisateur"];


if(empty($utilisateurs)){
    echo "Erreur : le tableau est vide";
}


$a=NULL;
foreach($utilisateurs as $utilisateur){
    if($u === $utilisateur["Pseudo"]){
        $a=$utilisateur;
        break;
    }
}
if ($a !== NULL) {
    echo json_encode($a);
} else {
    echo json_encode(["message" => "Utilisateur non trouvé"]);
}
}
else {
    echo "<pre>";
    echo "Paramètre 'user' manquant\n"; // Afficher l'absence du paramètre 'user'
    echo "</pre>";
    // Envoyer un message d'erreur si le paramètre 'user' est manquant
    echo json_encode(["message" => "Aucun utilisateur spécifié"]);


}
?>