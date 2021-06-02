<?php
	session_start();
	include '../BD.php';
	$limit = $_SESSION["parpage"];
	$nombre = $_SESSION["nombre"];

	if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; }; 

	// Par exemple, si le limit d'annonces par page égale 5 et c'est la deuxième page
	// alors les 5 annonces extrait à partir du BD commence à partir de
	// (2*5)-5 = 5 ( 5ème annonce )
	$start_from = ($page*$limit)-$limit;

	// piece = annonce
	// $_SESSION["offres"] : table des annonces récupérer à partir de 'filtrage_2.php'
   	$pieces=$_SESSION["offres"];
	/*Données à afficher*/
		$type_de_bien="";
		$cat="";//categorie
		$surface="";
		$loca_ville="";
		$loca_quartier="";
   	/*--------------------*/
   	$edge = $limit + $start_from;
   	if(($nombre-$start_from)<$limit) $edge=$start_from+($nombre-$start_from);
	echo "<div class=\"container col-lg-8 col-md-8 col-sm-12\" style=\"padding: 0; margin:auto;\">";
	echo "<div class=\"row container\" style=\"padding:0; margin:auto; display: flex; justify-content: center;\">";
	for ($i=$start_from ; $i < $edge; $i++) {
			foreach($pieces[$i] as $clefs => $va){
				if($clefs=="id_offre"){
					$id_image= mysqli_query($connection,"select nom_image from images where id_offre=$va");
					$rempli = 0;
					$imgs = array();
					while($row = $id_image->fetch_assoc()) {
						$rempli=1;
						array_push($imgs,$row["nom_image"]);
					}
					$tab_img='';
					$image_choisi=0;
					echo "<div id=\"$va\" class=\"contientannonce\" onClick=\"annonce_affichage(this.id)\">";
					echo "<div class=\"photo \">";
					if($rempli==1){
						foreach($imgs as $valeurr) {
							if ($image_choisi==0) {
								$tab_img="./Upload/".$valeurr;
							  	echo "<img src=\"$tab_img \" width=100% height=100%>";
							} 
							$image_choisi++;
						}
						echo "<div class=\"bottom-left\" style=\"position: absolute; top: 85%; left: 1%; color: white;\">$image_choisi&nbsp<span class=\"fa fa-camera\"></span></div>";
					}else{
                     	echo "<img src='./Upload/Images/defaut_image.jpg' width=100% height=100% class='defautImage'>";      
					}
					echo "</div>";
					echo "<div class=\"info\">";
				}

				if($va=="Vente") $type_de_bien=" DH";
				if($va=="Location (Par mois)") $type_de_bien=" DH/Mois";
				if($va=="Location (Par nuit)") $type_de_bien=" DH/Nuit";
			}
			foreach($pieces[$i] as $clefs => $va){
				if($clefs=="prix_offre"){
					echo "<div class=\"container\" style=\"font-size:15pt; margin-bottom:10px;\">";
					echo "<div class=\"row\">";
					echo "<div class=\"prix col-lg-6 col-md-6 col-sm-6\" style=\" font-weight: bold; padding:0px;\">";
					echo number_format($va).$type_de_bien;
					echo "</div>";
				} 
				if($clefs=="date_ajout_offre"){
					echo "<div class=\"temps col-lg-6 col-md-6 col-sm-6\" style=\"text-align: right;\">";
					$phpdate = strtotime( $va );
					$mysqldate = date( 'd-m-Y H:i', $phpdate );
					$mysqldatecopy = date( 'd/m/Y H:i', $phpdate );
					$aujourdhui = date('d-m-Y H:i');
					$diff = abs(strtotime($mysqldate) - strtotime($aujourdhui));
					$min = floor($diff / (60*60*24));
					if($min==0){
						$dat = date( 'H:i', $phpdate );
						echo "Aujourd'hui à ".$dat;
					} elseif ($min==1) {
						$dat = date( 'H:i', $phpdate );
						echo "Hier à ".$dat;
					} else echo $mysqldatecopy;
					echo "</div>";
					echo "</div>";
					echo "</div>";
				}
			}
			foreach($pieces[$i] as $clefs => $va){
				if($clefs=="categorie_offre"){
					$cat=$va;
				}
				if($clefs=="superficie_offre"){
					$surface=$va;
				}
				if($clefs=="localisation_ville_offre"){
					$loca_ville=$va;
				}
				if($clefs=="localisation_quartier_offre"){
					$loca_quartier=$va;
				}
			}
			foreach($pieces[$i] as $clefs => $va){
				if($clefs=="id_offre"){
					echo "<div class='location'  style=\"color:gray;  margin-bottom:10px;\">";
					echo "<span class=\"fa fa-map-marker\"></span>&nbsp&nbsp".$loca_quartier." , ".$loca_ville;
					echo "</div>";
				}
				if($clefs=="nom_offre"){
					echo "<div class='titre' style=\"margin-bottom:10px;\">";
					echo ucfirst($va);
					echo "</div>";
				}
				if($clefs=="nmbre_pieces_offre"){
					echo "<div class='catEtpieces'>";
					echo $cat."&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp";
					echo $va."&nbsp<span class=\"fa fa-bed\"></span>&nbsp&nbsp&nbsp";
				}
				if($clefs=="nmbre_saledebain"){
					echo $va."&nbsp<span class=\"fa fa-bath\"></span>&nbsp&nbsp&nbsp&nbsp";
					echo $surface." m²";
					echo "</div>";
				}
			}
			echo "</div>";
		echo "</div>";
	}
	echo "</div>";
	echo "</div>";
?>