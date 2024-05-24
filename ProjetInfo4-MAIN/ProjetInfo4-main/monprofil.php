<?php

session_start();

				if (!isset($_SESSION['utilisateur'])) {
					header("Location: pageconnexion.html");
					exit();
				}



$utilisateur = $_SESSION['utilisateur'];

?>

<!DOCTYPE html>
<html>
<head>
    <title>Mon Profil</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <h1>Mon Profil</h1>
    <form action="changerprofil.php" method="POST">
        <label>Pseudo:</label>
        <input type="text" name="Pseudo" value="<?php echo $utilisateur['Pseudo']; ?>" readonly><br>
        <label>Sexe:</label>
        <input type="text" name="Sexe" value="<?php echo $utilisateur['Sexe']; ?>"><br>
        <label>Date de naissance:</label>
        <input type="date" name="Date_de_naissance" value="<?php echo $utilisateur['Date_de_naissance']; ?>"><br>
        <label>Signe astrologique:</label>
        <input type="text" name="Signe_astrologique" value="<?php echo $utilisateur['Signe_astrologique']; ?>"><br>
        <label>Profession:</label>
        <input type="text" name="Profession" value="<?php echo $utilisateur['Profession']; ?>"><br>
        <label>Ville:</label>
        <input type="text" name="Ville" value="<?php echo $utilisateur['Ville']; ?>"><br>
        <label>Description:</label>
        <textarea name="Description"><?php echo $utilisateur['Description']; ?></textarea><br>
        <button type="submit">Mettre à jour</button>
    </form>
</body>
</html>
