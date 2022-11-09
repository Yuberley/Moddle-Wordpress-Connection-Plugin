<?php

require_once plugin_dir_path(__FILE__) . '../../settings/enviroment.php';
require_once plugin_dir_path(__FILE__) . '../../src/vendor/autoload.php';
require_once plugin_dir_path(__FILE__) . '../../widgets/data_table_dinamic.php';
require_once plugin_dir_path(__FILE__) . '../../helpers/functions_requests.php';
require_once plugin_dir_path(__FILE__) . '../../helpers/functions_selects.php';
require_once plugin_dir_path(__FILE__) . '../../src/components/colaboradores_usuario/modal_agregar_colaborador_usuario.php';
require_once plugin_dir_path(__FILE__) . '../../src/components/colaboradores_usuario/modal_editar_colaborador_usuario.php';

function colaboradores_usuario(){
   
    global $wpdb;

    $CANTIDAD_LICENCIAS_DISPONIBLES_GRUPO = '#';
    $CANTIDAD_TOTAL_LICENCIAS_GRUPO = '#';

    $user_login= get_current_user_id();
    $empresaId = get_userdata($user_login)->id;

    $EMPRESA_CONSULTA = "SELECT id, empresa FROM {$wpdb->prefix}empresas WHERE id = '$empresaId'";
    $EMPRESA = $wpdb->get_row($EMPRESA_CONSULTA);

    $NOMBRE_EMPRESA = $EMPRESA->empresa;
    $NOMBRE_GRUPO = 'Sin seleccionar';
    $DIAS_RESTANTES_SUBSCRIPCION = '<span class="badge bg-dark">Sin seleccionar</span>';

    $colaboradores = "";

    if (isset($_POST['filtrar_colaboradores'])){
        $grupoId = $_POST['gruposInner'];

        $GRUPO_CONSULTA = "SELECT nombre, fecha_inicio, cantidad_licencia FROM {$wpdb->prefix}grupos WHERE id = $grupoId";
        $GRUPO = $wpdb->get_row($GRUPO_CONSULTA);
        
        $FECHA_INICIO_SUBSCRIPCION = new DateTime($GRUPO->fecha_inicio);
        $NOMBRE_GRUPO = $GRUPO->nombre;

        $FECHA_ACTUAL = new DateTime();
        $DIAS_RESTANTES_SUBSCRIPCION = $FECHA_INICIO_SUBSCRIPCION->diff($FECHA_ACTUAL);
        $DIAS_RESTANTES_SUBSCRIPCION = 365 - $DIAS_RESTANTES_SUBSCRIPCION->days;
        $DIAS_RESTANTES_SUBSCRIPCION = $DIAS_RESTANTES_SUBSCRIPCION <= 0 ? '<span class="badge bg-secondary">0 dias restantes</span>' : '<span class="badge bg-success">'.$DIAS_RESTANTES_SUBSCRIPCION.' dias restantes </span>';

        $CANTIDAD_INSCRITOS = "SELECT count(*) FROM wp_colaboradores WHERE id_grupo = '$grupoId'";
        $CANTIDAD_INSCRITOS_EN_GRUPO = $wpdb->get_var($CANTIDAD_INSCRITOS);

        $CANTIDAD_TOTAL_LICENCIAS_GRUPO = $GRUPO->cantidad_licencia;
        $CANTIDAD_LICENCIAS_DISPONIBLES_GRUPO = $CANTIDAD_TOTAL_LICENCIAS_GRUPO - $CANTIDAD_INSCRITOS_EN_GRUPO;

        $EMAIL_COLABORADORES_CONSULTA = "SELECT id, email FROM {$wpdb->prefix}colaboradores WHERE id_empresa = '$empresaId' AND id_grupo = '$grupoId'";
        $EMAIL_COLABORADORES = $wpdb->get_results($EMAIL_COLABORADORES_CONSULTA);

        $colaboradoresMoodle = [];

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
                                <button type="submit" class="btn btn-outline-danger ms-1" onclick="deleteCollaborator('.$userId.', '.$firstname.', '.$lastname.')" >Eliminar</button>
                        </div>
                    </td>
                </tr>';
        }
    }


    if(isset($_POST['eliminar_usuario'])){  
        $idUsuario = $_POST['idEliminar'];
        
        $ELIMINAR_COLABORADOR_CONSULTA = "DELETE FROM {$wpdb->prefix}colaboradores WHERE id = '$idUsuario'";
        $COLABORADOR_ELIMINADO = $wpdb->query($ELIMINAR_COLABORADOR_CONSULTA);
        
        if ( $COLABORADOR_ELIMINADO ){
            $deleteUser = deleteMoodleUser($idUsuario);
            echo '<script>
                    Swal.fire({
                        icon: "success",
                        title: "Colaborador eliminado correctamente",
                        showConfirmButton: false,
                        timer: 2000
                    })
                </script>';
        } 

        if ( !$COLABORADOR_ELIMINADO ) {
            echo '<script>
                    Swal.fire({
                        icon: "error",
                        title: "Error al eliminar colaborador",
                        showConfirmButton: false,
                        timer: 2000
                    })
                </script>';
        }
    }
   
    echo '
        <body >
            <div class="container mt-5">
                <div class="border-bottom mb-4">
                    <div class="row">
                        <div class="col-md-8"><h1>COLABORADORES 👥</h1></div>
                        <div class="col-md-4">
                            <div class="d-flex justify-content-end">
                                <a href="'.get_site_url().'/reportes-usuario/">
                                    <button class="btn btn-outline-dark" >📂 Ir a reportes</button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-5">
                        <div class="w-100 mt-2">
                            <section class="float-start" id="cantidad_licencias">
                                <span class="badge rounded-pill bg-dark"></span>
                                <label class="text-muted">Empresa: </label>
                                <span class="badge bg-dark">'.$NOMBRE_EMPRESA.'</span>
                                <label class="ps-2 text-muted">Grupo: </label>
                                <span class="badge bg-dark">'.$NOMBRE_GRUPO.'</span>
                            </section>
                            <section class="float-start mt-1" id="cantidad_licencias">
                                <label class="text-muted">Días disponibles de licencia: </label>
                                '.$DIAS_RESTANTES_SUBSCRIPCION.'
                            </section>
                            <section class="float-start mt-1" id="cantidad_licencias">
                                <label class="text-muted">Cantidad de licencias: </label>
                                <span class="badge bg-dark">'.$CANTIDAD_TOTAL_LICENCIAS_GRUPO.'</span>
                                <label class="ps-2 text-muted">Licencias disponibles: </label>
                                <span class="badge bg-dark">'.$CANTIDAD_LICENCIAS_DISPONIBLES_GRUPO.'</span>
                            </section>
                        </div>
                    </div>

                    <div class="col-7">
                        <form method="POST">
                            <div class="row">
                                <div class="col-md-4"></div>
                                <div class="col-md-6">
                                <label for="grupos">Grupos: </label>
                                <select class="form-select" name="gruposInner" id="grupos_set" required>
                                '.select_grupos_usuarios($empresaId).'
                                </select>
                                </div>
                                <div class="col-md-1"></div>
                                <div class="col-md-1 float-end">
                                    <br>
                                    <button class="btn btn-secondary float-end" value="123" type="submit" name="filtrar_colaboradores" id="button-addon2">Filtrar</button>
                                </div>
                            </div> 
                        </form>
                    </div>
                </div>    

            </div>
            
            <div class="container mt-5">
                
                <table class="table table-hover order-table border" id="table" >
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
                        <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#modal_agregar_colaborador" >Agregar Nuevo Colaborador</button>
                        </div>
                    </div>
                </div>
            </div>
            
            
            <!-- Modal agregar usuario -->
            '.modal_agregar_colaborador_usuario().'

            <!-- Modal editar usuario -->
            '.modal_editar_colaborador_usuario().'

            <script src='.plugin_dir_url(__FILE__)."../../assets/js/editCollaborator.js".' ></script>
            <script src='.plugin_dir_url(__FILE__)."../../assets/js/deleteCollaborator.js".' ></script>
            <script src='.plugin_dir_url(__FILE__)."../../assets/js/removeAccents.js".' ></script>
            
                
        </body>   ';

    return data_table_dinamic();

}

//funcion para agregar el shortcode
add_shortcode('colaboradores_usuario', 'colaboradores_usuario');





