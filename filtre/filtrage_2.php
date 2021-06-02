<?php 
            // Filtre pour les inputs avec une seule option et la zone de recherche .
			/*
			-------------------
				$basis : valeur de l'input .
				$array : Pour chaque annonce il y a un tableau contenant ses informations, c'est $array .
				$cle : c'est le nom ( name définie dans la balise ) des inputs remplies . 
			-------------------
			*/
			function filter($basis, $array, $cle){
				// Égale à 1 si l'annonce ($array) vérifie le filtrage.
			    $found = 0; 
				
				// Si la cle fait partient à un input de type string .
				if(!preg_match("/min/", $cle) && !preg_match("/max/", $cle)){
					$basiscpy=strtolower($basis);
					// Puiseque les annonces sont stockées de type "acheter"|"louer"
					if(preg_match("/acheter/", $basiscpy)){
						$basiscpy=str_replace("acheter", "vente", $basiscpy);
					}
					if(preg_match("/louer/", $basiscpy)){
						$basiscpy=str_replace("louer", "location", $basiscpy);
					}
					// Si la zone est remplie, donc on effectue la recherche sur tous les elements du l'annonce .
					// Une fois un élèment contient ce qui est cherché, donc c'est trouver (found) .
					if ($cle=="zone") {
						foreach ($array as $val) {
							$valmin=strtolower($val);
							if(@preg_match("/$basiscpy/", $valmin)){ 
								$found = 1;
							}		 
						} 
					} else {
						// Une fois un élèment contient ce qui est sélectionné, donc c'est trouver (found) .
						foreach ($array as $keydeux => $val) {
							if(preg_match("/$cle/",$keydeux)){
								$valmin=strtolower($val);
								if(@preg_match("/$basiscpy/", $valmin)){ 
									$found = 1;
								}
							}		 
						}
					}
				}
				// Si la cle fait partient à un input de type number .
				// MIN
				if(preg_match("/min/", $cle)){
					foreach ($array as $key => $val) {
						if($cle=="prixmin" && preg_match("/prix/", $key)){
							if($val >= $basis){
								$found = 1;
							}
						}
						if($cle=="superficiemin" && preg_match("/superficie/", $key)){
							$int = (int) filter_var($basis, FILTER_SANITIZE_NUMBER_INT);
							if($val >= $int){
								$found = 1;
							}
						}
					}
				}
				// MAX
				if(preg_match("/max/", $cle)){
					foreach ($array as $key => $val) {
						if($cle=="prixmax" && preg_match("/prix/", $key)){
							if($val <= $basis){
								$found = 1;
							}
						}
						if($cle=="superficiemax" && preg_match("/superficie/", $key)){
							$int = (int) filter_var($basis, FILTER_SANITIZE_NUMBER_INT);
							if($val <= $int){
								$found = 1;
							}
						}
					}
				}
				
						 
				return $found; 
			}

			// Filtre pour les inputs avec multiple options .
			/*
			-------------------
				$array : Pour chaque annonce il y a un tableau contenant ses informations, c'est $array .
				$cle : c'est le nom ( name définie dans la balise ) des inputs remplies . 
			-------------------
			*/			
			function filter_selection_multiple($array, $cle){
				$found = 0;

				// Input du Pièce max 
				// nombre de chambre et salle de bain de l'annonce ($array) > piecemin valeurs
				if($cle=="piecemin"){
					// = 1 , si l'attribut chambre de notre annonce vérifie la contrainte  (> optiongroup.chambre).
					$chambre=0;
					// = 1 , si l'attribut chambre de notre annonce vérifie la contrainte (> optiongroup.salledebqin).
					$bain=0;
					// $valeur1 : prend le premier choix du notre select (nbr chambres)
					$valeur1=0;
					// $valeur2 : prend le deuxième choix du notre select (nbr salles de bain)
					$valeur2=0;
					// Lors de parcours du tableau des valeurs (exp : $_POST["piecemin"])
					// On a besoin d'un indicateur qui indique que $valeur1 prend la 1ere valeur et $valeur2 prend la 2eme
					// c'est ça le rôle du $mincheck, une fois la 1ere valeur passe, on lui affectue 1 .
					$mincheck=0;
					// $_POST[$cle] : Pour une select avec plusieurs groupes les valeurs sont stockées sous forme d'un tableau .
					foreach ($_POST[$cle] as $valu) {
						if($mincheck==0){
							$valeur1=$valu;
							$mincheck=1;
						}
						if($mincheck==1) {
							$valeur2=$valu;
						}
					}
					// Parcour les propriétés de l'annonce, et si le nom du propriété correspond au select .
					foreach ($array as $key => $val) {
						if($valeur1!=0 && preg_match("/pieces/", $key)){
							if($valeur1<=$val){
								$chambre=1;
							}
						}
						if($valeur1==0) $chambre=1;
					
						if($valeur2!=0 && preg_match("/bain/", $key)){
							if($valeur2<=$val){
								$bain=1;
							}
						} 
						if($valeur2==0) $bain=1;
					}					
					if ($chambre==1 && $bain==1) {
						$found = 1;
					}
				}
				if($cle=="piecemax"){
					// même principe que dans le cas du select piecemin .
					$chambre=0;
					$bain=0;
					$valeur1=0;
					$valeur2=0;
					$maxcheck=0;
					// $_POST[$cle] : Pour une select avec plusieurs groupes les valeurs sont stockées sous forme d'un tableau .
					foreach ($_POST[$cle] as $valu) {
						if($maxcheck==0){
							$valeur1=$valu;
							$maxcheck=1;
						}
						if($maxcheck==1) $valeur2=$valu;
					}
					foreach ($array as $key => $val) {
						if($valeur1!=0 && preg_match("/pieces/", $key)){
							if($valeur1>=$val){
								$chambre=1;
							}
						}
						if($valeur1==0) $chambre=1;
					
						if($valeur2!=0 && preg_match("/salledebain/", $key)){
							if($valeur2>=$val){
								$bain=1;
							}
						}
						if($valeur2==0) $bain=1;
					}					
					if ($chambre==1 && $bain==1) {
						$found = 1;
					}
				}
				if(preg_match("/installation/", $cle)){
					// l'information du champ "installation" dans la BD est sous forme de binaire 
					// Même ordre est pris en compte que celle du table $installation
					// exp : 1010000010 : premier 1 indique "Piscine".  
					$installation=array("Piscine","Jardin","Balcon","Ascenseur","Terrasse","Meublé","Sécurité","Parking","Duplex","Concierge");
					
					// Chaque element de ce tableau a comme clef nom d'installation et comme valeur un bit du suite des bits stocker .
					// exp : $copyarray['Piscine] = 1
					$copyarray = array();
					
					// $check : taille = nombre des élèments sélectionnés . 
					// Si l'élèment sélectionné existe dans l'annonce alors $check[indice] = 1 sinon $check[indice] = 0.
					$check = array();
					foreach ($array as $key => $value) {
						if(preg_match("/installations/", $key)){
							for ($i = 0; $i < strlen($value); $i++){
							    $copyarray[$installation[$i]] = $value[$i];
							}
						}
					}
					$indice=0;
					foreach ($_POST[$cle] as $a){
    					foreach ($copyarray as $keyIns => $value) {
    						if($a==$keyIns && $value==1){ 
    							$check[$indice]=1;
    						}
    						if($a==$keyIns && $value==0){ 
    							$check[$indice]=0;
    						}
    					}
    					$indice++;
					}
					// Dès que la table $check se remplie, on vérifie s'elle contient la valeur 0, si oui l'annonce ne vérifie pas les
					// contraintes, si non on retourne found vrai . 
					$trouver=1;
					foreach ($check as $value){
						if ($value==0) {
							$trouver=0;
						}
					}
					if($trouver==1) $found = 1;
				}
				return $found; 
			}

			// copy le resultat retenue par select .
			// il sera le tableau global .
			$copytable = array();
			$sql="SELECT * FROM offres ORDER BY date_ajout_offre DESC";
			$result = $connection->query($sql);
		    if ($result->num_rows > 0) {
			  while($row = $result->fetch_assoc()) {
			    $copytable[] = $row;
			  }
			}
			// Tableau statique sur lequel on va effectue le filtre .
			// C'est lui qui sera utiliser pour afficher .
			$piececopy = $copytable;

			// Pour effectuer à chaque fois la recherche d'après le tableau global ( $piececopy=$copytable; )
			$piececheck = 1;
			$result = 0;
			if(isset($_POST["chercher"])){
				foreach($_POST as $key => $val){
					// l'input de type submit est la dérnière .
					// C'est à dire après le filtrage
					if($key=="chercher"){
						$piececheck=1;
					}
					if(!empty(${$key})){
						$filtre[$key] = $val;
						if($piececheck==1)
							$piececopy=$copytable;
						$usb = array_keys($piececopy);
						if (($key=="piecemin" || $key=="piecemax") || $key=="installation") {
							foreach($usb as $value){
								$result = filter_selection_multiple($piececopy[$value],$key);
								if($result==0){
									unset($piececopy[$value]);
								}
							}
						} else {
							foreach($usb as $value){
								$result = filter($val,$piececopy[$value],$key);
								if($result==0){
									unset($piececopy[$value]);
								}
							}
						}
						$piececheck=0;
					}
				}
			}
			$copydepiececopy=array();
			$i=0;
			foreach ($piececopy as $key => $value) {
				$copydepiececopy[$i]=$value;
				$i++;
			}
			$_SESSION["offres"]=$copydepiececopy;
			$total_records = count($copydepiececopy);
			$_SESSION["nombre"]=$total_records;
		   	/*On calcule le nombre des pages totale*/
		   	$limit = 3;
		   	$_SESSION["parpage"]=$limit;
			$total_pages = ceil($total_records / $limit);
			$_SESSION["nbrpage"]=$total_pages;
			/*-------------------*/
?>