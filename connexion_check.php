<?php
    $mysqli=mysqli_connect($host,$user,$pass,$base) or die("Problème de création de la base :".mysqli_error($string_error));
    //echo "oui";
    //system de login
    if(isset($_POST['login'])){
        
        // on recup tout
        $username = $_POST["username"];
        $password = $_POST['password'];

        // on verifie
        if(isset($username) && isset($password)){
            if($username != " " && $password != " "){
                // on envoi si tout est bon
                $result = query($mysqli, "SELECT `login`,`password`,`prenom`,`nom` FROM user WHERE login = '$username' AND password = '$password'"); 
                $result_user_info = mysqli_fetch_array($result);
                $result_user = mysqli_num_rows($result);
                if($result_user == 1){
                    $user_connection_status = true;
                    $_SESSION['username_status'] = $user_connection_status;
                    $_SESSION['username_info'] = $result_user_info;
                }else{
                    echo "Le nom d'utilisateur ou le mot de passe est incorrect";
                }
            }else{
                echo "Veuillez remplir les deux champs";
            }
        }else{
            echo "Veuillez remplir les deux champs";
        }
    }
?>