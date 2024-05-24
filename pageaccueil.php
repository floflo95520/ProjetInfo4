<!DOCTYPE html>

<html>
    <head>
		<title>Trouvetavierge.com</title>
        <link rel="stylesheet" type="text/css" href="css/pageaccueil.css">
		<?php
				session_start();

				if (!isset($_SESSION['utilisateur'])) {
					header("Location: pageconnexion.html");
					exit();
				}
				

		?>
    </head>
	
    <body>
		<nav id="menu">
			<ul>
				<li><a href="monprofil.php">Profil</a></li>
				<li><a href="pageabonnement.php">Abonnement</a></li>
				<li><a href="pagederecherchepseudo.html">Recherche</a></li>
				<li><a href="Pagemessagerie.html">Messagerie</a></li>
				<li><a href="deconnexion.php">Deconnexion</a></li>
			</ul>
		</nav>
		<h2>Voici les récentes inscriptions sur notre site</h2>
		<div id="elements">

		</div>
		<script>
        
			var xhr = new XMLHttpRequest();
			xhr.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					var utilisateurs = JSON.parse(xhr.response); // Utilisez xhr.response directement
					console.log(utilisateurs);
		
		
					
		
					utilisateurs.forEach(element => {
						var utilisateurDiv = document.createElement('div');
			utilisateurDiv.innerHTML = `
							Pseudo: ${element.Pseudo}<br>
							Sexe: ${element.Sexe}<br>
							Date d'inscription: ${element.Date_inscription}<br>
							Profession: ${element.Profession}<br>
							Ville: ${element.Ville}<br>
							Description: ${element.Description}
						`;
						var div=document.getElementById("elements");
						div.appendChild(utilisateurDiv);

						var profilLien = document.createElement('a');
                    profilLien.href = 'pageprofil.php?user=' + encodeURIComponent(element.Pseudo);
                    profilLien.appendChild(utilisateurDiv);

                    // Ajouter le lien au conteneur
                    var div = document.getElementById("elements");
            div.appendChild(profilLien);
					}); 
						
		}
		
			
		
					
		
				
			};
			xhr.open("GET", "20utilisateurs.php", true);
			xhr.send();
		
		
			</script>
    </body>
</html>
