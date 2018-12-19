<?php 
require_once "../modelos/Brigadista.php";

$brigadista=new Brigadista();

$id_cuadrilla=isset($_POST["id_cuadrilla"])? limpiarCadena($_POST["id_cuadrilla"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$rut=isset($_POST["rut"])? limpiarCadena($_POST["rut"]):"";
$apellido=isset($_POST["apellido"])? limpiarCadena($_POST["apellido"]):"";

switch ($_GET["op"]){
	case 'editar':
			$rspta=$brigadista->editar($rut,$id_cuadrilla);
			echo $rspta ? "Brigadista asignado a su cuadrilla" : "Brigadista no se pudo asignar";
	break;

	case 'mostrar':
		echo $rut;
		$rspta=$brigadista->mostrar($rut);
 		//Codificar el resultado utilizando json
 		
	break;

	case 'listar':
		require_once "../modelos/Cuadrilla.php";
		$cuadrilla = new Cuadrilla();
		$rspta=$brigadista->listar();
		
 		//Vamos a declarar un array
		 $data= Array();
		 $nombreCuadrilla=null;

 		while ($reg=$rspta->fetch_object()){

			//verificamos si la id_cuadrilla no es null
			if(!is_null($reg->id_cuadrilla)){
				$rsptaCuadrilla = $cuadrilla->select();
				while ($regCuadrilla=$rsptaCuadrilla->fetch_object()){//recorremos la tabla cuadrilla hasta que los ID coincidan
					if($regCuadrilla->id_cuadrilla == $reg->id_cuadrilla){
						$nombreCuadrilla = $regCuadrilla->nombre_cuadrilla;
						break;
					}
				}
			}

 			$data[]=array(
                 "0"=>'<button class="btn btn-warning" onclick="mostrar('.$reg->rut.')"><i class="fa fa-pencil-alt"></i></button>',
				 "1"=>$reg->rut,
				 "2"=>(is_null($nombreCuadrilla))?'<span class="btn-warning">Cuadrilla sin Asignar</span>':
				 '<span class="label bg-red">'.$nombreCuadrilla.'</span>', //mostramos el nombre de la cuadrilla
                 "3"=>$reg->nombre,
                 "4"=>$reg->apellido
				 );
				 
				 $nombreCuadrilla=null;
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