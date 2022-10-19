<?php
require_once plugin_dir_path(__FILE__ ) . '../../../settings/enviroment.php';
require_once plugin_dir_path(__FILE__).'../../../includes/tablas/reportes_admin_table.php';
require_once plugin_dir_path(__FILE__).'../../../public/shortcode/vendor/autoload.php';

function reportes_admin(){


tabla_superior_reportes();
tabla_inferior_reportes();





$scrt='
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
        "zeroRecords":    "No se encontraron datos"
        
    },
    searching: false
} );
</script>
    ';


    return $scrt;
}

add_shortcode('reportes_admin', 'reportes_admin');