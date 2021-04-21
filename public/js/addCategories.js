$(document).ready(() => {
    $('#formCat').submit((e) => {

        $bool = true;
        var nom = document.forms["formCat"]["nom"];

        if (nom.value == "") {
            $('#catN').show();
            nom.focus();
            $bool = false;
        } else {
            $('#catN').hide();
        }


        if ($bool) {
            $(this).unbind(e);
        } else {
            e.preventDefault();
        }
    })
})