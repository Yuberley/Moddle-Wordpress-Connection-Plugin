<?php
include 'colaboradores_admin_table.php';
//require_once plugin_dir_path(__FILE__).'../../includes/tablas/colaboradores_admin_table.php';
require __DIR__ . '/vendor/autoload.php';
use Automattic\WooCommerce\Client;

function colaboradores_admin(){ 
    
    // //peticion
    // $peticion = file_get_contents('https://prime-academy.co//wp-json/wc/v3/orders?consumer_key=ck_41d83ad941a30994f2c42caf2670f801936970db&consumer_secret=cs_7b2fc5f941af4884f9e4e4c08c32348c638aed3d');
    // $ordenes =  json_decode($peticion);  
    
    $woocommerce = new Client(
        'http://localhost/primedigital/', 
        'ck_5358437b6f9045461c6fa103fe2706d55b9b2e50', 
        'cs_3d57e0bce1ddb74ec0e6baf7b7a827a050ee223f',
        [
            'wp_api' => true,
            'version' => 'wc/v3',
            'query_string_auth' => true
            ]
        );
        $ordenes = $woocommerce->get('orders');
        
    //variable global para consultas en la base de datos
    global $wpdb;
        

    tabla_superior();
    
    //trae todas las 10 ultimas ordenes que esten  en woocommerce
    foreach($ordenes as $orden){
        //filtra las ordenes que esten en estado processing
        if($orden->status=="processing"){

            $orden_id = $orden->id;
            $nombre = $orden->billing->first_name;
            $apellido = $orden->billing->last_name;
            $empresa = $orden->billing->company;
            $email=$orden->billing->email;
            $fecha=$orden->date_created;

            //escoge tipo de licencia y cantidad opcional tabla
            if($orden->line_items[0]->product_id== 9594){
                $tipo_licencia="Básica";
                $cantidad_licencia=3;
            }else if($orden->line_items[0]->product_id== 9578){
                $tipo_licencia="Básica";
                $cantidad_licencia=1;
            }else if($orden->line_items[0]->product_id== 9593){
                $tipo_licencia="Premium";
                $cantidad_licencia=1;
            }
            //nombre de  el grupo
            $nombre_grupo=$empresa." ".$tipo_licencia." ".$fecha;

            // consulta el id del usuario en wordpress
            $sql_id = "SELECT ID FROM {$wpdb->prefix}users WHERE user_email = '$email'";
            $id = $wpdb->get_var($sql_id);
            
            //guarda el usuario en la tabla empresas
            $sql_empresa = "INSERT INTO {$wpdb->prefix}empresas (id,nombre, apellido, empresa) VALUES ('$id','$nombre','$apellido','$empresa')";
            $wpdb->query($sql_empresa);

            //crea el grupo
            $sql_grupo="INSERT INTO {$wpdb->prefix}grupos (nombre,id_empresa,tipo_licencia,cantidad_licencia,fecha_inicio) VALUES ('$nombre_grupo','$id','$tipo_licencia','$cantidad_licencia','$fecha')";
            $wpdb->query($sql_grupo);

            
            //actualizando la orden a completada
            $data= [
                'status' => 'completed'
            ];
            $update=$woocommerce->put('orders/'.$orden_id,$data);
   
        }
         

    }

    //mostrar registros en la tabla 
    $slq_email_colaboradores="SELECT email FROM {$wpdb->prefix}colaboradores;";
    $emails_colaboradores=$wpdb->get_results($slq_email_colaboradores);
    
    // var_dump($emails_colaboradores);

    foreach($emails_colaboradores as $email_colaborador){
        $peticion_moodle = file_get_contents('http://localhost/moodle/webservice/rest/server.php?wstoken=968f1132914db60ceb88bfb79830c9e7&wsfunction=core_user_get_users_by_field&field=email&values[0]='.$email_colaborador->email.'&moodlewsrestformat=json');
        $colaborador_moodle =  json_decode($peticion_moodle);
        
        echo "<tr>";
        echo "<td>".$colaborador_moodle[0]->username."</td>";
        echo "<td>".$colaborador_moodle[0]->firstname."</td>";
        echo "<td>".$colaborador_moodle[0]->lastname."</td>";
        echo "<td>".$colaborador_moodle[0]->email."</td>";
        echo "<td>".$colaborador_moodle[0]->city."</td>";
        echo "<td>".$colaborador_moodle[0]->country."</td>";
        echo '<td><button type="button" class="btn btn-outline-secondary">Editar</button></td>';
        echo "<tr>";
    }


    tabla_inferior();

    $scrt = '
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
    </script>';
    return $scrt;

};

//funcion para agregar el shortcode
add_shortcode('colaboradores_admin', 'colaboradores_admin');





