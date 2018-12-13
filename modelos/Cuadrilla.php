<?php

require "../config/Conexion.php";

Class Cuadrilla{

    public function __construct()
    {
        
    }

    public function insertar($nombre_cuadrilla){
        $sql = "INSERT INTO cuadrilla (nombre_cuadrilla)
                VALUES ('$nombre_cuadrilla')";
        return ejecutarConsulta($sql);
    }

    public function listar(){
        $sql = "SELECT * FROM cuadrilla";
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

}


?>