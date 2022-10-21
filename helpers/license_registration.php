<?php

require_once plugin_dir_path(__FILE__ ) . 'functions_requests.php';

function licenseRegistration(){

    //variable global para consultas en la base de datos
    global $wpdb;
    
    $WOOCOMMERCE_CONECTION = getWoocommerce();

    //trae las 10 ultimas ordenes que esten  en woocommerce
    $ordenes = $WOOCOMMERCE_CONECTION->get('orders');
        
    foreach($ordenes as $orden){

        //filtra las ordenes que esten en estado processing
        if($orden->status=="processing" ){

            foreach($orden->line_items as $item){
                
                $orden_id = $orden->id;
                $id_user = $orden->customer_id;
                $empresa = $orden->billing->company;
                $fechaconvert = $orden->date_created;
                $separador_fecha = explode("T", $fechaconvert);
                $fecha = $separador_fecha[0];       
                
                //consulta el nombre de la empresa en la base de datos
                $sql_nombre_empresa = "SELECT empresa FROM {$wpdb->prefix}empresas WHERE id = '$id_user'";
                $empresa = $wpdb->get_var($sql_nombre_empresa);
                

                $cadena = $item->name;
                $separador = " ";
                $cadena_separada = explode($separador,$cadena);
                
                if($cadena_separada[1] == "Personal"){
                    $tipo_licencia = strtolower($cadena_separada[2]);
                    $cantidad_licencia = 1;
                }else if ($cadena_separada[1] == "Empresas"){
                    $tipo_licencia = strtolower($cadena_separada[2]);
                    $cantidad_licencia=$orden->line_items[0]->quantity;
                }
        
                // obtiene el nombre de  el grupo y revisa si esta repetido   
                $nombre_grupo = $empresa." ".$tipo_licencia." ".$fecha;
                $sql_grupos_existentes = "SELECT nombre FROM {$wpdb->prefix}grupos WHERE nombre = '$nombre_grupo'";
                $grupo_existente = $wpdb->get_var($sql_grupos_existentes);
                
                $digito_final_grupo = 1;
                while ($grupo_existente != null) {
                    $digito_final_grupo++;
                    $nombre_grupo .= " Grupo ".$digito_final_grupo;
                    $sql_grupos_existentes = "SELECT nombre FROM {$wpdb->prefix}grupos WHERE nombre = '$nombre_grupo'";
                    $grupo_existente = $wpdb->get_var($sql_grupos_existentes);
                }

                //consulta si los datos de usuario en la base de datos
                $sql_nombre = "SELECT display_name FROM {$wpdb->prefix}users WHERE ID = $id_user";
                $nombre = $wpdb->get_var($sql_nombre);
                
                //guarda la empresa en la base de datos
                $sql_empresa = "INSERT INTO {$wpdb->prefix}empresas (id,nombre, empresa) VALUES ('$id_user','$nombre','$empresa')";
                $wpdb->query($sql_empresa);

                // guarda el grupo y las licencia en la base de datos
                $sql_grupo = "INSERT INTO {$wpdb->prefix}grupos (nombre,id_empresa,tipo_licencia,cantidad_licencia,fecha_inicio) VALUES ('$nombre_grupo','$id_user','$tipo_licencia','$cantidad_licencia','$fecha')";
                $wpdb->query($sql_grupo);

                
                //actualizando la orden a completada
                $data = [
                    'status' => 'completed',     
                ];
            
                $update = $WOOCOMMERCE_CONECTION->put('orders/'.$orden_id, $data);
               
            }   
        } 
         
    }
    

}