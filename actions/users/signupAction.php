<?php

require('actions/database.php');

// validation du formulaire
if(isset($_POST['validate'])){
   
    //verifier si l'utilistaeur a bien rempli tous les champs
    if(!empty($_POST['Pseudo']) AND !empty($_POST['lastname']) AND !empty($_POST['firstname']) AND !empty($_POST['Password'])){

        // les données de l'utilisateur (les données sont sécurisées par htmlspecialchars pour éviter les injections SQL)
        $user_Pseudo = htmlspecialchars($_POST['Pseudo']);
        $user_lastname = htmlspecialchars($_POST['lastname']);
        $user_firstname = htmlspecialchars($_POST['firstname']);
        $user_Password = password_hash($_POST['Password'], PASSWORD_DEFAULT);
        
        // vérifier si l'utilisateur existe déjà sur le site
        $checkIfUserAlreadyExist = $bdd->prepare('SELECT pseudo FROM users WHERE pseudo = ?');
        $checkIfUserAlreadyExist->execute(array($user_Pseudo));
        
        if($checkIfUserAlreadyExist->rowCount() == 0){

            // si l'utilisateur n'existe pas, on l'inscrit sur le site(on l'inssert dans la base de données en utilisant un mot de passe crypté grâce à la fonction password_hash())
            $insertUserOnWebsite = $bdd->prepare('INSERT INTO users(pseudo, nom, prénom, mdp) VALUES(?,?,?,?)');
            $insertUserOnWebsite->execute(array($user_Pseudo, $user_lastname, $user_firstname, $user_Password));
            $successMsg = "L'utilisateur a été créé avec succès";
            
            // récupérer les informations de l'utilisateur pour les stocker dans les variables de session des variables globals session
            $getInfoOfThisUserReq = $bdd->prepare('SELECT id, pseudo, nom, prénom FROM users WHERE nom =? AND prénom =? AND pseudo =?');
            $getInfoOfThisUserReq->execute(array($user_lastname, $user_firstname, $user_Pseudo));
            
            $usersInfo = $getInfoOfThisUserReq->fetch();
            
            //Authentifier l'utilisateur sur le site récupérer ses données dans 
            $_SESSION['auth'] = true;
            $_SESSION['id'] = $usersInfo['id'];
            $_SESSION['pseudo'] = $usersInfo['pseudo'];
            $_SESSION['lastname'] = $usersInfo['nom'];
            $_SESSION['firstname'] = $usersInfo['prénom'];
            

            //redirection vers la page d'accueil du site
            header('Location: index.php');
        }else{
            $errorMsg = "L'utilisateur existe déjà sur le site";
        }
    }else{  
        $errorMsg = "veuillez completez tous les champs";
    }

}