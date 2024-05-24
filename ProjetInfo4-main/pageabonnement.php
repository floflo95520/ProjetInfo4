<!DOCTYPE html>
<html>
    <head>
		<title>Abonne toi</title>
        <link rel="stylesheet" type="text/css" href="pageabonnement.css">
		<?session_start();

if (!isset($_SESSION['utilisateur'])) {
    header("Location: pageconnexion.html");
    exit();
}
?>
    </head>
	
    <body>
		<div>
			<p>Abonnement</p>
</br>
			<p>5.99 euros/mois</p>
		</div>
    </body>
</html>
