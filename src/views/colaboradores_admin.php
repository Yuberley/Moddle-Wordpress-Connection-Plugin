<?php

require_once plugin_dir_path(__FILE__) . '../../settings/enviroment.php';
require_once plugin_dir_path(__FILE__) . '../../helpers/license_registration.php';
require_once plugin_dir_path(__FILE__) . '../../helpers/functions_requests.php';
require_once plugin_dir_path(__FILE__) . '../../src/components/colaboradores_admin/modal_agregar_colaborador.php';
require_once plugin_dir_path(__FILE__) . '../../src/components/colaboradores_admin/modal_editar_colaborador.php';
require_once plugin_dir_path(__FILE__) . '../../src/vendor/autoload.php';
require_once plugin_dir_path(__FILE__) . '../../widgets/data_table_dinamic.php';
require_once plugin_dir_path(__FILE__) . '../../helpers/functions_selects.php';



function colaboradores_admin(){ 
    
    global $wpdb;
    licenseRegistration();


    $CANTIDAD_LICENCIAS_DISPONIBLES_GRUPO = '0';
    $CANTIDAD_TOTAL_LICENCIAS_GRUPO = '0';
    $EMPRESA = 'Sin seleccionar';
    $GRUPO = 'Sin seleccionar';

    $colaboradores = "";

    if (isset($_POST['filtrar_colaboradores'])){
        $empresaId = $_POST['select_empresa'];
        $grupoId = $_POST['gruposInner'];

        $EMPRESA_CONSULTA = "SELECT empresa FROM {$wpdb->prefix}empresas WHERE id = '$empresaId'";
        $EMPRESA = $wpdb->get_results($EMPRESA_CONSULTA);
        $EMPRESA = $EMPRESA[0]->empresa;
        $GRUPO_CONSULTA = "SELECT nombre FROM {$wpdb->prefix}grupos WHERE id = '$grupoId'";
        $GRUPO = $wpdb->get_results($GRUPO_CONSULTA);
        $GRUPO = $GRUPO[0]->nombre;

        $CANTIDAD_INSCRITOS = "SELECT count(*) FROM wp_colaboradores WHERE id_grupo = '$grupoId'";
        $CANTIDAD_INSCRITOS_EN_GRUPO = $wpdb->get_var($CANTIDAD_INSCRITOS);

        $CANTIDAD_MAXIMA = "SELECT cantidad_licencia FROM wp_grupos WHERE id = '$grupoId'";
        $CANTIDAD_TOTAL_LICENCIAS_GRUPO = $wpdb->get_var($CANTIDAD_MAXIMA);
        $CANTIDAD_LICENCIAS_DISPONIBLES_GRUPO = $CANTIDAD_TOTAL_LICENCIAS_GRUPO - $CANTIDAD_INSCRITOS_EN_GRUPO;


        $EMAIL_COLABORADORES_CONSULTA = "SELECT id, email FROM {$wpdb->prefix}colaboradores WHERE id_empresa = '$empresaId' AND id_grupo = '$grupoId'";
        $EMAIL_COLABORADORES = $wpdb->get_results($EMAIL_COLABORADORES_CONSULTA);

        $colaboradoresMoodle;

        if (count($EMAIL_COLABORADORES) > 0){
            $colaboradoresMoodle = getMoodleUsersByField('email', $EMAIL_COLABORADORES);
        }

        foreach($colaboradoresMoodle as $colaborador){

                $userId = '`'.$colaborador->id.'`';
                $firstname = '`'.$colaborador->firstname.'`';
                $lastname = '`'.$colaborador->lastname.'`';
                $username = '`'.$colaborador->username.'`';
                $document = '`'.$colaborador->customfields[0]->value.'`';
                $email = '`'.$colaborador->email.'`';
                $city = '`'.$colaborador->city.'`';
                $country = '`'.$colaborador->country.'`';
                
                $colaboradores .= '
                <tr>
                    <td><img src="'.$colaborador->profileimageurlsmall.'" /></td>
                    <td>'.$colaborador->username.'</td>
                    <td>'.$colaborador->firstname.'</td>
                    <td>'.$colaborador->lastname.'</td>
                    <td>'.$colaborador->customfields[0]->value.'</td>
                    <td>'.$colaborador->email.'</td>
                    <td>'.$colaborador->city.'</td>
                    <td>'.$colaborador->country.'</td>
                    <td>
                        <div class="d-flex align-items-center">
                            <button 
                                class="btn btn-outline-secondary" 
                                class="btn btn-secondary"
                                data-bs-toggle="modal" 
                                data-bs-target="#modal_editar_colaborador"
                                onclick="editarColaborador('.$userId.', '.$firstname.', '.$lastname.', '.$username.', '.$document.', '.$email.', '.$city.', '.$country.')">
                                Editar</button>
                            <form method="POST">
                                <input type="hidden" name="idEliminar" value="'.$colaborador->id.'">
                                <button type="submit" class="btn btn-outline-danger ms-1" name="eliminar_usuario">Eliminar</button>
                            </form>
                        </div>
                    </td>
                </tr>';
        }
    }


    if(isset($_POST['eliminar_usuario'])){  
        $idUsuario = $_POST['idEliminar'];
        
        $ELIMINAR_COLABORADOR_CONSULTA = "DELETE FROM {$wpdb->prefix}colaboradores WHERE id = '$idUsuario'";
        $COLABORADOR_ELIMINADO = $wpdb->query($ELIMINAR_COLABORADOR_CONSULTA);
        
        if ($COLABORADOR_ELIMINADO){
            $deleteUser = deleteMoodleUser($idUsuario);
            echo '<script>
                    Swal.fire({
                        icon: "success",
                        title: "Colaborador eliminado correctamente",
                        showConfirmButton: false,
                        timer: 1500
                    })
                </script>';
        } else {
            echo '<script>
                    Swal.fire({
                        icon: "error",
                        title: "Error al eliminar colaborador",
                        showConfirmButton: false,
                        timer: 1500
                    })
                </script>';
        }
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
                       <select class="form-select"  name="select_empresa" id="select_empresa" onChange="filterGroups(this,`grupos_get`,`grupos_set`);">
                        <option selected value="0">Seleccione una Empresa</option>
                            '.select_empresas().'                   
                       </select>
                   </div>
                   <div class="col-md-3">
                       <select hidden class="form-select" name="select_grupo" id="grupos_get">
                            '.select_grupos().'            
                       </select>
                       <label for="grupos">Grupos: </label>
                        <select class="form-select" name="gruposInner" id="grupos_set" required>
    
                        </select>
                   </div>
                   
                   <div class="col-md-1 float-end">
                       <br>
                       <button class="btn btn-secondary float-end" value="123" type="submit" name="filtrar_colaboradores" id="button-addon2">Filtrar</button>
                   </div>
               </div> 
               </form>

               <section class="float-start" id="cantidad_licencias">
                       <label class="text-muted">Empresa: </label>
                       <span class="badge bg-dark">'.$EMPRESA.'</span>
                       <label class="ps-2 text-muted">Grupo: </label>
                       <span class="badge bg-dark">'.$GRUPO.'</span>
               </section>
               <section class="float-end" id="cantidad_licencias">
                       <label class="text-muted">Cantidad de licencias: </label>
                       <span class="badge bg-primary">'.$CANTIDAD_TOTAL_LICENCIAS_GRUPO.'</span>
                       <label class="ps-2 text-muted">Licencias disponibles: </label>
                       <span class="badge bg-primary">'.$CANTIDAD_LICENCIAS_DISPONIBLES_GRUPO.'</span>
               </section>
           </div>


           <div class="container mt-5">
               <table class="table order-table table-hover border" id="table" >
                   <thead style="background-color: #041541; color: white;">
                        <tr>
                            <th scope="col">Avatar</th>
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
                        <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#modal_agregar_colaborador">Agregar Nuevo Colaborador</button>
                   </div>
               </div>
           </div>
       </div>

       
       
       <!-- Modal agregar colaborador -->
        '.modal_agregar_colaborador().'

        <!-- Modal editar colaborador -->
        '.modal_editar_colaborador().'

        <script src='.plugin_dir_url(__FILE__)."../../assets/js/filtersSelects.js".' ></script>
        <script src='.plugin_dir_url(__FILE__)."../../assets/js/editCollaborator.js".' ></script>
        <script src='.plugin_dir_url(__FILE__)."../../assets/js/removeAccents.js".' ></script>
        
    </body>'; 

    return data_table_dinamic();

};

//funcion para agregar el shortcode
add_shortcode('colaboradores_admin', 'colaboradores_admin');
