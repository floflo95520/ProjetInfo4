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
    <link rel="stylesheet" type="text/css" href="css/monprofil.css">
</head>
<body>
	<nav id="menu">
		<ul>
			<li><a href="pageaccueil.php">Accueil</a></li>
			<li><a href="pagederecherchepseudo.html">Recherche</a></li>
			<li><a href="Pagemessagerie.html">Messagerie</a></li>
			<li><a href="#">Deconnexion</a></li>
		</ul>
	</nav>

    <h1>Mon Profil</h1>

    <form action="changerprofil.php" method="POST">
        <div id="gauche">
            <label><h4>Pseudo:</h4></label>
            <input type="text" name="Pseudo" value="<?php echo $utilisateur['Pseudo']; ?>" readonly><br>
            <label><h4>Sexe:</h4></label>
            <input type="text" name="Sexe" value="<?php echo $utilisateur['Sexe']; ?>"><br>
            <label><h4>Date de naissance:</h4></label>
            <input type="date" name="Date_de_naissance" value="<?php echo $utilisateur['Date_de_naissance']; ?>"><br>
            <label><h4>Signe astrologique:</h4></label>
            <input type="text" name="Signe_astrologique" value="<?php echo $utilisateur['Signe_astrologique']; ?>"><br>
            <label><h4>Profession:</h4></label>
        </div>
            <input type="text" name="Profession" value="<?php echo $utilisateur['Profession']; ?>"><br>
            <label><h4>Ville:</h4></label>
            <input type="text" name="Ville" value="<?php echo $utilisateur['Ville']; ?>"><br>
            <label><h4>Description:</h4></label>
            <textarea name="Description"><?php echo $utilisateur['Description']; ?></textarea><br>
            <button type="submit"><h4>Mettre à jour</h4></button>
    </form>
</body>
</html>
