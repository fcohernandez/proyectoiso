<?php

require "../config/Conexion.php";

Class Brigadista{

    public function __construct()
    {
        
    }

    public function insertar($rut,$id_cuadrilla,$nombre,$apellido){
        $sql = "INSERT INTO brigadista (rut, id_cuadrilla, nombre, apellido)
                VALUES ('$rut', '$id_cuadrilla','$nombre','$apellido')";
        return ejecutarConsulta($sql);
    }

    public function listar(){
        $sql = "SELECT * FROM brigadista";
        return ejecutarConsulta($sql);
    }

    public function editar($rut,$id_cuadrilla)
	{
		$sql="UPDATE brigadista SET id_cuadrilla='$id_cuadrilla' WHERE brigadista.rut='$rut'";
		return ejecutarConsulta($sql);
    }
    
    //Implementar un método para mostrar los datos de un registro a modificar
    public function mostrar($rut)
    {
        $sql="SELECT * FROM brigadista WHERE rut='$rut'";
        return ejecutarConsultaSimpleFila($sql);
    }

    public function select($id_cuadrilla){
        $sql = "SELECT * FROM brigadista WHERE id_cuadrilla = '$id_cuadrilla'";
        return ejecutarConsulta($sql);
    }
/*
    public function desactivar($id_cuadrilla){
        $sql="UPDATE cuadrilla SET estado='0' WHERE id_cuadrilla='$id_cuadrilla'";
		return ejecutarConsulta($sql);
    }

    public function activar($id_cuadrilla){
        $sql="UPDATE cuadrilla SET estado='1' WHERE id_cuadrilla='$id_cuadrilla'";
		return ejecutarConsulta($sql);
    }
*/
}


?>