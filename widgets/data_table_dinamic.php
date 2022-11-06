<?php

function data_table_dinamic(){

    $config = '
        <script>
        $("#table").DataTable( {
            "scrollX": true,
            "responsive": true,
            "sScrollX": "100%",
            "sScrollXInner": "100%",
            "bScrollCollapse": true,
            language: {
                "search": "Buscar: ",
                "info": "Mostrando del _START_ al _END_ de _TOTAL_ datos",
                "paginate": {
                    "first":      "Primera",
                    "last":       "Ultima",
                    "next":       "Siguiente",
                    "previous":   "Anterior"
                },
                "lengthMenu":     "Mostrando _MENU_ datos",
                "emptyTable":     "No hay datos disponibles en la tabla",
                "infoEmpty":      "Mostrando 0 a 0 de 0 entradas",
                "zeroRecords":    "No se encontraron datos"
                
            }, 
            searching: false,
            dom: "Bfrtip",
            buttons: [
               {
                extend: "excel",
                text: "Exportar Excel",
                className: "btn btn-success",
                title: "Reporte Consolidado",
               },
               {
                extend: "copy",
                text: "Copiar",
               },
               {
                extend: "print",
                text: "Imprimir",
               }
            ],
        } );
        </script>';

    return $config;

}