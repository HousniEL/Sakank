<?php
	session_start();
	$tab=array("Appartement","Villa","Maison","Loft","Chambre","Terrain","Riad","Studio","Bureau","Magasin","Fond de commerce","Autre");
	$install=array("Piscine","Jardin","Balcon","Ascenseur","Terrasse","Meublé","Sécurité","Parking","Duplex","Concierge");
	// Iniatiliser les variables $_POST
	foreach($_POST as $key=>$val)
		${$key}=$val;
	include 'BD.php';
	$_SESSION["bd"] = $connection;
?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<title>Filtrage</title>
		<meta name="viewport" content="width = device-width, initial-scale = 1">
		<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
		<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		<?php 
			include '../Header/header.php';
		?>
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.4/umd/popper.min.js"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
		<script src="./scripts/filtrage.js" defer></script>
		<link rel="stylesheet" type="text/css" href="./filter.css">
		<link rel="stylesheet" type="text/css" href="./listeAnnonce/listeAnnonces.css">
	</head>
	<body>
		<div class="container">
			<div class="row">
				<form id="myform" class="col-md" name="fo" method="post" action="">
					<div id="mon" class="container">
						<div class="row">
							<div id="block1" class="form-group col-lg-3 col-md-3 col-sm-6" style="background-color: #233040; padding:1%; margin: 0%;">
								<select class="form-control selectpicker" title="Type d'offre" id="type" name="type" data-style="btn-default">
							      <option class="tup">Acheter</option>
							      <option class="tup">Louer (Par mois)</option>
							      <option class="tup">Louer (Par nuit)</option>
							    </select>
							</div>
							<div id="block2" class="form-group col-lg-3 col-md-3 col-sm-6" style="background-color: #233040; padding:1%; margin: 0%; border: solid 1px #233040;">
								<input id="prixmin" type="number" name="prixmin" class="form-control" placeholder="Prix min (DH)" min="0">
							</div>
							<div id="block3" class="form-group col-lg-3 col-md-3 col-sm-6" style="background-color: #233040; padding:1%; margin: 0%; border: solid 1px #233040;">
								 <select id="piecemin" class="form-control selectpicker" title="Pièces min" name="piecemin[]" label="cham" multiple data-style="btn-default" >
                                    <optgroup label = "Chambres" data-max-options="1" data-icon="fa fa-bed">
                                       	<?php
									      	for($i=1;$i<=5;$i++){
									      		if ($i!=5) {
									      			if ($i==1){ echo "<option title=\"$i Chambre\" class=\"tup\">$i</option>";
									      			}else echo "<option title=\"$i Chambres\" class=\"tup\">$i</option>";
									      		}
									      		if ($i==5) {
									      			echo "<option title=\"4+ Chambres\" class=\"tup\" >4+</option>";
									      		}
									      	}
									    ?>
                                    </optgroup> 
                                    <optgroup label = "Salles de bain" data-max-options="1" data-icon="fa fa-bath">
                                       	<?php
									      	for($i=1;$i<=5;$i++){
									      		if ($i!=5) {
									      			if ($i==1){ echo "<option title=\"$i Salle de bain\" class=\"tup\">$i</option>";
									      			}else echo "<option title=\"$i Salles de bains\" class=\"tup\">$i</option>";
									      		} 
									      		if ($i==5) {
									      			echo "<option title=\"4+ Salles de bains\" class=\"tup\">4+</option>";
									      		}
									      	}
									    ?>
                                    </optgroup>
                                 </select>
							
							</div>
							<div id="block4" class="form-group col-lg-3 col-md-3 col-sm-6" style="background-color: #233040; padding:1%; margin: 0%; border: solid 1px #233040;">
								<input id="superficiemin" type="number" name="superficiemin" class="form-control" placeholder="Superficie min (m²)" min="0">
							</div>
							<div class="w-100"></div>
							<div id="block5" class="form-group col-lg-3 col-md-3 col-sm-6" style="background-color: #233040; padding:1%; margin: 0%; border: solid 1px #233040;">
								<select class="form-control selectpicker" title="Catégorie" id="categorie" name="categorie" data-style="btn-default">
							      <?php
							      		foreach($tab as $val){
							      			echo "<option class=\"tup\">$val</option>";
							      		}
							      ?>
							    </select>
							</div>
							<div id="block6" class="form-group col-lg-3 col-md-3 col-sm-6" style="background-color: #233040;  padding:1%; margin: 0%; border: solid 1px #233040;">
								<input id="prixmax" type="number" name="prixmax" class="form-control" placeholder="Prix max (DH)" min="0">
							</div>
							<div id="block7" class="form-group col-lg-3 col-md-3 col-sm-6" style="background-color: #233040;  padding:1%; margin: 0%; border: solid 1px #233040;">
								 <select id="piecemax" class="form-control selectpicker" title="Pièces max" name="piecemax[]" multiple data-style="btn-default">
                                    <optgroup label = "Chambres" data-max-options="1" data-icon="fa fa-bed">
                                       	<?php
									      	for($i=1;$i<=5;$i++){
									      		if ($i!=5) {
									      			if ($i==1){ echo "<option title=\"$i Chambre\" class=\"tup\">$i</option>";
									      			}else echo "<option title=\"$i Chambres\" class=\"tup\">$i</option>";
									      		}
									      		if ($i==5) {
									      			echo "<option title=\"4+ Chambres\" class=\"tup\">4+</option>";
									      		}
									      	}
									    ?>
                                    </optgroup> 
                                    <optgroup label = "Salles de bain" data-max-options="1" data-icon="fa fa-bath">
                                       	<?php
									      	for($i=1;$i<=5;$i++){
									      		if ($i!=5) {
									      			if ($i==1){ echo "<option title=\"$i Salle de bain\" class=\"tup\">$i</option>";
									      			}else echo "<option title=\"$i Salles de bains\" class=\"tup\">$i</option>";
									      		} 
									      		if ($i==5) {
									      			echo "<option title=\"4+ Salles de bains\" class=\"tup\">4+</option>";
									      		}
									      	}
									    ?>
                                    </optgroup>
                                 </select>
							</div>
							<div id="block8" class="form-group col-lg-3 col-md-3 col-sm-6" style="background-color: #233040; padding:1%; margin: 0%; border: solid 1px #233040;">
								<input id="superficiemax" type="number" name="superficiemax" class="form-control" placeholder="Superficie max (m²)" min="0">
							</div>
							<div class="w-100"></div>
							<div id="block9" class="form-group col-lg-3 col-md-3 col-sm-6" style="background-color: #233040; padding:1%; margin: 0%; border: solid 1px #233040;">
							    <select class="form-control selectpicker" title="Ville" id="Ville" name="Ville" data-style="btn-default">
							      <?php
							      	$res = fopen('villes.txt', 'rb');
							      	while(!feof($res)){
							      		$ligne = fgets($res);
							      		echo "<option class=\"tup\">$ligne</option>";
							      	}
							      ?>
							    </select>
							</div>
							<div id="block10" class="form-group col-lg-3 col-md-3 col-sm-6" style="background-color: #233040; padding:1%; margin: 0%; border: solid 1px #233040;">
								<select id="installation" class="form-control selectpicker" title="Installations" name="installation[]" multiple data-live-search="true" data-live-search-placeholder="Search" data-actions-box="true" data-style="btn-default">
								<?php
							      		$i=1;
							      		foreach($install as $val){
							      			echo "<option class=\"tup\">$val</option>";
							      			$i++;
							      		}
							    ?>
								</select>
							</div>
							<div id="block11" class="input-group form-group col-lg-6 col-md-6 col-sm-12" style="background-color: #233040; padding:1%; margin: 0%; border: solid 1px #233040;">
								<input id="zone" class="form-control my-0 py-1" type="text" placeholder="" name="zone" aria-label="Search">
								<div class="input-group-prepend" style="height: 38px;">
								    <span class="input-group-text purple lighten-3" id="basic-text1" style="background-color: #26966d; border: none;">
								    	<button id="chercher" type="submit" name="chercher" aria-hidden="true">Chercher</button>
								    </span>
							    </div>
							</div>
							<div class="w-100"></div>
							<div id="block11" class="input-group form-group" style="background-color: #fff; ">
								<div class="input-group-prepend">
								    <input type="reset" name="reinstaller" class="btn btn-danger shadow-none" placeholder="Reinstaller" style="border-radius: 0; " data-style="" onclick="refaire()">
							    </div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
		<!-- Filtrage -->
		<?php include 'filtrage_2.php' ?>

		<!-- Liste des annonces -->
		<div id="target-content"></div>

		<!-- Pagination element -->
		<nav style="margin-top: 20px; margin-bottom: 30px; ">
		    <ul class="pagination justify-content-center">
		        
		        <?php for($i=1; $i<=$total_pages; $i++){ ?>
		            <li class="pageitem" id="<?php echo $i;?>"><a href="#page=<?php echo $i;?>" class="page-link" ><?php echo $i;?></a></li>
		        <?php } ?>
		   
		    </ul>
		</nav>
		<?php include '../Footer/footer.php';  ?>


		<!------------------------------------------Script avec PHP--------------------------------------------------->
		<!-- Pour garder les valeurs sélectionner après le submit -->

		<?php 
			foreach ($_POST as $key => $valu) {
				if(!empty(${$key})){
					if(($key!="installation" && $key!="piecemin") && $key!="piecemax"){
						echo $key;
		?>
		<script >
			var id="<?php echo "$key"; ?>";
			if((id=="type" || id=="Ville") || id=="categorie"){
				$('#'+id).selectpicker('val',"<?php echo "$valu" ?>");
				$('#'+id).selectpicker('refresh');
			}else{
				document.getElementById(id).value="<?php echo "$valu" ?>";
			}
		</script>
		<?php
					}
				}
			}
			foreach ($_POST as $key => $value) {
				if(!empty(${$key})){
					if($key=="installation" || $key=="piecemin" || $key=="piecemax"){
		?>
						<script>
							i=1;
							var copy = new Array();
						</script>
						<?php
						foreach ($_POST[$key] as $a){
		?>
		<script>
			var outpt="<?php echo "$a" ?>";
			if(outpt!='4+'){var out=outpt-1;
			}else var out=4;
			id="<?php echo "$key"; ?>";
			var ident='#'.concat(id);
			copy.push(outpt);
			if (id=="piecemin" || id=="piecemax") {
					$(ident.concat(" optgroup:not(optgroup:eq(" + i + "))")).children("option:eq(" + out + ")").prop("selected", true);
					$('#'.concat(id)).selectpicker('refresh');
			}
           	i--;
		</script>
		<?php 
						}
		?>
		<script>
			if ((id!="piecemin") && (id!="piecemax")) {
				$('#'.concat(id)).selectpicker('val',copy);
				$('#'.concat(id)).selectpicker('refresh');
			}
		</script>
		<?php
					}
				}
			} 
		?>
	</body>
</html>
