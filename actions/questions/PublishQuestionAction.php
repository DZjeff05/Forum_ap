<?php
require('actions/database.php'); 

if(isset($_POST)){

    if(!empty($_POST['title']) AND !empty($_POST['description']) AND !empty($_POST['content'])){

        $question_title = htmlspecialchars($_POST['title']);
        $question_description = nl2br(htmlspecialchars($_POST['description']));
        $question_content = nl2br(htmlspecialchars($_POST['content']));
        $question_date = date('d/m/Y H:i:s');
        $question_id_author = $_SESSION['id'];
        $question_Pseudo_author = $_SESSION['pseudo'];

        $insertQuestionOnWebsite = $bdd->prepare('INSERT INTO questions(titre, description, contenu, id_autheur, pseudo_author, date_publication) VALUES(?, ?, ?, ?, ?, ?)');
        $insertQuestionOnWebsite->execute(
            array(
                $question_title, 
                $question_description, 
                $question_content, 
                $question_id_author, 
                $question_Pseudo_author, 
                $question_date
            ));
        
        $successMsg = "Votre question a bien été publiée";
    
    }
    else{
       $php_errorMsg="veuillez remplir tous les champs";
       
    }
}