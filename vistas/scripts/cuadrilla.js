var tabla;
var tabla1 = 'asd';

function init(){
    mostrarForm(false);
    listar();

    $("#formulario").on("submit",function(e)
	{
        guardaryeditar(e);
	})
}

function limpiar(){
    
    $("#nombre_cuadrilla").val("");
    $("#id_cuadrilla").val("");
}

function mostrarForm(flag){
    limpiar();

    if(flag){
        $("#listadoregistros").hide();
        $("#formularioregistros").show();
        $("#btnguardar").prop("disabled",false);
        $("#btnagregar").hide();
    }else{
        $("#listadoregistros").show();
        $("#formularioregistros").hide();
        $("#btnagregar").show();
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
                        url: '../ajax/cuadrilla.php?op=listar',
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



function guardaryeditar(e){
    e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardar").prop("disabled",false);
    var formData = new FormData($("#formulario")[0]);


	$.ajax({
		url: "../ajax/cuadrilla.php?op=guardaryeditar",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,


	    success: function(datos)
	    {                    
	          bootbox.alert(datos);	          
	          mostrarForm(false);
              tabla.ajax.reload();
              //location.reload(); //recargo pagina pq el boton se bugea del submit
	    }

	});
	limpiar();
}


function mostrar(id_cuadrilla)
{
    $.post("../ajax/cuadrilla.php?op=mostrar",{id_cuadrilla : id_cuadrilla}, function(data, status)
    {
        data = JSON.parse(data);        
        mostrarForm(true);
        console.log(data);

        $("#nombre_cuadrilla").val(data.nombre_cuadrilla);
        $("#id_cuadrilla").val(data.id_cuadrilla);
 
    })
}



function desactivar(id_cuadrilla){

    bootbox.confirm("¿Está Seguro de desactivar la Cuadrilla?", function(result){
        if(result)
        {
            $.post("../ajax/cuadrilla.php?op=desactivar", {id_cuadrilla : id_cuadrilla}, function(e){
                bootbox.alert(e);
                tabla.ajax.reload();
            }); 
        }
    })

}

function activar(id_cuadrilla){

    bootbox.confirm("¿Está Seguro de activar la Cuadrilla?", function(result){
        if(result)
        {
            $.post("../ajax/cuadrilla.php?op=activar", {id_cuadrilla : id_cuadrilla}, function(e){
                bootbox.alert(e);
                tabla.ajax.reload();
            }); 
        }
    })

}

function listarBrigadistas(id_cuadrilla)
{
    
    
            $.post("../ajax/cuadrilla.php?op=listarBrigadistas", {id_cuadrilla : id_cuadrilla}, function(data){

                data = JSON.parse(data);
                if(data.aaData.length == 0){
                    bootbox.alert("No existen brigadistas en la cuadrilla seleccionada");
                }
                
                console.log(data.aaData);
                

                    tabla1= $('#tbllistadobrigadistas').DataTable( {
                        "aProcessing": true,//Activamos el procesamiento del datatables
                        "aServerSide": true,//Paginación y filtrado realizados por el servidor
                        dom: 'Bfrtip',//Definimos los elementos del control de tabla
                        buttons: [		          
                            'copyHtml5',
                            'excelHtml5',
                            'csvHtml5',
                            'pdf'
                        ],
                        data: data.aaData,
                        destroy: true,
                    } );
                    
                    //ajax.tabla1.destroy();
            }); 
        

}

init();