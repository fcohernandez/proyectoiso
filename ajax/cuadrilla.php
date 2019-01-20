<?php 
require_once "../modelos/Cuadrilla.php";

$cuadrilla=new Cuadrilla();

$id_cuadrilla=isset($_POST["id_cuadrilla"])? limpiarCadena($_POST["id_cuadrilla"]):"";
$nombre_cuadrilla=isset($_POST["nombre_cuadrilla"])? limpiarCadena($_POST["nombre_cuadrilla"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($id_cuadrilla)){
			
			$comparar = $cuadrilla->select();
			$aviso = false;
			while ($reg=$comparar->fetch_object()){
					if(strcasecmp($reg->nombre_cuadrilla,$nombre_cuadrilla) === 0){
						$aviso = "El nombre de cuadrilla ya se encuentra registrado";
					}

			}
			if($aviso){
				echo $aviso;
			}else{
				$rspta=$cuadrilla->insertar($nombre_cuadrilla);
				echo $rspta ? "Cuadrilla registrada" : "Cuadrilla no se pudo registrar";
			}	
		}
		else {
			$rspta=$cuadrilla->editar($id_cuadrilla,$nombre_cuadrilla);
			echo $rspta ? "Cuadrilla actualizada" : "Cuadrilla no se pudo actualizar";
		}
	break;

	case 'desactivar':
		$rspta=$cuadrilla->desactivar($id_cuadrilla);
 		echo $rspta ? "Cuadrilla Desactivada" : "Cuadrilla no se puede desactivar";
	break;

	case 'activar':
		$rspta=$cuadrilla->activar($id_cuadrilla);
 		echo $rspta ? "Cuadrilla Activada" : "Cuadrilla no se puede activar";
	break;

	case 'mostrar':
		$rspta=$cuadrilla->mostrar($id_cuadrilla);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listar':
		$rspta=$cuadrilla->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
				 "0"=>($reg->estado)?'<button class="btn btn-warning" onclick="mostrar('.$reg->id_cuadrilla.')"><i class="fa fa-pencil-alt"></i></button>' . 
				 ' <button class="btn btn-danger" onclick="desactivar('.$reg->id_cuadrilla.')"><i class="fa fa-window-close"></i></button>' .
				' <button onclick="listarBrigadistas('.$reg->id_cuadrilla.')">Listar</button>':
				 '<button class="btn btn-warning" onclick="mostrar('.$reg->id_cuadrilla.')"><i class="fa fa-pencil-alt"></i></button>' . 
				 ' <button class="btn btn-primary" onclick="activar('.$reg->id_cuadrilla.')"><i class="fa fa-check"></i></button>',
				 "1"=>$reg->nombre_cuadrilla,
				 "2"=>($reg->estado)?'Activa':'Desactivada'
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);
	break;

	case 'listarBrigadistas':
		require_once "../modelos/Brigadista.php";
		$brigadista = new Brigadista();
		$rspta=$brigadista->select($id_cuadrilla);

		$data= Array();

		

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
				 "0"=>$reg->rut,
				 "1"=>$reg->id_cuadrilla,
				 "2"=>$reg->nombre,
				 "3"=>$reg->apellido
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		
 		echo json_encode($results);;
	break;

}
?>

