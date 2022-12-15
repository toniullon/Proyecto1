<?php 
	include("../mysql.php"); //SI INCLUYE EL ACHIVO DE CONECCION
	$db = DataBase::conectar();//CONECCION DE BASE DE DATOS
	$accion = $_REQUEST['accion'];

	switch ($accion){
		case 'POST':
			$name_user = $_POST['name_user'];
			$pass_user = $_POST['pass_user'];
			$salida = array('result' => 0);

			$db->setQuery("SELECT*FROM usuarios WHERE nombre_usuario = '$name_user' AND PASSWORD = MD5('$pass_user')");		
            if(!empty($db->loadObject())){
				$salida = array('result' => 1);
			}

			echo json_encode($salida);
        break;
    }