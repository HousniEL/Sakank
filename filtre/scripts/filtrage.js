// Une fois la page chargée, elle affichera les annonces d'après "listeAnnonces.php"
$(document).ready(function() {
    $("#target-content").load("./listeAnnonce/listeAnnonces.php?page=1");
    $("#1").addClass("active");
    // chaque fois on clique sur l'un des pages
    // On informe "listeAnnonces.php" qui va envoie les annonces selon la page.
    $(".pageitem").click(function(){
        var page = this.id;
        $.ajax({
            url: "./listeAnnonce/listeAnnonces.php",
            type: "GET",
            data: {
                page : page
            },
            cache: false,
            success: function(dataResult){
                $("#target-content").html(dataResult);
                $(".pageitem").removeClass("active");
                $("#"+page).addClass("active");
                
            }
        });
    });
});

// Pour assurer que l'on choisit qu'une seule option par groupe . 
$('#piecemin').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
    $('.selectpicker').selectpicker('refresh')
});
$('#piecemax').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
    $('.selectpicker').selectpicker('refresh')
});

//Donner une valeur par défaut pour  la zone de recherche du selector "Installation"
$('.selectpicker').selectpicker(
    {  
        liveSearchPlaceholder: ''
    }
);


// Vider les selections .
// Dès que le bouton "réinstaller" est cliqué, cette fonction sera appeler .
function refaire(){
    $('.selectpicker').selectpicker('val','');
    $('.selectpicker').selectpicker('refresh');
};


//  Affichage totale de l'annonce 
function annonce_affichage(index){
    window.location.href = "AfficherAnnonce.php?annonce=" + index;
}