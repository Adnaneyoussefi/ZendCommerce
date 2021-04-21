$(document).ready(() => {
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
            prix.focus();
            $bool = false;
        } else {
            $('#prix').hide();
        }

        if (quantite.value == "") {
            $('#quantite').show();
            quantite.focus();
            $bool = false;
        } else {
            $('#quantite').hide();
        }

        if ($bool) {
            $(this).unbind(e);
        } else {
            e.preventDefault();
        }
    })

})