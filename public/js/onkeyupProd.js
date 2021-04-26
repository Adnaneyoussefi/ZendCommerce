
$(document).ready(() => {
$("#inputNom").keyup(function(){
    $('#nom').hide();
});
$("#inputDesc").keyup(function(){
    $('#desc').hide();
});
$("#inputPrix").keyup(function(){
    $('#prix').hide();
    $('#prixNot').hide();
});
$("#inputQuantite").keyup(function(){
    $('#quantite').hide();
    $('#quantiteNot').hide();
});

})
