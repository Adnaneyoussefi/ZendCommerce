$(document).ready(() => {
    function isNumeric(n) {
        return !isNaN(parseFloat(n)) && isFinite(n);
      }
    $('#form').submit((e) => {
        $bool = true;
        var nom = document.forms["form"]["nom"];
        var desc = document.forms["form"]["description"];
        var prix = document.forms["form"]["prix"];
        var quantite = document.forms["form"]["quantite"];

        if (nom.value == "") {
            $('#nom').show();
            nom.focus();
            $bool = false;
        } else {
            $('#nom').hide();
        }

        if (desc.value == "") {
            $('#desc').show();
            desc.focus();
            $bool = false;
        } else {
            $('#desc').hide();
        }

        if (prix.value == "") {
            $('#prix').show();
            $('#prixNot').hide();
            prix.focus();
            $bool = false;
        }else if(isNumeric(prix.value)==false) {
            $('#prix').hide();
            $('#prixNot').show();
            prix.focus();
            $bool = false;
        }
        else {
            $('#prix').hide();
            $('#prixNot').hide();
        }

        if (quantite.value == "") {
            $('#quantite').show();
            $('#quantiteNot').hide();
            quantite.focus();
            $bool = false;
        } else   if (isNumeric(quantite.value)==false){
            $('#quantite').hide();
            $('#quantiteNot').show();
            quantite.focus();
            $bool = false;
        }else {
            $('#quantite').hide();
            $('#quantiteNot').hide();
        }

        if ($bool) {
            $(this).unbind(e);
        } else {
            e.preventDefault();
        }
    })



})