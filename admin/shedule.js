
jQuery(document).ready(function ($) {


/*click borrar evento*/
    $(document).on('click', "a[data-idshedule]", function () {
        var id = this.dataset.idshedule;
        var url = sAjax.url;
        
        $.ajax({
            type: "POST",
            url: url,
            data: {
                action: "deleteshedule",
                nonce: sAjax.seguridad,
                id: id
            },
            success: function () {
                location.reload();
            }
        });
        
    });

    /*click borrar instructor*/
    $(document).on('click', "a[data-idinstructor]", function () {
        var id = this.dataset.idinstructor;
        var url = sAjax.url;

        $.ajax({
            type: "POST",
            url: url,
            data: {
                action: "deleteinstructor",
                nonce: sAjax.seguridad,
                id: id
            },
            success: function () {
                location.reload();
            }
        });

    });


    /* ALERTA */
    $("#success-alert").fadeTo(2000, 500).slideUp(500, function () {
        $("#success-alert").slideUp(800);
    });
    $("#error-alert").fadeTo(5000, 500).slideUp(500, function () {
        $("#error-alert").slideUp(800);
    });



});
