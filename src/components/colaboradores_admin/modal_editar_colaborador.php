<?php

require_once plugin_dir_path( __FILE__ ) . '../../../settings/enviroment.php';

function modal_editar_colaborador(){

    global $wpdb;

    if( isset($_POST['editar_colaborador']) ){

        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $email = $_POST['email'];
        $empresa = $_POST['empresas'];
        $grupo = $_POST['grupos'];

        $sql = "UPDATE {$wpdb->prefix}colaboradores SET nombre = '$nombre', apellido = '$apellido', email = '$email', id_empresa = '$empresa', id_grupo = '$grupo' WHERE id = '$id'";
        $respuesta = $wpdb->query($sql);

        if($respuesta){

            //editar usuario en moodle
            $peticion_md = file_get_contents(getMoodleUrl().'&wsfunction=core_user_update_users&users[0][id]='.$id.'&users[0][firstname]='.$nombre.'&users[0][lastname]='.$apellido.'&users[0][email]='.$email);

            $respuesta_md = json_decode($peticion_md);

        } else {

            echo '<script>alert("Error al editar el colaborador")</script>';
        }

    }

    echo '
       <!-- Modal agregar usuario -->
       <div class="modal fade" id="modal_editar_colaborador" data-bs-backdrop="static" tabindex="-1" >
         <div class="modal-dialog modal-lg modal-dialog-centered">
           <div class="modal-content">
             <div class="modal-header justify-content-center">
               <h5 class="modal-title mb-0">Editar Colaborador</h5>
             </div>
             <div class="modal-body px-5">
                   <div>
                       <form id="editar" method="POST">
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
                                    <input class="form-control" name="usuarioEditar" id="usuarioEditar" type="text" required>
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
                                        <option selected value="MX">México</option>
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