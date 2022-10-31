<?php
    include("Parametres.php");
    include("Fonctions.inc.php");

    $mysqli=mysqli_connect($host,$user,$pass,$base) or die("Problème de création de la base :".mysqli_error($string_error));


    if(isset($_POST['submit_btn'])){
        //on recupere tout ($_POST)
        $login = $_POST['username'];
        $password = $_POST['password'];
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];

        if(isset($login) && isset($password) && isset($nom) && isset($prenom)){
            if($login != "" && $password != "" && $nom != "" && $prenom != ""){
                // on verifie 
                $result = query($mysqli, "SELECT `login` FROM user WHERE login = '$login'"); 
                $result_user = mysqli_num_rows($result);
                if ($result_user != 0){
                    echo "Le login est deja utiliser ";
                }else{
                    //on input dans la BD
                    $result_input = query($mysqli, "INSERT INTO user (`login`,`password`,`prenom`,`nom`)VALUES('$login','$password','$prenom','$nom')");
                    if($result_input){
                        header("location:index.php");
                    }else{
                        echo "Erreur lier a la base de données ";  
                    }
                }
            }else{
                echo "Veuillez remplir toutes les informations SVP";
            }
        }else{
            echo "Veuillez remplir toutes les informations SVP";
        }
    }   

?>