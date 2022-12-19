
$(document).ready(function () {
    $("#btn_ingresar").click(function(e) {
        e.preventDefault();  

        var data = $("#form_login").serializeArray();
        $.ajax({
            url: 'pages_acc/Index_A.php?accion=POST',
            dataType: 'json',
            type: 'post',
            contentType: 'application/x-www-form-urlencoded',
            data: data,
            beforeSend: function() {
                NProgress.start();
            },
            success: function(data, textStatus, jQxhr){
                NProgress.done();
                if(data.result == 1){
                    location.assign('inicio.php');
                }else{
                    error_input(true, data.id, data.mensaje);
                }
            },
            error: function(jqXhr, textStatus, errorThrown){
                NProgress.done();
                error_input(true, $(jqXhr.responseText).text().trim());
            }
        });
    });
});