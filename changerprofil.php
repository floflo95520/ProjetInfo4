<?php
session_start();

if (!isset($_SESSION['utilisateur'])) {
    header("Location: pageconnexion.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérez les données soumises par le formulaire
    $pseudo = $_SESSION['utilisateur']['Pseudo'];
    $sexe = $_POST['Sexe'];
    $date_de_naissance = $_POST['Date_de_naissance'];
    $signe_astrologique = $_POST['Signe_astrologique'];
    $profession = $_POST['Profession'];
    $ville = $_POST['Ville'];
    $description = $_POST['Description'];

    // Lisez le fichier JSON
    $contenu_json = file_get_contents("clients.json");
    $donnees = json_decode($contenu_json, true);

    if ($donnees === null) {
        die("Erreur de décodage JSON : " . json_last_error_msg());
    }

    // Trouvez l'utilisateur et mettez à jour les informations
    foreach ($donnees['utilisateur'] as &$utilisateur) {
        if ($utilisateur['Pseudo'] === $pseudo) {
            $utilisateur['Sexe'] = $sexe;
            $utilisateur['Date_de_naissance'] = $date_de_naissance;
            $utilisateur['Signe_astrologique'] = $signe_astrologique;
            $utilisateur['Profession'] = $profession;
            $utilisateur['Ville'] = $ville;
            $utilisateur['Description'] = $description;
            break;
        }
    }

    // Encodez de nouveau les données en JSON et écrivez-les dans le fichier
    file_put_contents("clients.json", json_encode($donnees, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

    // Mettez à jour la session
    $_SESSION['utilisateur'] = array_merge($_SESSION['utilisateur'], [
        'Sexe' => $sexe,
        'Date_de_naissance' => $date_de_naissance,
        'Signe_astrologique' => $signe_astrologique,
        'Profession' => $profession,
        'Ville' => $ville,
        'Description' => $description,
    ]);

    // Redirigez l'utilisateur vers la page de profil avec un message de succès
    header("Location: monprofil.php?update=success");
    exit();
} else {
    echo "Requête non valide.";
}
?>
