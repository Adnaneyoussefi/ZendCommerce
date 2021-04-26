
$(document).ready(() => {
$("#inputNom").keyup(function(){
    $('#nom').hide();
});
$("#inputDesc").keyup(function(){
    $('#desc').hide();
});
$("#inputPrix").keyup((e) => {
    
    let prix = e.currentTarget.value;
    if(prix == Number(prix))
        $('#prixNot').hide();
    else 
        $('#prixNot').show();
    $('#prix').hide();
    
});
$("#inputQuantite").keyup(function(){
    $('#quantite').hide();
    $('#quantiteNot').hide();
});

})
