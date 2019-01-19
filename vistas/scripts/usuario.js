var tabla;
 
//Función que se ejecuta al inicio
function init(){
    mostrarform(false);
    listar();
 
    $("#formulario").on("submit",function(e)
    {
        guardaryeditar(e);  
    })

    $.post("../ajax/usuario.php?op=permisos&id=",function(r){
        $("#permisos").html(r);
    });
 
}
 
//Función limpiar
function limpiar()
{
    $("#nombre").val("");
    $("#apellido").val("");
    $("#login").val("");
    $("#clave").val("");
    $("#id_usuario").val("");
    $("#rut").val("");
}
 
//Función mostrar formulario
function mostrarform(flag)
{
    limpiar();
    if (flag)
    {
        $("#listadoregistros").hide();
        $("#formularioregistros").show();
        $("#btnGuardar").prop("disabled",false);
        $("#btnagregar").hide();
    }
    else
    {
        $("#listadoregistros").show();
        $("#formularioregistros").hide();
        $("#btnagregar").show();
    }
}
 
//Función cancelarform
function cancelarform()
{
    limpiar();
    mostrarform(false);
    
    
}
 
//Función Listar
function listar()
{
    tabla=$('#tbllistado').dataTable(
    {
        "aProcessing": true,//Activamos el procesamiento del datatables
        "aServerSide": true,//Paginación y filtrado realizados por el servidor
        dom: 'Bfrtip',//Definimos los elementos del control de tabla
        buttons: [                
                    'copyHtml5',
                    'excelHtml5',
                    'csvHtml5',
                    'pdf'
                ],
        "ajax":
                {
                    url: '../ajax/usuario.php?op=listar',
                    type : "get",
                    dataType : "json",                      
                    error: function(e){
                        console.log(e.responseText);    
                    }
                },
        "bDestroy": true,
        "iDisplayLength": 5,//Paginación
        "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
    }).DataTable();
}
//Función para guardar o editar
 
function guardaryeditar(e)
{
    e.preventDefault(); //No se activará la acción predeterminada del evento
    $("#btnGuardar").prop("disabled",true);
    var formData = new FormData($("#formulario")[0]);
 
    $.ajax({
        url: "../ajax/usuario.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
 
        success: function(datos)
        {                    
              bootbox.alert(datos);           
              mostrarform(false);
              tabla.ajax.reload();
        }
 
    });
    limpiar();
}
 
function mostrar(id_usuario)
{
    $.post("../ajax/usuario.php?op=mostrar",{id_usuario : id_usuario}, function(data, status)
    {
        data = JSON.parse(data);    
        console.log(data);    
        mostrarform(true);
 
        $("#nombre").val(data.nombre);
        $("#apellido").val(data.apellido);
        $("#login").val(data.login);
        $("#clave").val(data.clave);
        $("#id_usuario").val(data.id_usuario);
        $("#rut").val(data.rut);
 
    });

    $.post("../ajax/usuario.php?op=permisos&id="+id_usuario,function(r){
        $("#permisos").html(r);
        console.log(id_usuario);
    });
}
 
//Función para desactivar registros
function desactivar(id_usuario)
{
    bootbox.confirm("¿Está Seguro de desactivar el usuario?", function(result){
        if(result)
        {
            $.post("../ajax/usuario.php?op=desactivar", {id_usuario : id_usuario}, function(e){
                bootbox.alert(e);
                tabla.ajax.reload();
            }); 
        }
    })
}
 
//Función para activar registros
function activar(id_usuario)
{
    bootbox.confirm("¿Está Seguro de activar el Usuario?", function(result){
        if(result)
        {
            $.post("../ajax/usuario.php?op=activar", {id_usuario : id_usuario}, function(e){
                bootbox.alert(e);
                tabla.ajax.reload();
            }); 
        }
    })
}
 
init();