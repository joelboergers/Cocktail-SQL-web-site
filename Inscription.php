
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>
<span>
    <?php
        require "Inscription_check.php";
    ?>
</span>


<!-- Syteme pour s'inscrire HTML -->
    <form action="Inscription.php" method="post" >
    <h1> Please enter your information to register</h1>
        Login Name:
        <br><input type = "text"  name = "username" require/><br>

        Password:
        <br><input type = "password" name = "password" require/><br>

        Nom:
        <br><input type = "text"  name = "nom" /><br>

        Prénom:
        <br><input type = "text"  name = "prenom" /><br>

        <br/>
        <br/>
     <input type = "submit" name="submit_btn" id = "submit" value = "submit"/>
    </form>
    <a href="index.php">Retour vers la page d'acceuil</a>
</body>
</html>