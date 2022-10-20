<?php

function data_table_dinamic(){

    $config = '
        <script>
        $("#table").DataTable( {
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
            searching: false
        } );
        </script>';

    return $config;

}