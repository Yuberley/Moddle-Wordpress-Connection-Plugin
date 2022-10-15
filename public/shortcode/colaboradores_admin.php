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
        


    
    //trae todas las 10 ultimas ordenes que esten  en woocommerce
    foreach($ordenes as $orden){
        //filtra las ordenes que esten en estado processing
        if($orden->status=="processing"){

            $orden_id = $orden->id;
            $id_user= $orden->customer_id;
            // $nombre = $orden->billing->first_name;
            // $apellido = $orden->billing->last_name;
            $empresa = $orden->billing->company;
            // $email=$orden->billing->email;
            $fecha=$orden->date_created;


            
            $cadena=$orden->line_items[0]->name;
            $separador=" ";
            $cadena_separada=explode($separador,$cadena);

            if($cadena_separada[1]=="Personal"){
                $tipo_licencia= strtolower($cadena_separada[2]);
                $cantidad_licencia=1;
            }else if ($cadena_separada[1]=="Empresas"){
                $tipo_licencia= strtolower($cadena_separada[2]);
                $cantidad_licencia=$orden->line_items[0]->quantity;
            }
    

            //nombre de  el grupo
            $nombre_grupo=$empresa." ".$tipo_licencia." ".$fecha;

            //consulta si los datos de usuario en la base de datos
            $sql_nombre ="SELECT display_name FROM {$wpdb->prefix}users WHERE ID = $id_user";
            $nombre = $wpdb->get_var($sql_nombre);
            
            //guarda el usuario en la tabla empresas
            $sql_empresa = "INSERT INTO {$wpdb->prefix}empresas (id,nombre, empresa) VALUES ('$id_user','$nombre','$empresa')";
            $wpdb->query($sql_empresa);

            //crea el grupo
            $sql_grupo="INSERT INTO {$wpdb->prefix}grupos (nombre,id_empresa,tipo_licencia,cantidad_licencia,fecha_inicio) VALUES ('$nombre_grupo','$id_user','$tipo_licencia','$cantidad_licencia','$fecha')";
            $wpdb->query($sql_grupo);

            
            //actualizando la orden a completada
            $data= [
                'status' => 'completed'
                
            ];
          
            $update=$woocommerce->put('orders/'.$orden_id,$data);
            echo "completed";
        }
         

    }

    //mostrar registros en la tabla 
    $slq_email_colaboradores="SELECT email FROM {$wpdb->prefix}colaboradores;";
    $emails_colaboradores=$wpdb->get_results($slq_email_colaboradores);
    
    // var_dump($emails_colaboradores);
    tabla_superior();
    
    foreach($emails_colaboradores as $email_colaborador){
        $peticion_moodle = file_get_contents('http://localhost/moodle/webservice/rest/server.php?wstoken=968f1132914db60ceb88bfb79830c9e7&wsfunction=core_user_get_users_by_field&field=email&values[0]='.$email_colaborador->email.'&moodlewsrestformat=json');
        $colaborador_moodle =  json_decode($peticion_moodle);
        
        echo "<tr>
        <td>".$colaborador_moodle[0]->username."</td>
        <td>".$colaborador_moodle[0]->firstname."</td>
        <td>".$colaborador_moodle[0]->lastname."</td>
        <td>".$colaborador_moodle[0]->email."</td>
        <td>".$colaborador_moodle[0]->city."</td>
        <td>".$colaborador_moodle[0]->country."</td>
        <td><button type='button' class='btn btn-outline-secondary'>Editar</button></td>
        <tr>";
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





