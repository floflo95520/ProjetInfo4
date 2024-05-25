<!DOCTYPE html>
<html>
    <head>
        <title>Profil</title>
        <link rel="stylesheet" href="css/pageprofil.css">
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
				<li><a href="pageaccueil.php">Accueil</a></li>
				<li><a href="monprofil.php">Profil</a></li>
				<li><a href="Pagemessagerie.html">Messagerie</a></li>
				<li><a href="#">Deconnexion</a></li>
			</ul>
		</nav>
        <h1>Est-ce la bonne personne ?</h1>
		<a id="retour" href="pagederecherche.html">Retour</a>
        <div id="id1">

        </div>
    </body>
    <script>
        function getQueryParams() {
            const params = {};
            const queryString = window.location.search.substring(1);
            const regex = /([^&=]+)=([^&]*)/g;
            let m;
            while (m = regex.exec(queryString)) {
                params[decodeURIComponent(m[1])] = decodeURIComponent(m[2]);
            }
            return params;
        }

        // Récupérer le pseudo de l'utilisateur à partir des paramètres d'URL
        const queryParams = getQueryParams();
        const userPseudo = queryParams['user'];
        

        if(userPseudo){
            var xhr= new XMLHttpRequest();
            xhr.onreadystatechange=function(){
                if(this.readyState == 4 && this.status == 200){
                    var utilisateur=JSON.parse(xhr.response);
                    console.log(utilisateur);

                    var profileDiv = document.createElement('div');
                    profileDiv.innerHTML = `
                        <p><strong>Pseudo:</strong> ${utilisateur.Pseudo}</p>
                        <p><strong>Signe astrologique:</strong> ${utilisateur.Signe_astrologique}</p>
                        <p><strong>Sexe:</strong> ${utilisateur.Sexe}</p>
                        <p><strong>Date de naissance:</strong> ${utilisateur.Date_de_naissance}</p>
                        <p><strong>Date d'inscription:</strong> ${utilisateur.Date_inscription}</p>
                        <p><strong>Profession:</strong> ${utilisateur.Profession}</p>
                        <p><strong>Situation:</strong> ${utilisateur.Situation}</p>
                        <p><strong>Ville:</strong> ${utilisateur.Ville}</p>
                        <p><strong>Poids:</strong> ${utilisateur.Poids}</p>
                        <p><strong>Taille:</strong> ${utilisateur.Taille}</p>
                        <p><strong>Couleur des yeux:</strong> ${utilisateur.Couleur_des_yeux}</p>
                        <p><strong>Couleur des cheveux:</strong> ${utilisateur.Couleur_des_cheveux}</p>
                        <p><strong>Description:</strong> ${utilisateur.Description}</p>
                        <a href="conversation.html?user=${encodeURIComponent(utilisateur.Pseudo)}">Envoyez-lui un message</a>
                        
                    `;

                    document.getElementById("id1").appendChild(profileDiv);
                }
            };
            xhr.open("GET", "1utilisateur.php?user=" + encodeURIComponent(userPseudo), true);
            xhr.send();
                }
            
        
    </script>
</html>
