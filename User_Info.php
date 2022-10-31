<?php
    session_start();
    include "Parametres.php";
    include "Fonctions.inc.php";
    $mysqli=mysqli_connect($host,$user,$pass,$base) or die("Problème de création de la base :".mysqli_error($string_error));
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Information Utilisateur</title>
</head>
<body>
    <h1>Information Utilisateur</h1>
    
    <?php
        echo "Login: ".$_SESSION['username_info']["login"] . "<br>";
        echo "Password: ".$_SESSION['username_info']["password"]. "<br> ";
        echo "Nom: ".$_SESSION['username_info']["nom"]. "<br> ";
        echo "Prenom: ".$_SESSION['username_info']["prenom"]."<br><br>" ;

        if(isset($_POST['submit_btn'])){
            //on recupere tout ($_POST)
            $login = $_POST['username'];
            $password = $_POST['password'];
            $nom = $_POST['nom'];
            $prenom = $_POST['prenom'];

            $_SESSION['username_info']["password"] = $password;
            $_SESSION['username_info']["nom"] = $nom;
            $_SESSION['username_info']["prenom"] = $prenom;

            $result_input = query($mysqli, "UPDATE user SET password ='$password', prenom = '$prenom', nom = '$nom' WHERE login = '$login'");
            if($result_input){
                echo "les données on bien etais modifier";
             }else{
                 echo "Erreur lier a la base de données ";  
             }

        }
    ?>
    <form action="user_info.php" method="post" >
    <h1> Modifications des données</h1>
        Login Name:
        <br><input type = "text"  name = "username" require value="<?php echo $_SESSION['username_info']["login"] ?>" readonly="readonly"/><br>

        Password:
        <br><input type = "text" name = "password" require value="<?php echo $_SESSION['username_info']["password"] ?>"/><br>

        Nom:
        <br><input type = "text"  name = "nom" value="<?php echo $_SESSION['username_info']["nom"] ?>"/><br>

        Prénom:
        <br><input type = "text"  name = "prenom" value="<?php echo $_SESSION['username_info']["prenom"] ?>"/><br>

        <br/>
        <br/>
     <input type = "submit" name="submit_btn" id = "submit" value = "submit"/>
    </form>
    <a href="index.php">Retour vers la page d'acceuil</a>
    

</body>
</html>