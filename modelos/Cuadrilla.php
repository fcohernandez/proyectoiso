<?php

require "../config/Conexion.php";

Class Cuadrilla{

    public function __construct()
    {
        
    }

    public function insertar($nombre_cuadrilla){
        $sql = "INSERT INTO cuadrilla (nombre_cuadrilla, estado)
                VALUES ('$nombre_cuadrilla', '1')";
        return ejecutarConsulta($sql);
    }

    public function listar(){
        $sql = "SELECT * FROM cuadrilla";
        return ejecutarConsulta($sql);
    }

    public function select(){
        $sql = "SELECT id_cuadrilla,nombre_cuadrilla FROM cuadrilla WHERE estado=1";
        return ejecutarConsulta($sql);
    }

    public function editar($id_cuadrilla,$nombre_cuadrilla)
	{
		$sql="UPDATE cuadrilla SET nombre_cuadrilla='$nombre_cuadrilla' WHERE id_cuadrilla='$id_cuadrilla'";
		return ejecutarConsulta($sql);
    }
    
    //Implementar un método para mostrar los datos de un registro a modificar
    public function mostrar($id_cuadrilla)
    {
        $sql="SELECT * FROM cuadrilla WHERE id_cuadrilla='$id_cuadrilla'";
        return ejecutarConsultaSimpleFila($sql);
    }

    public function desactivar($id_cuadrilla){
        $sql="UPDATE cuadrilla SET estado='0' WHERE id_cuadrilla='$id_cuadrilla'";
		return ejecutarConsulta($sql);
    }

    public function activar($id_cuadrilla){
        $sql="UPDATE cuadrilla SET estado='1' WHERE id_cuadrilla='$id_cuadrilla'";
		return ejecutarConsulta($sql);
    }

}


?>