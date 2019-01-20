<?php
//session_start(); 
require_once "../modelos/Usuario.php";
 
$usuario=new Usuario();
 
$id_usuario=isset($_POST["id_usuario"])? limpiarCadena($_POST["id_usuario"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$apellido=isset($_POST["apellido"])? limpiarCadena($_POST["apellido"]):"";
$login=isset($_POST["login"])? limpiarCadena($_POST["login"]):"";
$clave=isset($_POST["clave"])? limpiarCadena($_POST["clave"]):"";
$rut=isset($_POST["rut"])? limpiarCadena($_POST["rut"]):"";
$permisos=isset($_POST['permisos']) ? $_POST['permisos']:[];
 
switch ($_GET["op"]){
    case 'guardaryeditar':

        //Hash SHA256 en la contraseña
        $clavehash=hash("SHA256",$clave,false);
 
        if (empty($id_usuario)){
            $rspta=$usuario->insertar($rut,$nombre,$apellido,$login,$clavehash,$permisos);
            echo $rspta ? "Usuario registrado" : "No se pudieron registrar todos los datos del usuario";
        }
        else {
            $rspta=$usuario->editar($id_usuario,$rut,$nombre,$apellido,$login,$clavehash,$permisos);
            echo $rspta ? "Usuario actualizado" : "Usuario no se pudo actualizar";
        }
    break;
 
    case 'desactivar':
        $rspta=$usuario->desactivar($id_usuario);
        echo $rspta ? "Usuario Desactivado" : "Usuario no se puede desactivar";
    break;
 
    case 'activar':
        $rspta=$usuario->activar($id_usuario);
        echo $rspta ? "Usuario activado" : "Usuario no se puede activar";
    break;
 
    case 'mostrar':
        $rspta=$usuario->mostrar($id_usuario);
        //Codificar el resultado utilizando json
        echo json_encode($rspta);
    break;
 
    case 'listar':
        $rspta=$usuario->listar();
        //Vamos a declarar un array
        $data= Array();
 
        while ($reg=$rspta->fetch_object()){
            $data[]=array(
                "0"=>($reg->condicion)?'<button class="btn btn-warning" onclick="mostrar('.$reg->id_usuario.')"><i class="fa fa-pencil"></i></button>'.
                    ' <button class="btn btn-danger" onclick="desactivar('.$reg->id_usuario.')"><i class="fa fa-close"></i></button>':
                    '<button class="btn btn-warning" onclick="mostrar('.$reg->id_usuario.')"><i class="fa fa-pencil"></i></button>'.
                    ' <button class="btn btn-primary" onclick="activar('.$reg->id_usuario.')"><i class="fa fa-check"></i></button>',
                    "1"=>$reg->rut,
                    "2"=>$reg->nombre,
                "3"=>$reg->apellido,
                "4"=>$reg->login,
                "5"=>($reg->condicion)?'<span class="label bg-green">Activado</span>':
                '<span class="label bg-red">Desactivado</span>'
                );
        }
        $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);
        echo json_encode($results);
 
    break;

    case 'permisos':
        //Obtenemos todos los permisos de la tabla permisos
        require_once "../modelos/Permiso.php";
        $permiso = new Permiso();
        $rspta = $permiso->listar();

        //Obtener los permisos asignados al usuario
        $id=$_GET['id'];
        $marcados = $usuario->listarmarcados($id);
        //Declaramos el array para almacenar todos los permisos marcados
        $valores=array();

        //Almacenar los permisos asignados al usuario en el array
        while ($per = $marcados->fetch_object())
        {
            array_push($valores, $per->id_permiso);
        }

        //Mostramos la lista de permisos en la vista y si están o no marcados
        while ($reg = $rspta->fetch_object())
                {
                    $sw=in_array($reg->id_permiso,$valores)?'checked':'';
                    echo '<li><input type="checkbox" name="permiso" value="'. $reg->id_permiso .'"' . $sw . ' > ' . $reg->nombre . '</li>';
                }
    break;

}
?>