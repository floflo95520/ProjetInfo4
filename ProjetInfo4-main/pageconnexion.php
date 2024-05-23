<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


session_start();

if(isset($_POST["source"])){
    $source=$_POST["source"];
    if($source === "connexion"){
        if($_SERVER["REQUEST_METHOD"]=="POST"){
            try{
                if(empty($_POST["Pseudo"]) || empty($_POST["Mot_de_passe"])){
                    throw new Exception("Nom d'utilisateur ou mot de passe incorrect");
                    header("location:pageconnexion.html");
                }
                $contenu_json=file_get_contents("clients.json");
                $donnees=json_decode($contenu_json,true);
                $utilisateurs=$donnees["utilisateur"];

                $mot_de_passe_saisi=$_POST["Mot_de_passe"];
                $nom_utilisateur_saisi=$_POST["Pseudo"];

                echo "Nom d'utilisateur soumis : " . $nom_utilisateur_saisi . "<br>";
                echo "Mot de passe soumis : " . $mot_de_passe_saisi . "<br>";


                $utilisateur_trouve=false;

                foreach($utilisateurs as $utilisateur){
                    if($utilisateur["Pseudo"]===$nom_utilisateur_saisi && password_verify($mot_de_passe_saisi, $utilisateur["Mot_de_passe"])){
                        $utilisateur_trouve=true;
                        $_SESSION["utilisateur"]=$utilisateur;

                        // Créer un token unique pour le cookie
                        $token = bin2hex(random_bytes(16));
                        $expiry = time() + (3600); // 30 jours

                        // Enregistrer le token dans la session utilisateur
                        $_SESSION['token'] = $token;

                        // Créer un cookie pour se souvenir de l'utilisateur
                        setcookie('rememberme', $token, $expiry, "/");
                    }
                }
                
                if($utilisateur_trouve){
                    echo("Connexion réussie ! Veuillez patienter...");
                    header("location:pageaccueil.html");
                    
                }
                else{
                    echo "pas bon";
                    header("location:pageconnexion.html");
                }



            
            } catch(Exception $e){
                echo "Erreur :" . $e->getMessage();

            }
        }
    }
    elseif($source === "inscription"){
        if($_SERVER["REQUEST_METHOD"]=="POST"){
            try{
                if(empty($_POST["Mot_de_passe"]) || empty($_POST["Pseudo"]) || empty($_POST["Sexe"])){
                    throw new Exception("Un des champs requis est invalide");
                }
                $data=array(
                "Pseudo" => $_POST["Pseudo"],//
                "Sexe" => $_POST["Sexe"],//
                "Date_de_naissance" => $_POST["Naissance"],//
                "Signe_astrologique" =>$_POST["Signe_astro"],//
                "Profession" => $_POST["Profession"],//
                "Département"=>$_POST["Département"],//
                "Ville"=>$_POST["Ville"],//
                "Situation"=>$_POST["Situation"],//
                "Taille"=>$_POST["Taille"],//
                "Poids"=> $_POST["Poids"],//
                "Couleur_des_yeux"=>$_POST["Couleur_yeux"],//
                "Couleur_des_cheveux"=>$_POST["Couleur_cheveux"],//
                "Description"=>$_POST["Description"],//
                "Nom"=>$_POST["Nom"],//
                "Prenom"=>$_POST["Prenom"],//
                "Mot_de_passe" => password_hash($_POST["Mot_de_passe"],PASSWORD_DEFAULT),//
                "Adresse"=>$_POST["Adresse"],//
                "Date_inscription"=>date("Y-m-d"),//
                "Abonné"=>"0"
                );

                $nvPseudo=$_POST["Pseudo"];
                $nvSigneAstro=$_POST["Signe_astro"];
                $nvSigneAstroConf=$_POST["conf_signe_astro"];
                $nvmdp=$_POST["Mot_de_passe"];
                $nvmdpconf=$_POST["confirmer_motdepasse"];

                if($nvmdp != $nvmdpconf){
                    throw new Exception("Veuillez entrer le même mot de passe.");
                }

                if($nvSigneAstro != $nvSigneAstroConf){
                    throw new Exception("Veuillez sélectionner le même signe astrologique.");
                }


                

                $contenu_json = file_get_contents("clients.json");

                if(empty($contenu_json)) {
                    // Le fichier est vide, initialisez la structure JSON
                    $utilisateur_existants_temp["utilisateur"] = array();
                } else {
                    // Le fichier n'est pas vide, décodez le contenu JSON
                    $utilisateur_existants_temp = json_decode($contenu_json, true);
                }
                
                // Enregistrez les nouvelles données dans la structure JSON
                $utilisateur_existants_temp["utilisateur"][] = $data;
                
                // Enregistrez la structure JSON mise à jour dans le fichier
                file_put_contents("clients.json", json_encode($utilisateur_existants_temp, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
                
                header("location:pageaccueil.html");

                


            } catch(Exception $e){
                echo "Erreur :". $e->getMessage();

            }
        }

    }

}


?>