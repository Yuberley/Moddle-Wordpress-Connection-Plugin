<?php

require_once plugin_dir_path( __FILE__ ) . '../../../settings/enviroment.php';
require_once plugin_dir_path( __FILE__ ) . '../../../helpers/remove_accent.php';


function modal_agregar_colaborador(){

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

        
        $CANTIDAD_INSCRITOS_CONSULTA = "SELECT count(*) FROM wp_colaboradores WHERE id_grupo = '$grupo'";
        $CANTIDAD_INSCRITOS_EN_GRUPO = $wpdb->get_var($CANTIDAD_INSCRITOS_CONSULTA);
    
        $CANTIDAD_MAXIMA_CONSULTA = "SELECT cantidad_licencia FROM wp_grupos WHERE id = '$grupo'";
        $CANTIDAD_MAXIMA_EN_GRUPO = $wpdb->get_var($CANTIDAD_MAXIMA_CONSULTA);
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
                            text: "¡El nombre de usuario ya está registrado!",
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
                            text: "¡El email ya está registrado!",
                          })
                    </script>';
        }

      
        if( !$existeUsuarioMoodle && !$existeEmailMoodle && $CATIDAD_LICENCIAS_DISPONIBLES > 0 ){

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
            
            $INSERTAR_USUARIO_CONSULTA = "INSERT INTO {$wpdb->prefix}colaboradores (id, nombre, apellido, email, id_empresa, id_grupo) VALUES  ('$userId', '$nombre', '$apellido', '$email', '$empresa', '$grupo')";
            $INSERTAR_USUARIO = $wpdb->query($INSERTAR_USUARIO_CONSULTA);
            
            if( $INSERTAR_USUARIO ){
                echo '<script>
                            Swal.fire({
                                position: "center",
                                icon: "success",
                                title: "Guardado correctamente!",
                                showConfirmButton: false,
                                timer: 1500,
                            });
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
                                    <input class="form-control" name="documento" type="number" id="docimento" required>
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