<?php

  include("Parametres.php");
  include("Fonctions.inc.php");
  include("Donnees.inc.php");

  // Connexion au serveur MySQL
  $mysqli=mysqli_connect($host,$user,$pass) or die("Problème de création de la base :".mysqli_error($string_error));
  if(mysqli_select_db($mysqli,$base)){
    
  }else{
    // Suppression / Création / Sélection de la base de données : $base
    query($mysqli,'DROP DATABASE IF EXISTS '.$base);
    query($mysqli,'CREATE DATABASE '.$base);
    mysqli_select_db($mysqli,$base) or die("Impossible de sélectionner la base : $base");

    query($mysqli,'CREATE TABLE `ALIMENT` (
      `id_aliment` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT UNIQUE,
      `nom_aliment` varchar(50) NOT NULL
    );');

    query($mysqli, 'CREATE TABLE `COMPOSITION` (
      `id_recette` int(11) NOT NULL ,
      `id_aliment` int(11) NOT NULL 
    );');

    query($mysqli, 'CREATE TABLE `RECETTE` (
      `id_recette` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT ,
      `titre` text NOT NULL,
      `ingredients` text NOT NULL,
      `preparation` text NOT NULL
    );');

    query($mysqli, 'CREATE TABLE `user` (
    `id_user` int(11) NOT NULL AUTO_INCREMENT PRIMARY key,
      `login` text NOT NULL ,
      `password` text NOT NULL,
      `prenom` varchar(50) NOT NULL,
      `nom` varchar(50) NOT NULL
    );');

    query($mysqli,'ALTER TABLE `COMPOSITION`
      ADD PRIMARY KEY (`id_recette`,`id_aliment`),
      ADD KEY `id_aliment` (`id_aliment`);');


    query($mysqli,'ALTER TABLE `COMPOSITION`
      ADD CONSTRAINT `id_aliment` FOREIGN KEY (`id_aliment`) REFERENCES `ALIMENT` (`id_aliment`),
      ADD CONSTRAINT `id_recette` FOREIGN KEY (`id_recette`) REFERENCES `RECETTE` (`id_recette`);');


    foreach($Recettes as $recette){
        foreach($recette["index"] as $aliment){
            $aliment = strtolower($aliment);
            $aliment = str_replace("'", "\'", $aliment);
            $aliment_existant = query($mysqli, "SELECT id_aliment FROM ALIMENT WHERE nom_aliment = '$aliment';");
            $aliment_existant = mysqli_fetch_array($aliment_existant);
            if(!$aliment_existant){
              query($mysqli, "INSERT INTO ALIMENT (nom_aliment) VALUES ('$aliment');");
            } 
        }
    }

    $id_recette = 1;
    foreach($Recettes as $recette){
        $titre = $recette["titre"];
        $titre = str_replace("'", "\'", $titre);
        $ingredients = $recette["ingredients"];
        $ingredients = str_replace("'", "\'", $ingredients);
        $preparation = $recette["preparation"];
        $preparation = str_replace("'", "\'", $preparation);

        query($mysqli, "INSERT INTO RECETTE (titre, ingredients, preparation) VALUES ('$titre', '$ingredients', '$preparation');");
        foreach($recette["index"] as $aliment){
            $aliment = strtolower($aliment);
            $aliment = str_replace("'", "\'", $aliment);
            $id_aliment = mysqli_fetch_array(query($mysqli, "SELECT id_aliment FROM ALIMENT WHERE nom_aliment = '$aliment';"))[0];

            query($mysqli, "REPLACE INTO COMPOSITION (id_recette, id_aliment) VALUES ('$id_recette','$id_aliment');");
        }
        $id_recette++;
    }
  }
?>