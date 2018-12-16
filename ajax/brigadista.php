<?php 
require_once "../modelos/Brigadista.php";

$brigadista=new Brigadista();

$id_cuadrilla=isset($_POST["id_cuadrilla"])? limpiarCadena($_POST["id_cuadrilla"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$rut=isset($_POST["rut"])? limpiarCadena($_POST["rut"]):"";
$apellido=isset($_POST["apellido"])? limpiarCadena($_POST["apellido"]):"";

switch ($_GET["op"]){
	case 'guardar':
			$rspta=$brigadista->insertar($rut,$id_cuadrilla,$nombre,$apellido);
			echo $rspta ? "Brigadista registrado" : "Brigadista no se pudo registrar";
	break;

	case 'editar':
			$rspta=$brigadista->editar($rut,$id_cuadrilla);
			echo $rspta ? "Brigadista asignado a su cuadrilla" : "Brigadista no se pudo asignar";
	break;

	case 'mostrar':
		$rspta=$brigadista->mostrar($rut);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listar':
		$rspta=$brigadista->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
                 "0"=>'<button class="btn btn-warning" onclick="mostrar('.$reg->rut.')"><i class="fa fa-pencil-alt"></i></button>',
				 "1"=>$reg->rut,
				 "2"=>$reg->id_cuadrilla,
                 "3"=>$reg->nombre,
                 "4"=>$reg->apellido
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

    break;
    
    case 'selectCuadrilla':
            require_once "../modelos/Cuadrilla.php";
            $cuadrilla = new Cuadrilla();

            $rspta = $cuadrilla->select();
 
            while ($reg = $rspta->fetch_object()){
                    echo '<option value=' . $reg->id_cuadrilla . '>' . $reg->nombre_cuadrilla . '</option>';
            }

    break;
}
?>