<?php

require "../config/Conexion.php";

Class Cuadrilla{

    public function __construct()
    {
        
    }

    public function insertar($id_cuadrilla,$nombre_cuadrilla){
        $sql = "INSERT INTO cuadrilla (id_cuadrilla,nombre_cuadrilla)
                VALUES ('$id_cuadrilla','$nombre_cuadrilla')";
        return ejecutarConsulta($sql);
    }

    public function listar(){
        $sql = "SELECT * FROM cuadrilla";
        return ejecutarConsulta($sql);
    }

}


?>