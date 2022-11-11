<?php

require_once plugin_dir_path( __FILE__ ) . '../../../settings/enviroment.php';
require_once plugin_dir_path( __FILE__ ) . '../../../helpers/remove_accent.php';


function modal_agregar_colaborador_admin(){

    global $wpdb;


    if(isset($_POST['agregar_colaborador'])){
        

        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $usuario = remove_accent( strtolower( $_POST['usuario'] ) );
        $documento = $_POST['documento'];
        $email = $_POST['email'];
        $ciudad = $_POST['ciudad'];
        $pais = $_POST['pais'];
        $empresa = $_POST['empresas'];
        $grupo = $_POST['grupos'];


        $GRUPO_CONSULTA = "SELECT cantidad_licencia, fecha_inicio, tipo_licencia FROM {$wpdb->prefix}grupos WHERE id = $grupo";
        $GRUPO = $wpdb->get_row($GRUPO_CONSULTA);

        $TIPO_LICENCIA = $GRUPO->tipo_licencia;

        $FECHA_INICIO_SUBSCRIPCION = strtotime($GRUPO->fecha_inicio);
        $FECHA_FINAL_SUBSCRIPCION = strtotime($GRUPO->fecha_inicio.'+1 year');
        $FECHA_ACTUAL = strtotime( date("Y-m-d") );
        $SUBSCRIPCION_ACTIVA = $FECHA_ACTUAL > $FECHA_INICIO_SUBSCRIPCION && $FECHA_ACTUAL < $FECHA_FINAL_SUBSCRIPCION;
        
        $CANTIDAD_INSCRITOS_CONSULTA = "SELECT count(*) FROM {$wpdb->prefix}colaboradores WHERE id_grupo = '$grupo'";
        $CANTIDAD_INSCRITOS_EN_GRUPO = $wpdb->get_var($CANTIDAD_INSCRITOS_CONSULTA);
    
        $CANTIDAD_MAXIMA_EN_GRUPO = $GRUPO->cantidad_licencia;
        $CATIDAD_LICENCIAS_DISPONIBLES = $CANTIDAD_MAXIMA_EN_GRUPO - $CANTIDAD_INSCRITOS_EN_GRUPO;

        if( $CATIDAD_LICENCIAS_DISPONIBLES <= 0 ){
            echo '<script>
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "¡No se puede agregar más usuarios a este grupo!",
                        })
                    </script>';
        }


        $usuarioMoodle = getMoodleUserByUsername($usuario);
        $existeUsuarioMoodle = count($usuarioMoodle->users);

        if( $existeUsuarioMoodle ){
            echo '<script>
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "¡El nombre de usuario '.$usuario.' ya está registrado!",
                          })
                    </script>';
        }

        $emailMoodle = getMoodleUserByEmail($email); 
        $existeEmailMoodle = count($emailMoodle->users);

        if( $existeEmailMoodle ){
            echo '<script>
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "¡El email '.$email.' ya está registrado!",
                          })
                    </script>';
        }

        if( !$SUBSCRIPCION_ACTIVA ){
            echo '<script>
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "¡La suscripción de este grupo ha expirado!",
                          })
                    </script>';
        }
      
        if( !$existeUsuarioMoodle && !$existeEmailMoodle && $CATIDAD_LICENCIAS_DISPONIBLES > 0 && $SUBSCRIPCION_ACTIVA ){
            
            $user = (object)[
                'username' => $usuario,
                'firstname' => $nombre,
                'lastname' => $apellido,
                'email' => $email,
                'city' => $ciudad,
                'country' => $pais,
                'document' => $documento,
                'customfield' => 'identification',
            ];
            
            $createUserResponse = createMoodleUser($user);
            $userId = $createUserResponse[0]->id;
            
            $courses = [];

            if ( $TIPO_LICENCIA == 'basic' ){
                $coursesRequest = getMoodleCoursesByCategory( getMoodleCategoryId()['basic'] );
                $courses = array_merge( $coursesRequest->courses );
            }

            if ( $TIPO_LICENCIA == 'premium' ){
                $coursesRequest = getMoodleCoursesByCategory( getMoodleCategoryId()['basic'] );
                $courses = array_merge( $courses, $coursesRequest->courses );
                $coursesRequest = getMoodleCoursesByCategory( getMoodleCategoryId()['premium'] );
                $courses = array_merge( $courses, $coursesRequest->courses );
            }

            $subscribedCourses =  subscribeCoursesMoodleUser( $userId, $FECHA_INICIO_SUBSCRIPCION, $FECHA_FINAL_SUBSCRIPCION, $courses );
            
            
            if($TIPO_LICENCIA=="premium"){
                $coursesRequest = getMoodleCoursesByCategory( getMoodleCategoryId()["basic"] );
                $courses = array_merge( $coursesRequest->courses );
    
                $subscribedCourses =  subscribeCoursesMoodleUser( $userId, $FECHA_INICIO_SUBSCRIPCION, $FECHA_FINAL_SUBSCRIPCION, $courses );
            }
            // El colaborador se crea en moodle y en wordpress con el mismo  
            // identificador (id que retorna moodle al crear el usuario) por 
            // facilidad de actualizacion y eliminacion de usuarios.
            $GUARDAR_USUARIO_CONSULTA = "INSERT INTO {$wpdb->prefix}colaboradores (id, nombre, apellido, documento, email, id_empresa, id_grupo) VALUES  ('$userId', '$nombre', '$apellido', '$documento', '$email', '$empresa', '$grupo')";
            $USUARIO_GUARDADO = $wpdb->query($GUARDAR_USUARIO_CONSULTA);
            
            if( $USUARIO_GUARDADO ){
                echo '<script>
                            Swal.fire({
                                position: "center",
                                icon: "success",
                                title: "Guardado correctamente!",
                                showConfirmButton: false,
                                timer: 2000,
                            });
                        </script>';
            } 

            if ( !$USUARIO_GUARDADO ) {
                $deleteUser = deleteMoodleUser($userId);
                echo '<script>
                            Swal.fire({
                                icon: "error",
                                title: "Oops...",
                                text: "¡No se pudo guardar el usuario!",
                            })
                        </script>';
            }

        }
            
    }

    echo '
       <!-- Modal agregar usuario -->
       <div class="modal fade" id="modal_agregar_colaborador" data-bs-backdrop="static" tabindex="-1" >
         <div class="modal-dialog modal-lg modal-dialog-centered">
           <div class="modal-content">
             <div class="modal-header justify-content-center">
               <h5 class="modal-title mb-0" >Agregar Nuevo Colaborador</h5>
             </div>
             <div class="modal-body px-5">
                   <div>
                       <form id="filtro" method="POST" >
                        <section class="d-flex align-items-center justify-content-center row">
                            <div class="mb-3 col-12 col-sm-6">
                                    <label for="empresa" class="col-form-label">Empresa</label>
                                    <select class="form-select" name="empresas" id="empresas" onChange="filterGroups(this,`grupos_agregar_get`,`grupos_agregar_set`);">
                                        <option selected value="0">Seleccione una empresa</option>
                                        '.select_empresas().'
                                    </select>
                                </div>
                                <div class="mb-3 col-12 col-sm-6">
                                    <select hidden class="form-select" name="grupos" id="grupos_agregar_get">
                                        '.select_grupos().'
                                    </select>
                                    <label for="consolidado" class="col-form-label">Grupos</label>
                                    <select class="form-select" name="grupos" id="grupos_agregar_set" required>

                                    </select>
                                </div>
                        </section>
                        <section class="d-flex align-items-center justify-content-center row">
                                <div class="mb-3 col-12 col-sm-6">
                                    <label  class="form-label" for="Nombre">Nombre</label>
                                    <input class="form-control" name="nombre" type="text" id="Nombre" required>
                                </div>
                                <div class="mb-3 col-12 col-sm-6">
                                    <label class="form-label" for="apellido">Apellido</label>
                                    <input class="form-control" name="apellido" type="text" id="apellido" required>
                                </div>
                        </section>
                            <section class="d-flex align-items-center justify-content-center row">
                                <div class="mb-3 col-12 col-sm-6">
                                    <label class="form-label" for="usuario">Usuario</label>
                                    <input class="form-control text-lowercase" onChange="removeAccents(this);" name="usuario" id="usuario" type="text" placeholder="Se registrará sin acentos y en minúscula" required>
                                </div>
                                <div class="mb-3 col-12 col-sm-6">
                                    <label class="form-label" for="documento">Documento</label>
                                    <input class="form-control" name="documento" type="number" id="documento" min="10000" max="10000000000000" required>
                                </div>
                            </section>
                            <section class="d-flex align-items-center justify-content-center row">
                                <div class="mb-3 col-12">
                                    <label class="form-label" for="email">Email</label>
                                    <input class="form-control" name="email" type="email" id="email" required>
                                </div>
                            </section>
                            <section class="d-flex align-items-center justify-content-center row">
                                <div class="mb-3 col-12 col-sm-6">
                                    <label class="form-label" for="ciudad">Ciudad</label>
                                    <input class="form-control" name="ciudad" type="text" id="ciudad" required>
                                </div>
                                <div class="mb-3 col-12 col-sm-6">
                                    <label class="form-label" for="pais">Pais</label>
                                    <select class="form-select" name="pais" id="pais" required>
                                        <option selected value="CO">Colombia</option>
                                        <option value="EC">Ecuador</option>
                                        <option value="PE">Perú</option>
                                        <option value="MX">México</option>
                                        <option value="US">Estados Unidos</option>
                                    </select>
                                </div>
                            </section>
                            <div class="mb-3 d-flex justify-content-center" id="button_inner">
                                <input type="submit" name="agregar_colaborador" value="Agregar Colaborador" id="agregar_colaborador">
                            </div>
                       </form>
                   </div>
             </div>
             <div class="modal-footer justify-content-center">
               <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="close_modal">Cerrar</button>
             </div>
           </div>
         </div>
       </div>';
}