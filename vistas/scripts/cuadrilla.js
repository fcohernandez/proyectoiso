var tabla;

function init(){
    mostrarForm(false);
    listar();

    $("#formulario").on("submit",function(e)
	{
		guardar(e);	
	})
}

function limpiar(){
    $("#id_cuadrilla").val("");
    $("#nombre_cuadrilla").val("");
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

function guardar(e){
    e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardar").prop("disabled",true);
    var formData = new FormData($("#formulario")[0]);


	$.ajax({
		url: "../ajax/cuadrilla.php?op=guardar",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,


	    success: function(datos)
	    {                    
	          alert(datos);	          
	          mostrarForm(false);
              tabla.ajax.reload();
              location.reload(); //recargo pagina pq el boton se bugea del submit
	    }

	});
	limpiar();
}

function editar(e){
    e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardar").prop("disabled",true);
    var formData = new FormData($("#formulario")[0]);


	$.ajax({
		url: "../ajax/cuadrilla.php?op=guardar",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,


	    success: function(datos)
	    {                    
	          alert(datos);	          
	          mostrarForm(false);
              tabla.ajax.reload();
              location.reload(); //recargo pagina pq el boton se bugea del submit
	    }

	});
	limpiar();
}

init();