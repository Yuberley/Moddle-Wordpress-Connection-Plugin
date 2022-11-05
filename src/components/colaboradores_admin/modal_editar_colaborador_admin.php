<?php

require_once plugin_dir_path( __FILE__ ) . '../../../settings/enviroment.php';

function modal_editar_colaborador_admin(){

    global $wpdb;


    if( isset($_POST['editar_colaborador']) ){

        $idUsuario = $_POST['idEditar'];
        $usuario = $_POST['usuarioEditar'];
        $nombre = $_POST['nombreEditar'];
        $apellido = $_POST['apellidoEditar'];
        $documento = $_POST['documentoEditar'];
        $email = $_POST['emailEditar'];
        $ciudad = $_POST['ciudadEditar'];
        $pais = $_POST['paisEditar'];


        // Se valida que el nombre de usuario no esté registrado en moodle, 
        // excepto el usuario que se está editando, para el caso en el que el 
        // nombre de usuario esté registrado en moodle, se verifica que el id 
        // sea diferente para confirmar si ya existe otro usuario con ese nombre de usuario.
        $usuarioMoodle = getMoodleUserByUsername($usuario);
        $existeUsuarioMoodle = count($usuarioMoodle->users);
    
        $existeUsuarioIgualMoodle = $existeUsuarioMoodle && $usuarioMoodle->users[0]->id != $idUsuario;
    
        if( $existeUsuarioIgualMoodle ){
            echo '<script>
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "¡El nombre de usuario '.$usuario.' ya está registrado!",
                        })
                    </script>';
        }

        // Se valida que el email no esté registrado en moodle,
        // excepto el email que se está editando, para el caso en el que el
        // email esté registrado en moodle, se verifica que el id
        // sea diferente para confirmar si ya existe otro usuario con ese email.
        $emailMoodle = getMoodleUserByEmail($email);
        $existeEmailMoodle = count($emailMoodle->users);

        $existeEmailIgualMoodle = $existeEmailMoodle && $emailMoodle->users[0]->id != $idUsuario;

        if( $existeEmailIgualMoodle ){
            echo '<script>
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "¡El email '.$emai.' ya está registrado!",
                        })
                    </script>';
        }

        if ( !$existeUsuarioIgualMoodle && !$existeEmailIgualMoodle ){

            $user = (object)[
                'id' => $idUsuario,
                'username' => $usuario,
                'firstname' => $nombre,
                'lastname' => $apellido,
                'email' => $email,
                'city' => $ciudad,
                'country' => $pais,
                'document' => $documento,
                'customfield' => 'identification',
            ];
            
            $updateUserResponse = updateMoodleUser($idUsuario, $user);

            $EDITAR_USUARIO_CONSULTA = "UPDATE {$wpdb->prefix}colaboradores SET nombre = '$nombre', apellido = '$apellido', email = '$email' WHERE id = '$idUsuario'";
            $USUARIO_EDITADO = $wpdb->query($EDITAR_USUARIO_CONSULTA);

            echo '<script>
                    Swal.fire({
                        icon: "success",
                        title: "¡Usuario editado!",
                        text: "El usuario ha sido editado correctamente",
                        showConfirmButton: false,
                        timer: 2000,
                    })
                </script>';

        }

    }

    echo '
       <div class="modal fade" id="modal_editar_colaborador" data-bs-backdrop="static" tabindex="-1" >
         <div class="modal-dialog modal-lg modal-dialog-centered">
           <div class="modal-content">
             <div class="modal-header justify-content-center">
               <h5 class="modal-title mb-0">Editar Colaborador</h5>
             </div>
             <div class="modal-body px-5">
                   <div>
                       <form id="editar" method="POST">
                            <input hidden class="form-control" name="idEditar" type="text" id="idEditar" required>
                            <section class="d-flex align-items-center justify-content-center row">
                                    <div class="mb-3 col-12 col-sm-6">
                                        <label  class="form-label" for="nombreEditar">Nombre</label>
                                        <input class="form-control" name="nombreEditar" type="text" id="nombreEditar" required>
                                    </div>
                                    <div class="mb-3 col-12 col-sm-6">
                                        <label class="form-label" for="apellidoEditar">Apellido</label>
                                        <input class="form-control" name="apellidoEditar" type="text" id="apellidoEditar" required>
                                    </div>
                            </section>
                            <section class="d-flex align-items-center justify-content-center row">
                                <div class="mb-3 col-12 col-sm-6">
                                    <label class="form-label" for="usuarioEditar">Usuario</label>
                                    <input class="form-control text-lowercase" name="usuarioEditar" id="usuarioEditar"  onChange="removeAccents(this);" type="text" required>
                                </div>
                                <div class="mb-3 col-12 col-sm-6">
                                    <label class="form-label" for="documentoEditar">Documento</label>
                                    <input class="form-control" name="documentoEditar" id="documentoEditar" type="number"  required>
                                </div>
                            </section>
                            <section class="d-flex align-items-center justify-content-center row">
                                <div class="mb-3 col-12">
                                    <label class="form-label" for="emailEditar">Email</label>
                                    <input class="form-control" name="emailEditar" id="emailEditar" type="email" required>
                                </div>
                            </section>
                            <section class="d-flex align-items-center justify-content-center row">
                                <div class="mb-3 col-12 col-sm-6">
                                    <label class="form-label" for="ciudadEditar">Ciudad</label>
                                    <input class="form-control" name="ciudadEditar" id="ciudadEditar" type="text" required>
                                </div>
                                <div class="mb-3 col-12 col-sm-6">
                                    <label class="form-label" for="paisEditar">Pais</label>
                                    <select class="form-select" name="paisEditar" id="paisEditar" required>
                                        <option selected value="CO">Colombia</option>
                                        <option value="EC">Ecuador</option>
                                        <option value="PE">Perú</option>
                                        <option value="MX">México</option>
                                        <option value="US">Estados Unidos</option>
                                    </select>
                                </div>
                            </section>
                            <div class="mb-3 d-flex justify-content-center" id="button_inner">
                                <input type="submit" name="editar_colaborador" value="Actualizar Información" id="editar_colaborador">
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