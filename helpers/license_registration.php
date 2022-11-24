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
            $orden_id = $orden->id;
            $id_grupo = $orden_id;

            foreach($orden->line_items as $item){
                $id_grupo = $id_grupo + 1;
                $id_user = $orden->customer_id;
                $empresa = $orden->billing->company;
                $fechaconvert = $orden->date_created;
                $separador_fecha = explode("T", $fechaconvert);
                $fecha = $separador_fecha[0];
                $FECHA_INICIO_SUBSCRIPCION = strtotime($fecha);
                $FECHA_FINAL_SUBSCRIPCION = strtotime($fecha.'+1 year');       
                
                //consulta el nombre de la empresa en la base de datos y analiza si existe
                //$SQL_NOMBRE_EMPRESA = "SELECT empresa FROM {$wpdb->prefix}empresas WHERE id = '$id_user'";
                $SQL_EMPRESA = "SELECT id, empresa FROM {$wpdb->prefix}empresas WHERE empresa = '$empresa'";
                $EMPRESADB = $wpdb->get_results($SQL_EMPRESA);
                
                $numero_de_empresas_db = count($EMPRESADB);
                
                if ($numero_de_empresas_db == 1 && $EMPRESADB[0]->id==$id_user) {
                    $empresa = $EMPRESADB[0]->empresa;
                }elseif($numero_de_empresas_db >= 1){
                    $numero_de_empresas_db++;
                    $empresa = $empresa." - ".$numero_de_empresas_db;                   
                }  
                
                $nombre_paquete = $item->name;
                $array_nombre_paquete = explode(" ",$nombre_paquete);
                
                if($array_nombre_paquete[1] == "Personal"){
                    $tipo_licencia = strtolower($array_nombre_paquete[2]);
                    $cantidad_licencia = 1;                  
                        
                    $usuarioMoodle = getMoodleUserByUsername($orden->billing->email);
                    $existeUsuarioMoodle = count($usuarioMoodle->users);
                    $emailMoodle = getMoodleUserByEmail($orden->billing->email); 
                    $existeEmailMoodle = count($emailMoodle->users);

                    if( !$existeUsuarioMoodle && !$existeEmailMoodle){
                        $user_new = (object)[
                            'username' => $orden->billing->email,
                            'firstname' => $orden->billing->first_name,
                            'lastname' => $orden->billing->last_name,
                            'email' => $orden->billing->email,
                            'city' => $orden->billing->city,
                            'country' => $orden->billing->country,
                            'document' => '',
                            'customfield'=> 'identification',
                        ];
    
                        $createUserResponse = createMoodleUser($user_new);
                        $id_user_moodle = $createUserResponse[0]->id;
                        
                        $coursesRequest = getMoodleCoursesByCategory( getMoodleCategoryId()[$tipo_licencia] );
                        $courses = array_merge( $coursesRequest->courses );
            
                        $subscribedCourses =  subscribeCoursesMoodleUser( $id_user_moodle, $FECHA_INICIO_SUBSCRIPCION, $FECHA_FINAL_SUBSCRIPCION, $courses );

                        if($tipo_licencia=="premium"){
                            $coursesRequest = getMoodleCoursesByCategory( getMoodleCategoryId()["basic"] );
                            $courses = array_merge( $coursesRequest->courses );
                
                            $subscribedCourses =  subscribeCoursesMoodleUser( $id_user_moodle, $FECHA_INICIO_SUBSCRIPCION, $FECHA_FINAL_SUBSCRIPCION, $courses );
                        }

                        $data = [
                            'status' => 'completed',     
                        ];
                    
                        $update = $WOOCOMMERCE_CONECTION->put('orders/'.$orden_id, $data);
                        

                    }
                    return;

                }else if ($array_nombre_paquete[1] == "Empresas"){
                    $tipo_licencia = strtolower($array_nombre_paquete[2]);
                    $cantidad_licencia=$item->quantity;
                }
        
                // obtiene el nombre de  el grupo y revisa si esta repetido   
                $nombre_grupo = $empresa." ".$tipo_licencia." ".$fecha;
                $sql_grupos_existentes = "SELECT nombre FROM {$wpdb->prefix}grupos WHERE nombre = '$nombre_grupo'";
                $grupo_existente = $wpdb->get_var($sql_grupos_existentes);
                
                $digito_final_grupo = 1;
                while ($grupo_existente != NULL) {
                    $digito_final_grupo++;
                    $nombre_grupo_consulta = $nombre_grupo." Grupo ".$digito_final_grupo;
                    $sql_grupos_existentes = "SELECT nombre FROM {$wpdb->prefix}grupos WHERE nombre = '$nombre_grupo_consulta'";
                    $grupo_existente = $wpdb->get_var($sql_grupos_existentes);
                    
                }
                if ($digito_final_grupo > 1) {
                    $nombre_grupo = $nombre_grupo." Grupo ".$digito_final_grupo;
                }

                //consulta si los datos de usuario en la base de datos
                $sql_nombre = "SELECT display_name FROM {$wpdb->prefix}users WHERE ID = $id_user";
                $nombre = $wpdb->get_var($sql_nombre);
                
                //guarda la empresa en la base de datos
                $sql_empresa = "INSERT INTO {$wpdb->prefix}empresas (id,nombre, empresa) VALUES ('$id_user','$nombre','$empresa')";
                $wpdb->query($sql_empresa);

                // guarda el grupo y las licencia en la base de datos
                $sql_grupo = "INSERT INTO {$wpdb->prefix}grupos (id,nombre,id_empresa,tipo_licencia,cantidad_licencia,fecha_inicio) VALUES ('$id_grupo','$nombre_grupo','$id_user','$tipo_licencia','$cantidad_licencia','$fecha')";
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