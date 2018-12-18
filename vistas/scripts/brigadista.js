var tabla;

function init(){
    mostrarForm(false);
    listar();
    

    $("#formulario").on("submit",function(e)
	{
        editar(e);
    
    })
    
    $.post("../ajax/brigadista.php?op=selectCuadrilla", function(r){
        $("#id_cuadrilla").html(r);
        $('#id_cuadrilla').selectpicker('refresh');

    });
}

function limpiar(){
    $("#apellido").val("");
    $("#rut").val("");
    $("#nombre").val("");
    $("#id_cuadrilla").val("");
}

function mostrarForm(flag){
    limpiar();

    if(flag){
        $("#listadoregistros").hide();
        $("#formularioregistros").show();
        $("#btnguardar").prop("disabled",false);
        
    }else{
        $("#listadoregistros").show();
        $("#formularioregistros").hide();
        
    }
}



function cancelarForm(){
    limpiar();
    mostrarForm(false);

}

function listar(){
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
                        url: '../ajax/brigadista.php?op=listar',
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

function editar(e){
    e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardar").prop("disabled",false);
    var formData = new FormData($("#formulario")[0]);
    console.log(formData);

	$.ajax({
		url: "../ajax/brigadista.php?op=editar",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,


	    success: function(datos)
	    {        
                        
	          bootbox.alert(datos);	          
	          mostrarForm(false);
              tabla.ajax.reload();
              
              
	    }

	});
	limpiar();
}



function mostrar(rut)
{
    $.post("../ajax/brigadista.php?op=mostrar",{rut : rut}, function(data, status)
    {
        data = JSON.parse(data);     
        mostrarForm(true);
        console.log(data);
        $("#apellido").val(data.apellido);
        $("#nombre").val(data.nombre);
        $("#id_cuadrilla").val(data.id_cuadrilla);
        $("#id_cuadrilla").selectpicker('refresh');
        $("#rut").val(data.rut);
    })
}






init();