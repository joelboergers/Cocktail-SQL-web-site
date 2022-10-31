<?php
	session_start();
	require("initialiser.php");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Recettes de Cocktails</title>
	<meta charset="utf-16">
	<link rel="stylesheet" type="text/css" href="css\style.css?v=1.1">
</head>

<body>
	<nav>
		<h1>Recettes de Cocktails</h1>
		<?php
			require "Connexion_check.php";
		?>
		<form method="post" action="Index.php">
    		<ul class="login_ul">
			<?php
				if(isset($_SESSION['username_status']) && $_SESSION['username_status'] == true){
					echo $_SESSION['username_info']["prenom"] . " ";
					echo $_SESSION['username_info']["nom"];
					?> 
					<input type="button" onclick="location.href='User_Info.php'" value = "Mes Informations"/>
					<input type="button" onclick="location.href='Deconnexion.php'" value = "Deconnexion"/>
					<?php
				}else{
					?>
						<li> Username :
						<li> <input type="text" name="username">
						<li> Password :
						<li> <input type="password" name="password">
						<li class="btn"> <input type="submit" name="login" value="login">
						<li class="btn"> <input type="button" onclick="location.href='Inscription.php'" value="inscription">
					<?php
				}
			?>
    		</ul>
		</form>
	</nav>

	<div class="container">
		<div class="recette">
			<h2>Recettes</h2>
			<ul>
				<?php
				//affichage detailer en fonction d'une recettes
				if(isset($_GET['id_recette'])){
					//requetes SQL
					$id_recette = mysqli_real_escape_string($mysqli,$_GET['id_recette']);
					$result_recette = query($mysqli, "SELECT * FROM `recette` WHERE `id_recette` ='$id_recette'");
					$result_aliment = query($mysqli, "SELECT C.id_aliment,A.nom_aliment FROM aliment A,composition C WHERE C.id_recette = '$id_recette' AND C.id_aliment = A.id_aliment");

					//convetion des requetes en array
					$result_recette_array = mysqli_fetch_array($result_recette);	
					$result_aliment_array = mysqli_fetch_all($result_aliment);
					$count_row = count($result_aliment_array);	
					
					//affichage des requetes
					$path = "Photos/".ucfirst(strtolower(str_replace(" ", "_", $result_recette_array['titre']))).".jpg";
					
					if(file_exists("$path")){
						echo "<img src=$path alt=\"$result_recette_array[titre]\"/>";
					}
					echo"
					<li> <strong>Titre:</strong> ".$result_recette_array['titre']."</li>
					<li> <strong>Ingredients:</strong> ".$result_recette_array['ingredients']."</li>
					<li> <strong>Preparation:</strong> ".$result_recette_array['preparation']."</li>
					<li> <strong>Aliment:</strong></li>";
					for($i=0; $i<$count_row; $i++){
					echo "
					<li><a href = index.php?id_aliment=".$result_aliment_array[$i][0].">".$result_aliment_array[$i][1]."</a></li>";
					}
				//code pour les recettes en fonctions d'un aliments
				}elseif(isset($_GET['id_aliment'])){
					//requetes SQL
					$id_aliment = mysqli_real_escape_string($mysqli,$_GET['id_aliment']);
					$result_recette_en_fonction_dun_aliment = query($mysqli, "SELECT * FROM recette r,composition c WHERE c.id_recette = r.id_recette AND c.id_aliment = '$id_aliment' ");
					
					//convetion des requetes en array
					while($result_recette_en_fonction_dun_aliment_array = mysqli_fetch_array($result_recette_en_fonction_dun_aliment)){
						echo "
						<li><a href=index.php?id_recette=".$result_recette_en_fonction_dun_aliment_array["id_recette"].">".$result_recette_en_fonction_dun_aliment_array["titre"]."</a></li>";
					}

				//code pour l'affichage de toutes les recettes
				}else{

					//requete/convertion/affiachage
					$result_titre = query($mysqli, "SELECT `id_recette`,`titre` FROM `recette` ORDER BY `titre` asc");
					while($result_arr_titre = mysqli_fetch_array($result_titre)){
						echo "
						<li><a href=index.php?id_recette=".$result_arr_titre["id_recette"].">".$result_arr_titre["titre"]."</a></li>";
					}
				}
				?>

			</ul>
		</div>
		<?php
			if(isset($_SESSION['username_status']) && $_SESSION['username_status'] == true){
		?>

		<div class="tableau">
			<h2>Liste des Recettes</h2>
			<table class="table">
				<tr >
					<th>
						<a href = "index.php?nom=nom">
							Nom des Recettes
						</a>
					</th>
					<th>
						<a href = "index.php?nb=nb">
							Nombre d'aliment
						</a>
					</th>
				</tr>
				<?php
					$request = "SELECT C.id_aliment, A.nom_aliment nom, COUNT(C.id_aliment) nb FROM aliment A,composition C, recette R WHERE C.id_recette =  r.id_recette AND C.id_aliment = A.id_aliment GROUP BY A.nom_aliment ";
					
					if(isset($_GET['nom'])){
						$request.= "ORDER BY ".$_GET['nom']." ASC";
					}elseif(isset($_GET['nb'])){
						$request.= "ORDER BY ".$_GET['nb']." DESC";
					}
					$result = query($mysqli, $request);
					
					while($row = mysqli_fetch_assoc($result)){
						echo "
					<tr>
						<td><a href = index.php?id_aliment=".$row["id_aliment"].">".$row["nom"]."</a></td>
						<td text-align: center; >".$row["nb"]."</td>
					</tr>";
					}
				?>
			</table>
		</div>

		<?php
			}
		?>
	</div>

</body>
</html>