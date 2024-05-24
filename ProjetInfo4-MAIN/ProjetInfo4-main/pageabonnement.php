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
		<div class="abonnement">
			<h2>Abonnement</h2>
</br>
			<form action="scriptabonnement.php">
                <button type="submit">S'abonner</button>
            </form>
		</div>
    </body>
</html>
