<?php

require_once plugin_dir_path(__FILE__) . '../../settings/enviroment.php';
require_once plugin_dir_path(__FILE__) . '../../helpers/license_registration.php';
require_once plugin_dir_path(__FILE__) . '../../helpers/functions_requests.php';
require_once plugin_dir_path(__FILE__) . '../../src/components/colaboradores_admin/modal_agregar_colaborador.php';
require_once plugin_dir_path(__FILE__) . '../../src/vendor/autoload.php';
require_once plugin_dir_path(__FILE__) . '../../widgets/data_table_dinamic.php';
require_once plugin_dir_path(__FILE__) . '../../helpers/functions_selects.php';

function colaboradores_admin(){ 
    
    global $wpdb;
    licenseRegistration();


    
    $colaboradores = "";

    if (isset($_POST['filtrar'])){
        $empresaId = $_POST['select_empresa'];
        $grupoId = $_POST['gruposInner'];
        $slq_email_colaboradores = "SELECT email FROM {$wpdb->prefix}colaboradores WHERE id_empresa = '$empresaId' AND id_grupo = '$grupoId'";
        $emails_colaboradores = $wpdb->get_results($slq_email_colaboradores);
    
        foreach($emails_colaboradores as $email_colaborador){
            $peticion_moodle = file_get_contents(getMoodleUrl().'&wsfunction=core_user_get_users_by_field&field=email&values[0]='.$email_colaborador->email);
            $colaborador_moodle = json_decode($peticion_moodle);

            
            if( $colaborador_moodle[0]->email != "" ){               
                
                $colaboradores .= "
                <tr>
                    <td>".$colaborador_moodle[0]->username."</td>
                    <td>".$colaborador_moodle[0]->firstname."</td>
                    <td>".$colaborador_moodle[0]->lastname."</td>
                    <td>".$colaborador_moodle[0]->customfields[0]->value."</td>
                    <td>".$colaborador_moodle[0]->email."</td>
                    <td>".$colaborador_moodle[0]->city."</td>
                    <td>".$colaborador_moodle[0]->country."</td>
                    <td>
                    <div class='d-flex align-items-center'>
                    <button type='button' class='btn btn-outline-secondary'>Editar</button>
                    <form method='post' >
                        <input type='hidden' name='email' value='".$colaborador_moodle[0]->email."'>
                        <button type='submit' class='btn btn-outline-danger ms-1' name='eliminar'>Eliminar</button>
                    </form>
                    </div>
                    </td>
                </tr>";
            }
        }
    }

    // funcion para eliminar colaboradores
if(isset($_POST['eliminar'])){  
    $email = $_POST['email'];
    $sql_eliminar_colaborador = "DELETE FROM {$wpdb->prefix}colaboradores WHERE email = '$email'";
    $wpdb->query($sql_eliminar_colaborador);

    $peticion_buscar_id_moodle = file_get_contents(getMoodleUrl().'&wsfunction=core_user_get_users_by_field&field=email&values[0]='.$email);
    $colaborador_id_moodle = json_decode($peticion_buscar_id_moodle);
    $id_moodle = $colaborador_id_moodle[0]->id;
    $peticion_suspender_colaborador= file_get_contents(getMoodleUrl().'&wsfunction=core_user_update_users&users[0][id]='.$id_moodle.'&users[0][suspended]=1');
}

    echo '
        <body >
           <div class="container mt-5">
               <div class="row">
                   <div class="col-md-8"><h1>COLABORADORES</h1></div>
               </div>
               <form method="POST">
               <div class="row">
                   <div class="col-md-4"> 
                      <br>
                       <div class="input-group mb-3">
                           <input type="text" class="form-control light-table-filter" data-table="order-table" placeholder="Buscar Colaborador">
                       </div>
                   </div>
                   <div class="col-md-1"></div>
                   <div class="col-md-3">
                       <label for="empresa">Empresas: </label>
                       <select class="form-select"  name="select_empresa" id="select_empresa" onChange="filterGroups(this);">
                        <option selected value="0">Seleccione una Empresa</option>
                            '.select_empresas().'                   
                       </select>
                   </div>
                   <div class="col-md-3">
                       <select hidden class="form-select" name="select_grupo" id="grupos">
                            '.select_grupos().'            
                       </select>
                       <label for="grupos">Grupos: </label>
                        <select class="form-select" name="gruposInner" id="gruposInner" required>
    
                        </select>
                   </div>
                   
                   <div class="col-md-1">
                       <br>
                       <button class="btn btn-secondary" value="123" type="submit" name="filtrar" id="button-addon2">Filtrar</button>
                   </div>
    
               </div> 
               </form>
           </div>
           
           <div class="container mt-5">
               
               <table class="table order-table table-hover" id="table" >
                   <thead style="background-color: #041541; color: white;">
                        <tr>
                           <th scope="col">Usuario</th>
                           <th scope="col">Nombre </th>
                           <th scope="col">Apellido</th>
                           <th scope="col">Documento</th>
                           <th scope="col">Email</th>
                           <th scope="col">Ciudad</th>
                           <th scope="col">Pais</th>
                           <th scope="col">Ajustes</th>
                           
                       </tr>
                   </thead>
                   <tbody id="personas">
                        '.$colaboradores.'
               </tbody>
           </table> 
       </div>
       <div class="container mt-5">
       
       <div class="row">
           <div class="col-md-8"><h1></h1></div>
               <div class="col-md-4"> 
                   <div class="input-group mb-3 d-flex justify-content-end">
                   <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#modal_agregar_colaborador" >Agregar Nuevo Colaborador</button>
                   </div>
               </div>
           </div>
       </div>
       
       <!-- Modal agregar usuario -->
        '.modal_agregar_colaborador().'
        
        <script>
            let grupos = document.getElementById("grupos");
            function filterGroups(event){

                let options_grupos = "";
                for(let i = 0; i < grupos.options.length; i++){
                    if(grupos.options[i].text.includes(event.options[event.selectedIndex].text)){
                        options_grupos += "<option value="+grupos.options[i].value+">"+grupos.options[i].text+"</option>";
                    }
                }
                document.getElementById("gruposInner").innerHTML = options_grupos;
                document.getElementById("gruposInsert").innerHTML = options_grupos;
                
            }

        </script>
 
   </body>'; 

    return data_table_dinamic();

};

//funcion para agregar el shortcode
add_shortcode('colaboradores_admin', 'colaboradores_admin');
