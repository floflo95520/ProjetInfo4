<!DOCTYPE html>
<html>
    <head>
		<title>Abonne toi</title>
        <link rel="stylesheet" type="text/css" href="css/pageabonnement.css">
		<?php session_start();

if (!isset($_SESSION['utilisateur'])) {
    header("Location: pageconnexion.html");
    exit();
}

?>
    </head>
	
    <body>
		<nav id="menu">
			<ul>
				<li><a href="pageaccueil.html">Accueil</a></li>
				<li><a href="monprofil.php">Profil</a></li>
				<li><a href="pagederecherchepseudo.html">Recherche</a></li>
				<li><a href="pagemessagerie.html">Messagerie</a></li>
				<li><a href="deconnexion.php">Deconnexion</a></li>
			</ul>
		</nav>
        <h1>N'attendez plus et souscrivez à notre offre pour 5,99 euros par mois</h1>
        <p>En souscrivant à notre offre, vous pourrez échanger avec les autres utilisateurs</p>
	<div class="abonnement">
        <h2>Abonnement</h2>
        <br>
        <?php if ($_SESSION["utilisateur"]["Abonné"] === "1"):  ?>
            <div class="deja-abonne">Déjà abonné</div>
        <?php else: ?>
            <form action="scriptabonnement.php" method="POST">
                <button type="submit">S'abonner</button>
            </form>
        <?php endif; ?>
    </div>
    </body>
</html>
