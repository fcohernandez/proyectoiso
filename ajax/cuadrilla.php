<?php 
require_once "../modelos/Cuadrilla.php";

$cuadrilla=new Cuadrilla();

$id_cuadrilla=isset($_POST["id_cuadrilla"])? limpiarCadena($_POST["id_cuadrilla"]):"";
$nombre_cuadrilla=isset($_POST["nombre_cuadrilla"])? limpiarCadena($_POST["nombre_cuadrilla"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($id_cuadrilla)){
			$rspta=$cuadrilla->insertar($nombre_cuadrilla);
			echo $rspta ? "Categoría registrada" : "Categoría no se pudo registrar";
		}
		else {
			$rspta=$cuadrilla->editar($id_cuadrilla,$nombre_cuadrilla);
			echo $rspta ? "Categoría actualizada" : "Categoría no se pudo actualizar";
		}
	break;

	case 'editar':
			$rspta=$cuadrilla->editar($id_cuadrilla,$nombre_cuadrilla);
			echo $rspta ? "Categoría registrada" : "Categoría no se pudo registrar";
	break;

	case 'desactivar':
		$rspta=$cuadrilla->desactivar($id_cuadrilla);
 		echo $rspta ? "Categoría Desactivada" : "Categoría no se puede desactivar";
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
 				"0"=>'<button class="btn btn-warning" onclick="mostrar('.$reg->id_cuadrilla.')"><i class="fa fa-pencil"></i></button>',
 				"1"=>$reg->nombre_cuadrilla,
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;
}
?>