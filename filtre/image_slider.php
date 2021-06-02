<div id="carouselExampleIndicators" class="carousel slide" style="height:100%;">
  <ol class="carousel-indicators">
    <?php
          $id_image= mysqli_query($connection,"select nom_image from images where id_offre=$indice");
          $rempli = 0;
          $imgs = array();
            while($row = $id_image->fetch_assoc()) {
              $rempli=1;
              array_push($imgs,$row["nom_image"]);
            }
          $tab_img='';
          $image_choisi=0;
          if($rempli==1){
            foreach($imgs as $valeurr) {
              $tab_img="./Upload/".$valeurr;
              if ($image_choisi==0) {
                  echo "<li data-target=\"#carouselExampleIndicators\" data-slide-to=\"$image_choisi\" class=\"active\"><img class='d-block' src=\"$tab_img\" width=100% height=100%></li>";
              } else { 
                echo "<li data-target=\"#carouselExampleIndicators\" data-slide-to=\"$image_choisi\"><img class='d-block' src=\"$tab_img\" width=100% height=100%></li>";
              }
              $image_choisi++;
            }
          }
    ?>
  </ol>
  <div class="carousel-inner" style="height: 100%;">
        <?php
          $image_choisi=0;
          if($rempli==1){
            foreach($imgs as $valeurr) {
              $tab_img="./Upload/".$valeurr;
              if ($image_choisi==0) {
                  echo "<div class=\"carousel-item active\" style=\"height:100%;\">";
                  echo "<img class=\"d-block w-100 h-100\" src=\"$tab_img\">";
                  echo "</div>";
              } else {
                echo "<div class=\"carousel-item\" style=\"height:100%;\">";
                echo "<img class=\"d-block w-100 h-100\" src=\"$tab_img\">";
                echo "</div>";
              }
              $image_choisi++;
            }
          }else{
                echo "<img src=\"./Upload/Images/defaut_image.jpg\" height=100% width=100%  style=\"border-right:solid 1px black; \">";      
          }
      ?>
  </div>
  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true" ></span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
  </a>
</div>