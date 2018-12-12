var tabla;

function init(){
    mostrarForm(false);
    listar();
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

init();