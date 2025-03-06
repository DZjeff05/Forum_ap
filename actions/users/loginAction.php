<?php

require('actions/database.php');

// validation du formulaire
if(isset($_POST['validate'])){
   
    //verifier si l'utilistaeur a bien rempli tous les champs
    if(!empty($_POST['Pseudo']) AND !empty($_POST['Password'])){

        // les données de l'utilisateur (les données sont sécurisées par htmlspecialchars pour éviter les injections SQL)
        $user_Pseudo = htmlspecialchars($_POST['Pseudo']);
        $user_Password = htmlspecialchars($_POST['Password']);
        
        // requete pour vérifier si l'utilisateur existe(si le pseudo est correct)
        $checkIfUserExist = $bdd->prepare("SELECT * FROM users WHERE pseudo = ?");
        $checkIfUserExist->execute(array($user_Pseudo));


        if($checkIfUserExist->rowCount() > 0){
            
            // récupérer les informations de l'utilisateur
            $usersInfo = $checkIfUserExist->fetch();

            // vérifier si le mot de passe est correcte avec password_verify()
            if(password_verify($user_Password, $usersInfo['mdp'])){

                //Authentifier l'utilisateur sur le site récupérer ses données dans 
                $_SESSION['auth'] = true;
                $_SESSION['id'] = $usersInfo['id'];
                $_SESSION['pseudo'] = $usersInfo['pseudo'];
                $_SESSION['lastname'] = $usersInfo['nom'];
                $_SESSION['firstname'] = $usersInfo['prénom'];

                //redirection vers la page d'accueil
                header('Location: index.php');

            }
            else{
                $errorMsg = "votre pseudo ou votre mot de passe est incorrecte";
            }
        }
        else{
            $errorMsg = "votre pseudo ou votre mot de passe est incorrecte";
        }

    }else{  
        $errorMsg = "veuillez completez tous les champs";
    }

}