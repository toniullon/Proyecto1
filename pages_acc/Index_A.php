<?php 
	include("../mysql.php"); //SI INCLUYE EL ACHIVO DE CONECCION
	include("../Generico.php"); //SI INCLUYE EL ACHIVO DE CONECCION
	$db = DataBase::conectar();//CONECCION DE BASE DE DATOS
	$accion = $_GET['accion'];

	switch ($accion){
		case 'POST':
			$name_user = set_rules('name_user','name_user','required');
			$pass_user = set_rules('pass_user','pass_user','required');
			$salida = array('result' => 0);

			if (validate_loaded_rules()) {
				$db->setQuery("SELECT
								CASE 
									WHEN PASSWORD != MD5('$pass_user') AND nombre_usuario != '$name_user' THEN 1 -- 'El usuario no existe.'
									WHEN PASSWORD != MD5('$pass_user') AND nombre_usuario = '$name_user' THEN 2 -- 'La contraseña no coincide.'
									WHEN nombre_usuario != 'admin' AND PASSWORD = MD5('$pass_user') THEN 3 -- 'El usuario es incorrecto.'
								ELSE 4 -- 'Error desconocido' 
									END AS validacion
							FROM usuarios");
				$row_valid = $db->loadObject();
				if($row_valid->validacion == 1){
					echo json_encode(["status" => "error", "mensaje" => "Error. El usuario no existe.", "id" => "name_user"]);
					exit;
				}else if($row_valid->validacion == 2){
					echo json_encode(["status" => "error", "mensaje" => "Error. La contraseña no coincide.", "id" => "pass_user"]);
					exit;
				}else if($row_valid->validacion == 3){
					echo json_encode(["status" => "error", "mensaje" => "Error. El usuario es incorrecto.", "id" => "name_user"]);
					exit;
				}

				$db->setQuery("SELECT*FROM usuarios WHERE nombre_usuario = '$name_user' AND PASSWORD = MD5('$pass_user')");		
				if(!empty($db->loadObject())){
					$salida = array('result' => 1);
				}
	
				echo json_encode($salida);
			}
			
        break;
    }