<?php

if(isset($_POST["source"])){
    $source=$_POST["source"];
    if($source === "connexion"){
        if($_SERVER["REQUEST_METHOD"]=="POST"){
            try{
                if(empty($_POST["identifiant"]) || empty($_POST["mdp"])){
                    throw new Exception("Email ou mot de passe incorrect");
                }
                echo("ici ?");
                $contenu_json=file_get_contents("clients.json");
                $donnees=json_decode($contenu_json,true);

                $mot_de_passe_saisi=$_POST["mdp"];
                $nom_utilisateur_saisi=$_POST["identifiant"];

                $utilisateur_trouve=false;

                foreach($donnees as $utilisateur){
                    if($utilisateur["nom_utilisateur"]==$nom_utilisateur_saisi && password_verify($utilisateur["motdepasse"],$mot_de_passe_saisi)){
                        $utilisateur_trouve=true;
                    }
                }

                if($utilisateur_trouve){
                    echo("Connexion réussie ! Veuillez patienter...");
                    header("location:Accueil.html");
                    
                }
                else{
                    throw new Exception("Email ou mot de passe incorrect");
                }



            
            } catch(Exception $e){
                echo "Erreur :" . $e->getMessage();

            }
        }
    }
    elseif($source === "inscription"){
        //code inscription

    }

}


?>