<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


session_start();

if(isset($_SESSION['utilisateur'])){
    header("Location:pageaccueil.html");
    exit();
}




if($_SERVER["REQUEST_METHOD"]=="POST"){

    
    
        
            try{
                if(empty($_POST["Pseudo"]) || empty($_POST["Mot_de_passe"])){
                    throw new Exception("Nom d'utilisateur ou mot de passe incorrect");
                    
                }
                $contenu_json=file_get_contents("clients.json");
                $donnees=json_decode($contenu_json,true);
                $utilisateurs=$donnees["utilisateur"];

                $mot_de_passe_saisi=$_POST["Mot_de_passe"];
                $nom_utilisateur_saisi=$_POST["Pseudo"];

                echo "Nom d'utilisateur soumis : " . $nom_utilisateur_saisi . "<br>";
                echo "Mot de passe soumis : " . $mot_de_passe_saisi . "<br>";


                $utilisateur_trouve=false;
                $Bannis=$donnees["bannis"];

                if(in_array($nom_utilisateur_saisi, $Bannis)){
                    throw new Exception("Vous avez été banni(e) !");
                }

                foreach($utilisateurs as $utilisateur){
                    if($utilisateur["Pseudo"]===$nom_utilisateur_saisi && password_verify($mot_de_passe_saisi, $utilisateur["Mot_de_passe"])){
                        $utilisateur_trouve=true;
                        $_SESSION["utilisateur"] = $utilisateur;
                        
                    }
                }
                
                if($utilisateur_trouve){
                    echo("Connexion réussie ! Veuillez patienter...");
                    header("location:../pageaccueil.html");
                    exit();
                    
                }
                else{
                    echo "pas bon";
                    header("location:../pageconnexion.html");
                    exit();
                }



            
            } catch(Exception $e){
                echo "Erreur :" . $e->getMessage();
                header("location:../pageconnexion.html");

            }
        
    


}


?>