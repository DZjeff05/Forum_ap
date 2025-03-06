<?php
try{
    session_start();
    $bdd = new PDO('mysql:host=localhost;dbname=mon_forum;charset=utf8;', 'root','');
}catch(Exception $e){
    die('une erreur est survenue lors de la connexion : ' .$e->getMessage());
}
