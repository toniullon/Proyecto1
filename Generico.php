<?php 
	require_once "mysql.php"; //SI INCLUYE EL ACHIVO DE CONECCION

    function separadorMilesDecimales($number){
        if (is_numeric($number)){
            $nro=number_format($number,2, ",", ".");
            return $nro;
        }
    }

     /************************************************************ EJMPLO DE SET RULES VALIDACION ***************************************************************** */
  //-----> autonumeric 												= formatemos a numero de: ejem--> 10.000,55 a ----> 10000.55 (formato mysql). 
  //-----> max_length:el_valor 										= validar cantidad maxima de caracteres. 	----  array('max_length'=>'sms')
  //-----> min_length:el_valor 										= validar cantidad minima de caractere.		----  array('min_length'=>'sms')
  //-----> required 												= para que no deje vacio.					----  array('required'=>'sms')
  //-----> is_unique[tabla.columna.PK] o is_unique[tabla.columna]	= para que buscar una tabla si ya existe el dato. OBS: SE SI COLOCA EL PK DEBE IR EL ID DEL LA CLAVE PRIMARIA PARA NO COMPARAR CONSIGO MISMO ----  array('is_unique'=>'sms')
  //-----> is_natural_no_zero										= debe completar con mayor a cero. 			----  array('is_natural_no_zero'=>'sms')
   //-----> json_decode												= se usa para tratar con array de trablas boostrap y poder utilizar cleartext

  // ejemplo = set_rules('COMO SE LLAMA EL CAMPO','nombre_columna_db','required|is_unique[bancos.ruc]|min_length:10',array('is_unique'=>'Ya existe un registro con este ruc', 'required'=>'Favor ingrese un RUC'));
	/*if(validate_loaded_rules()){ <-------------- esto preguntara si cumple con los set_rules
		Se cumple con los requisitos
	}else{
		No cumple con los requisitos
	}*/
	$errores = array();
    function set_rules($Lavel = '',$content, $content_required = '', $errors = array()){
		$db = DataBase::conectar();
        global $errores;
        $id_campo = $content;
        $content = $db->clearText($_POST[$id_campo]);

		if(in_array("upper", explode("|",$content_required))){
            $content = mb_convert_case($db->clearText($_POST[$id_campo]) , MB_CASE_UPPER, "UTF-8"); //limpiamos y ponemos todo en mayusculas
        }

        if(in_array("autonumeric", explode("|",$content_required) )){
            $content = separadorMilesDecimales($content); //formatemos a numero de: ejem--> 10.000,55 a ----> 10000.55 (formato mysql)
        }

		if(in_array("is_null", explode("|",$content_required) )){
			if(empty($content)) $content = 'null';
        }

		if(in_array("json_decode", explode("|",$content_required) )){//si es que tiene esto es para poder tratarlo como un array
			$datos_clear = array();
            $array = array();
			$array_datos = json_decode($_POST[$id_campo]);
			if(in_array("required", explode("|",$content_required))){
				if(count($array_datos) == 0){
					$errores[] = array("mensaje" => ($errors['required']) ? $errors['required'] : "Error. La tabla no puede estar vacia.", "id" => ($Lavel == '') ? '' : $id_campo);
					return 0;
				}
			}

            foreach ($array_datos as $k=> $v) {
                foreach($v as $k2=> $v2){
                    $nombre_asociacion = $k2;
                    $valor_asociacion  = $v2;
                    $array[$nombre_asociacion] = $db->clearText($valor_asociacion);
                }
                $datos_clear[]= (object) $array;
            }

			return $datos_clear;
        }

        $detener = 0;
		foreach(explode("|",$content_required) as $requeridos){
        
            if(explode(" ",str_replace(array("[","]"), " ", $requeridos))[0] == 'is_unique'){
                $variab     = explode("-",str_replace(array("[","]"), "-", $requeridos))[1];
                $requeridos = explode("-",str_replace(array("[","]"), "-", $requeridos))[0];
            }
            if(explode(":",$requeridos)[0] == 'max_length' || explode(":",$requeridos)[0] == 'min_length'){
                $variab     = $requeridos;
                $requeridos = explode(":",$requeridos)[0];
            }
			if(explode(" ",str_replace(array("[","]"), " ", $requeridos))[0] == 'formater'){
                $variab     = preg_replace('/[^0-9]/', '', $content).'-'.preg_replace('/[^0-9]/', '', explode(" ",str_replace(array("[","]"), " ", $requeridos))[1]);
                $requeridos = explode(" ",str_replace(array("[","]"), " ", $requeridos))[0];
            }
            
           $detener = ($requeridos == 'required') ? required_field($Lavel,$id_campo,$content,$errors['required'], 'required') :0;                                 
           //  para que no deje vacio
           if($detener == -1){
                break;
           }
           $detener = ($requeridos == 'is_unique') ? is_unique($Lavel,$content, $variab, $errors['is_unique'], $id_campo) :0;                                     
           //  para que busque una tabla si ya existe el dato
           if($detener == -1){
                break;
           }
           $detener = ($requeridos == 'is_natural_no_zero') ? required_field($Lavel,$id_campo,$content,$errors['is_natural_no_zero'], 'is_natural_no_zero') :0;   
           //  debe completar con mayor a cero
           if($detener == -1){
                break;
           }
           $detener = ($requeridos == 'max_length') ? required_field($Lavel,$id_campo,$content,$errors['max_length'], $variab) :0;                                
           //  validar cantidad maxima de caracteres
           if($detener == -1){
                break;
           }
           $detener = ($requeridos == 'min_length') ? required_field($Lavel,$id_campo,$content,$errors['min_length'], $variab) :0;                                
           //  validar cantidad minima de caracteres
           if($detener == -1){
                break;
           }

		   $detener = ($requeridos == 'is_number_not_zero') ? required_field($Lavel,$id_campo,$content,$errors['is_number_not_zero'], 'is_number_not_zero') :0;                                
           //  validar cantidad minima de caracteres
           if($detener == -1){
                break;
           }

		   $detener = ($requeridos == 'formater') ? required_field($Lavel,$id_campo,$variab,$errors['formater'], 'formater') :0;                                 
           //  para que no deje vacio
           if($detener == -1){
                break;
           }
		}
		return $content;
	}
	

	function is_unique($cam,$str, $field, $sms = "", $id_campo){
		$db = DataBase::conectar();
        global $errores;
		
		sscanf($field, '%[^.].%[^.].%[^.].%[^.]', $table, $field, $PK, $extra_wr);
		$where_pk = "";

		
		if($PK != ''){
			if(preg_match("/not_pk_/i", $PK)){ //se puede poner varios where simples
				$PK = str_replace("not_pk_", "", $PK);
				$where_pk .= " AND $PK";
			}else{ //esto es una comprobacion basica sin where
				$ID 			= $db->clearText($_POST[$PK]);
				$db_name 		= DataBase::DB_NAME;
				$db->setQuery("SELECT COLUMN_NAME, COLUMN_KEY FROM INFORMATION_SCHEMA.COLUMNS  WHERE TABLE_SCHEMA = '$db_name' AND TABLE_NAME = '$table' AND COLUMN_KEY IN('PRI', 'UNI')");
				$NAME_PK 		= $db->loadObject()->COLUMN_NAME;
				$where_pk 		.= " AND $NAME_PK != '$ID' ";
			}
		}
		if($extra_wr != ''){
			if(preg_match("/not_pk_/i", $extra_wr)){ //se puede poner varios where simples
				$extra_wr = str_replace("not_pk_", "", $extra_wr);
				$where_pk .= " AND $extra_wr";
			}
		}

		$db->setQuery("SELECT*FROM $table WHERE $field = '$str' $where_pk ");
		if(!empty($db->loadObject())){
            $errores[] = array("mensaje" => ($sms) ? $sms : "Error. Dato en el campo $cam ya existe", "id" => ($cam == '') ? '' : $id_campo);
            return -1;
		}
		
		return isset($db) ? ( (!empty($db->loadObject()) ) ? 1 : $str ) : FALSE;
	}

    function required_field($Lavel,$id_campo,$content, $sms = "", $tipo = ''){
        global $errores;
        $sms_defual_no_zero 			= "El campo $Lavel no puede ser cero.";
        $sms_defual_required 			= "El campo $Lavel es obligatorio.";
		$sms_defual_is_number_not_zero 	= "El campo $Lavel debe ser numerico.";
        $sms_defual_max_length 			= "Caracteres maximo: ".explode(":",$tipo)[1];
        $sms_defual_min_length 			= "Caracteres minimo: ".explode(":",$tipo)[1];
		$sms_defual_formater 			= "Formato $Lavel invalida.";

        $valid_sms = $tipo == 'required' ? ( ($content != '' or !empty($content) )  ? '' : (($sms) ? $sms : $sms_defual_required) ) : '' ;	
        if($valid_sms != ''){
            $errores[] = array("mensaje" => "Error. $valid_sms" ,"id" => ($Lavel == '') ? '' : $id_campo);
            return -1;
        }

        $valid_sms = $tipo == 'is_natural_no_zero' ? ($content > 0 ? '' : (($sms) ? $sms : $sms_defual_no_zero) ) : '' ;
        if($valid_sms != ''){
           $errores[] = array("mensaje" => "Error. $valid_sms" ,"id" => ($Lavel == '') ? '' : $id_campo);
           return -1;
        }

		$valid_sms = $tipo == 'is_number_not_zero' ? (is_numeric($content) && $content != 0 ? '' : (($sms) ? $sms : $sms_defual_is_number_not_zero) ) : '' ;
        if($valid_sms != ''){
           $errores[] = array("mensaje" => "Error. $valid_sms" ,"id" => ($Lavel == '') ? '' : $id_campo);
           return -1;
        }

        $valid_sms = explode(":",$tipo)[0] == 'max_length' ? (strlen($content) < explode(":",$tipo)[1] ? '' : (($sms) ? $sms : $sms_defual_max_length) ) : '' ;
        if($valid_sms != ''){
           $errores[] = array("mensaje" => "Error. $valid_sms" ,"id" => ($Lavel == '') ? '' : $id_campo);
           return -1;
        }

        $valid_sms = explode(":",$tipo)[0] == 'min_length' ? (strlen($content) >= explode(":",$tipo)[1] ? '' : (($sms) ? $sms : $sms_defual_min_length) ) : '' ;
        if($valid_sms != ''){
            $errores[] = array("mensaje" => "Error. $valid_sms" ,"id" => ($Lavel == '') ? '' : $id_campo);
            return -1;
        }

		$valid_sms = $tipo == 'formater' ? ( (strlen(explode("-",$content)[0]) == strlen(explode("-",$content)[1]))  ? '' : (($sms) ? $sms : $sms_defual_formater) ) : '' ;	
        if($valid_sms != ''){
            $errores[] = array("mensaje" => "Error. $valid_sms" ,"id" => ($Lavel == '') ? '' : $id_campo);
            return -1;
        }

        return $content;
    }

    function validate_loaded_rules(){
        global $errores;
        if(count($errores) > 0){
            echo json_encode(["status" => "error", "mensaje" => "Error. ".count($errores)." validaciones encontradas", "id" => $errores]);
            $errores = array();
            exit;
        }
        $errores = array();
        return true;
    }