
    $(document).ready(function() {
        $(".submenu_str,.nav-link").click(function() {
            var seleccion = $(this);
            var menu_text = $(seleccion).text();
            var menu_content = $(seleccion).closest('.contenedor_menu_str').find('.text_contenedor_menu_str');
            var padre_text = $(menu_content).text().trim();
            //LE PONEMOS ACTIVO
            if($(seleccion).find('.menu_str').closest('.contenedor_menu_str').length > 0 || $(seleccion).find('.menu_str').closest('.un_menu').length > 0){
                $(".nav-link.activo").removeClass('activo');
                $(seleccion).addClass('activo');
                $("#titulo_menu_content").html(menu_text.trim());
                localStorage.setItem("menu-activo", padre_text.trim()+'->'+menu_text.trim());
            }

            
        });

        var menu_activa = localStorage.getItem("menu-activo");//PARA BUSCAR EL MENU EN QUE ESTA
        
        var menus = $(".menu_str");
        for (let i = 0; i < menus.length; i++) {
            var seleccion = $(menus[i]);
            var menu_text = $(seleccion).text();
            var menu_content = $(seleccion).closest('.contenedor_menu_str').find('.text_contenedor_menu_str');
            var padre_text = $(menu_content).text().trim();
            var menu_url = padre_text.trim()+'->'+menu_text.trim();
            
            if(menu_activa == menu_url){
                setTimeout(() => {
                    $("#titulo_menu_content").html(menu_text.trim());
                    if(!padre_text.trim()){
                        $("#ubi_menu").html('<li class="breadcrumb-item active">'+menu_text.trim()+'</li>');
                    }else{
                        $("#ubi_menu").html('<li class="breadcrumb-item">'+padre_text.trim()+'</li><li class="breadcrumb-item active">'+menu_text.trim()+'</li>');
                    }
                    
                    $(seleccion).closest('.contenedor_menu_str').find('.text_contenedor_menu_str').click();
                    $(seleccion).closest('.nav-link').addClass('activo');
                }, 500);
                break;
            }
            
        }
    });
/*error para mostrar mensaje en letras rojas bajo los input los requeridos */
function error_input(error = true, id = '', sms = 'Complete el campo', tab = false){
    if(!Array.isArray(id)){
        var id = [{id:id, mensaje:sms}];
    }
    var primer_error    = id[0].id;
    var id_repetido     = ''; //esto es si tiene mas de una validacion y se muestre el primes mensaje de validacion y no el ultimo
    id.forEach(m => {
        id  = m.id;
        sms = m.mensaje;
        if(id != id_repetido){
            id_repetido = id;
            if(id != ''){ // la validacion solo anda si tiene #id
                sms = sms.replace('error. ', "").replace('Error. ', "");
                if(error){
                    if($("span[aria-labelledby='select2-"+id+"-container']").length > 0){ //en caso de ser select2 la classe se agrega a otra etiqueta
                        $("span[aria-labelledby='select2-"+id+"-container']").addClass('valid_form');

                    }else if($("#"+id+"").closest('.form-group').find(".input-group").length > 0){ //esto es en caso de que use el input group la classe se agrega a otra etiqueta
                        $("#"+id+"").closest('.form-group').find(".input-group").addClass('valid_form');
                        
                    }else if($("#"+id+"").closest('.form-group').find(".custom-file").length > 0){ //esto es en caso de que use el input tipe file la classe se agrega a otra etiqueta
                        $("#"+id+"").closest('.form-group').find(".custom-file label").addClass('valid_form');
                        
                    }else{ //esto es solo para el input normal
                        $("#"+id+"").addClass('valid_form');

                    }

                    $("#"+id+"").closest('.form-group').find("div.error_input").html(''+sms+'');
                    $("#"+id+"").closest('.form-group').find("label").addClass('label_error');
                }else if(error ==  false){
                    if($("#"+id+"").closest('.form-group').find(".custom-file").length > 0){ //esto es en caso de que use el input tipe file la classe se remueve a otra etiqueta
                        $("#"+id+"").closest('.form-group').find(".valid_form").removeClass('valid_form');
                        $("#"+id+"").closest('.form-group').find("div.error_input").html(''); 
                        $("#"+id+"").closest('.form-group').find("label").removeClass('label_error');

                    }else if($("#"+id+"").closest('.form-group').find(".input-group").length > 0){ //esto es en caso de que use el input group la classe se agrega a otra etiqueta
                        $("#"+id+"").closest('.form-group').find(".input-group").removeClass('valid_form');
                        $("#"+id+"").closest('.form-group').find("div.error_input").html('');
                        $("#"+id+"").closest('.form-group').find("label").removeClass('label_error');
                        
                    }else{
                        $("#"+id+"").removeClass('valid_form');
                        $("#"+id+"").closest('.form-group').find("div.error_input").html('');
                        $("#"+id+"").closest('.form-group').find("label").removeClass('label_error');
                    }
                }
            }else{
                $.toast({ heading: 'Sucedió un error en la operación.', text: sms, position: 'top-center', loaderBg:'#008c69', icon: 'error', hideAfter: '3000' });
            }
        }else if(error == false){ //si es falso se toma como limpiar todos los errores
            $(".valid_form").removeClass('valid_form');
            $(".label_error").removeClass('label_error');
            $("div.error_input").html('');
        }else if(id == '' && sms != ''){
            $.toast({ heading: 'Sucedió un error en la operación.', text: sms, position: 'top-center', loaderBg:'#008c69', icon: 'error', hideAfter: '3000' });
        }

    });

    $(".valid_form").keyup(function() {
        $(this).removeClass('valid_form');
        $(this).closest('.form-group').find("div.error_input").html('');
        $(this).closest('.form-group').find("label").removeClass('label_error');
    });

    $("input[type=date].valid_form").on('change', function() {
        $(this).removeClass('valid_form');
        $(this).closest('.form-group').find("div.error_input").html('');
        $(this).closest('.form-group').find("label").removeClass('label_error');
    });

    //en caso de trabajar con varias pestañas en un menu este edentifica el primer error,
    //y autodirigue a la pestaña en caso de poner #tab == true (se pregunta por ahy caso que no es necesario)
    if(primer_error != ''){
        $("#"+primer_error+"").focus();
    }
    setTimeout(() => {
        if(primer_error != '' && tab == true){
            $("#"+primer_error+"").focus();
            tab_padre = $("#"+primer_error+"").closest('.tab-pane.fade').attr("id");
            $(".nav-link[data-target='#"+tab_padre+"']").click();
        }
    }, 500);
}