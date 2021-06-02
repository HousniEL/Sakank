<?php
	session_start();
	$indice = $_GET['annonce'];
	include 'BD.php';
	$offres= mysqli_query($connection,"select * from offres where id_offre=$indice");
	$pieces=array();
	while($row = $offres->fetch_assoc()) {
		$pieces = $row;
	}
	$installa = array("Piscine","Jardin","Balcon","Ascenseur",
	"Terrasse","Meublé","Sécurité","Parking","Duplex","Concierge");
?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<title><?php echo $pieces["nom_offre"]; ?></title>
		<meta name="viewport" content="width = device-width, initial-scale = 1">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		<?php 
			include '../Header/header.php';
		?>
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-color/2.1.2/jquery.color.min.js"></script>
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.4/umd/popper.min.js"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="AfficherAnnonce.css">
		<style type="text/css">
			#full{
				width: 75%;
			}
			#cadre{
				height: 450px;
			}
			#categorie{
				font-size: 12pt;
			}
			#installations{
				font-size: 12pt;
			}
			@media screen and (max-width:766px) {
				#full{
					width: 100%;
				}
				#categorie{
					font-size: 10pt;
				}
				#installations{
					font-size: 10pt;
				}
				.carousel-indicators{
					display: none;
				}
				#cadre{
					height: 220px;
					width:100%;
				}
			}
		</style>
	</head>
	<body>
		<div id="full" class="container" style="width: 80%;">
			<?php echo "<h1>".ucfirst($pieces['nom_offre'])."<h1>"; ?>
			<div class="row">
				<div class="container col-lg-8 col-md-8 col-sm-12">
					<div class="row" style="/*border: solid 1px black;">
						<div id="cadre" class="col" style="border: solid 0.1px black; margin-bottom:10%; padding:0px; text-align: center;">
							<?php
								include("image_slider.php");
							?>
						</div>
						<div class="w-100"></div>
						<div id="categorie" class="container col-lg-6 col-md-6 col-sm-12" style=" margin-top:5%; ">
							<h2>Caractéristiques</h2>
							<div class="row" style="margin-top:5%;">
								<?php
									if($pieces["type_offre"]=="Vente") $ty_de_bien=" DH";
									if($pieces["type_offre"]=="Location (Par mois)") $ty_de_bien=" DH/Mois";
									if($pieces["type_offre"]=="Location (Par nuit)") $ty_de_bien=" DH/Nuit";
									foreach($pieces as $key => $valeur){
										if(($key=="categorie_offre" || $key=="prix_offre") || ($key=="nmbre_pieces_offre" || $key=="nmbre_saledebain")){
										echo "<div class=\" col-lg-6 col-md-6 col-sm-6 \" style=\" margin-bottom:3%; border-bottom:solid 1px gray; width:50%; padding-bottom:3%;\">";
										if($key=="prix_offre") echo "Prix";
										if($key=="categorie_offre") echo "Catégorie";
										if($key=="nmbre_pieces_offre") echo "Chambres";
										if($key=="nmbre_saledebain") echo "Salles de bains";
										echo "</div>";
										echo "<div class=\" col-lg-6 col-md-6 col-sm-6 col-xs-6 \" style=\"margin-bottom:3%; border-bottom:solid 1px gray; width:50%; padding:0; padding-bottom:3%;\">";
										if($key=="prix_offre"){ echo number_format($valeur).$ty_de_bien;
										}else echo $valeur;
										echo "</div>";
										echo "<div class=\" w-100 \"></div>";
										}
									}
								?>
							</div>
						</div>
						<div id="installations" class="container col-lg-6 col-md-6 col-sm-12" style="/*border: solid 1px black;*/ margin-top:5%;">
							<h2>Installations</h2>
							<div class="row" style="margin-top: 5%;">
								<?php
									$copyarray = array();
									$value = $pieces["installations_offre"];
									for ($i = 0; $i < strlen($value); $i++){
										$copyarray[$installa[$i]] = $value[$i];
									}
									
									foreach ($copyarray as $key => $a){
									  if($a==1){
										echo "<div class=\" col-lg-6 col-md-6 col-sm-6\" style=\" font-size:11pt; margin-bottom:10px; width:50%; \">";
										echo "<span class=\"fa fa-check\" style=\" color:green; \"></span>&nbsp".$key;
										echo "</div>";
									  }
									}
								?>
							</div>
						</div>
						<div class="w-100"></div>
						<div class="" style="/*border: solid 1px black;*/ width: 100%;">
							<h2>Description</h2>
						</div>
					</div>
				</div>
				<div class="container col-lg-4 col-md-4 col-sm-12">
				<?php
					$id_utilisateur = $pieces['id_user'];
					$user= mysqli_query($connection,"select * from users where id_user=$id_utilisateur");
					$utilisateur=array();
					while($row = $user->fetch_assoc()) {
						$utilisateur = $row;
					}
				?>
					<div style="border: solid 1px; margin: .5rem auto; padding: .5rem; border-radius: 5px; width: 100%;">
						<div class="user" style="display: flex; flex-direction: column; justify-content: center; align-items: center;">
							<span class="fa fa-user" style="font-size: 3rem; padding: .8rem 1.2rem; border-radius: 100%; border: 1px solid;"></span>
							<div style="font-size: 1.5rem;">
								<?php echo $utilisateur['nom_complet_user'] ?>
							</div>
						</div>
						<div class="location" style="display: flex; justify-content: center;">
								<div style="font-size: 1rem; color: gray; margin-top">
									<span class="fa fa-map-marker"></span>
									<?php echo $pieces['localisation_quartier_offre'].' , '.$pieces['localisation_ville_offre'] ?>
								</div>
						</div>
						<div class="telephone" style="display: flex; justify-content: center;">
							<button style="padding: .5rem .8rem; border: 1px solid; font-size: 1rem; margin: 1.5rem; background-color: transparent; outline: none;  color: #26966d;">Téléphone</button>
						</div>
					</div>	
				</div>
				
			</div>
		</div>
		<?php
			include "../Footer/footer.php";
		?>	
	</body>
	<script>
		$(document).ready(() => {
			$('.telephone > button').on('focus', () => {
				$('.telephone > button').animate({
					backgroundColor : "#26966d",
					color: 'white'
				}, {
					duration: 500,
					step: function(){
						$(this).text(<?php echo $utilisateur['num_tel_user'] ?>);
					}
				});
			});

			$('.telephone > button').on('blur', () => {
				$('.telephone > button').animate({
					backgroundColor : "transparent",
					color: '#26966d'
				}, {
					duration: 500,
					step: function(){
						$(this).text('Téléphone');
					}
				});
			});
		});
	</script>
</html>