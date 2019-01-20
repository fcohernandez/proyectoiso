<?php

require "../config/Conexion.php";

Class Usuario{

    public function __construct()
    {
        
    }

    public function insertar($rut,$nombre,$apellido,$login,$clave,$permisos){
        $sql = "INSERT INTO usuario (rut,nombre, apellido,login, clave, `condicion`)
                VALUES ('$rut','$nombre','$apellido','$login','$clave', '1')";
        //return ejecutarConsulta($sql);
        $idusuarionew = ejecutarConsulta_retornarID($sql);

        $num_elementos = 0;

        $sw = true;

        if(empty($permisos)){
            $permisos = [];
        }

        while($num_elementos < count($permisos)){
            $sql_detalle = "INSERT INTO usuario_permiso(id_usuario,id_permiso) VALUES('$idusuarionew', '$permisos[$num_elementos]')";

            ejecutarConsulta($sql_detalle) or $sw = false;

            $num_elementos++;
        }

        return $sw;

    }

    public function listar(){
        $sql = "SELECT * FROM usuario";
        return ejecutarConsulta($sql);
    }

    public function editar($id_usuario,$rut,$nombre,$apellido,$login,$clave,$permisos)
	{
		$sql="UPDATE usuario SET rut='$rut' ,nombre='$nombre' ,apellido='$apellido', login='$login' ,clave='$clave' WHERE id_usuario='$id_usuario'";
        ejecutarConsulta($sql);
        
        //Eliminamos todos los permisos asignados para volverlos a registrar
        $sqldel="DELETE FROM usuario_permiso WHERE id_usuario='$id_usuario'";
        ejecutarConsulta($sqldel);
 
        $num_elementos=0;
        $sw=true;
 
        while ($num_elementos < count($permisos))
        {
            $sql_detalle = "INSERT INTO usuario_permiso(id_usuario, id_permiso) VALUES('$id_usuario', '$permisos[$num_elementos]')";
            ejecutarConsulta($sql_detalle) or $sw = false;
            $num_elementos=$num_elementos + 1;
        }
 
        return $sw;
    }
    
    //Implementar un método para mostrar los datos de un registro a modificar
    public function mostrar($id_usuario)
    {
        $sql="SELECT * FROM usuario WHERE id_usuario='$id_usuario'";
        return ejecutarConsultaSimpleFila($sql);
    }

    public function desactivar($id_usuario){
        $sql="UPDATE usuario SET condicion='0' WHERE id_usuario='$id_usuario'";
		return ejecutarConsulta($sql);
    }

    public function activar($id_usuario){
        $sql="UPDATE usuario SET condicion='1' WHERE id_usuario='$id_usuario'";
		return ejecutarConsulta($sql);
    }

       //Implementar un método para listar los permisos marcados
       public function listarmarcados($id_usuario)
       {
           $sql="SELECT * FROM usuario_permiso WHERE id_usuario='$id_usuario'";
           return ejecutarConsulta($sql);
       }

       public function verificar($login,$clave){
        $sql="SELECT id_usuario,rut,nombre,apellido,login FROM usuario WHERE login='$login' AND clave='$clave' AND condicion='1'"; 
        return ejecutarConsulta($sql); 
       }

}


?>