<?php
require_once plugin_dir_path( __FILE__ ) . '../../../settings/enviroment.php';

function modal_agregar_colaborador(){
    
    global $wpdb;
    
    $sql_empresa="SELECT * FROM {$wpdb->prefix}empresas";
    $empresas=$wpdb->get_results($sql_empresa);
    
    $sql_grupo="SELECT * FROM {$wpdb->prefix}grupos";
    $grupos=$wpdb->get_results($sql_grupo);
    
     
    if(isset($_POST['agregar_colaborador'])){
        
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $usuario = strtolower($_POST['usuario']);
        $documento = $_POST['documento'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $edad = $_POST['edad'];
        $ciudad = $_POST['ciudad'];
        $pais = $_POST['pais'];
        $tipo_licencia = $_POST['tipo_licencia'];
        $empresa = $_POST['empresas'];
        $grupo = $_POST['grupos'];
        
        $CANTIDAD_INSCRITOS = "SELECT count(*) FROM wp_colaboradores WHERE id_grupo = '$grupo'";
        $CANTIDAD_INSCRITOS_EN_GRUPO = $wpdb->get_var($CANTIDAD_INSCRITOS);
    
        $CANTIDAD_MAXIMA = "SELECT cantidad_licencia FROM wp_grupos WHERE id = '$grupo'";
        $CANTIDAD_MAXIMA_EN_GRUPO = $wpdb->get_var($CANTIDAD_MAXIMA);
    
        if( $CANTIDAD_INSCRITOS_EN_GRUPO < $CANTIDAD_MAXIMA_EN_GRUPO ){
    
            $sql = "INSERT INTO {$wpdb->prefix}colaboradores (nombre, apellido, email, id_empresa, id_grupo) VALUES ('$nombre', '$apellido', '$email', '$empresa', '$grupo')";
            $respuesta = $wpdb->query($sql);
    
            if($respuesta){
    
                //agregar usuario en moodle
                $peticion_md = file_get_contents(getMoodleUrl().'/webservice/rest/server.php?wstoken='.getMoodleKey().'&moodlewsrestformat=json&wsfunction=core_user_create_users&users[0][username]='.$usuario.'&users[0][firstname]='.$nombre.'&users[0][lastname]='.$apellido.'&users[0][email]='.$email.'&users[0][customfields][0][type]=identification&users[0][customfields][0][value]='.$documento.'&users[0][city]='.$ciudad.'&users[0][country]='.$pais.'&users[0][createpassword]=1');
    
                $respuesta_md = json_decode($peticion_md);
    
            } else {
    
                echo '<script>alert("Error al agregar el colaborador")</script>';
            }
    
        } else {
            
            echo '<script>alert("No se puede agregar el colaborador, se ha alcanzado el limite de licencias")</script>';
    
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
                                    <select class="form-select" name="empresas" id="empresas" onChange="filterGroups(this);">
                                        <option selected value="0">Seleccione una empresa</option>';
                                        foreach($empresas as $empresa){
                                            echo '<option value="'.$empresa->id.'">'.$empresa->empresa.'</option>';
                                        }
                    echo '
                                    </select>
                                </div>
                                <div class="mb-3 col-12 col-sm-6">
                                    <select hidden class="form-select" name="grupos" id="grupos">';
                                        foreach($grupos as $grupo){
                                            echo '<option value="'.$grupo->id.'">'.$grupo->nombre.'</option>';
                                        }

                                       
                    echo '          </select>
                                    <label for="consolidado" class="col-form-label">Grupos</label>
                                    <select class="form-select" name="grupos" id="gruposInsert" required>

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
                                    <input class="form-control" name="usuario" type="text"  required>
                                </div>
                                <div class="mb-3 col-12 col-sm-6">
                                    <label class="form-label" for="documento">Documento</label>
                                    <input class="form-control" name="documento" type="number" id="docimento" required>
                                </div>
                            </section>
                            <div class="mb-3">
                                <label class="form-label" for="email">Email</label>
                                <input class="form-control" name="email" type="email" id="Name" required>
                            </div>
                            <section class="d-flex align-items-center justify-content-center row">
                                <div class="mb-3 col-12 col-sm-6">
                                    <label class="form-label" for="password">Contraseña</label>
                                    <input class="form-control" name="password"  type="password" id="password" required>
                                </div>
                                <div class="mb-3 col-12 col-sm-6">
                                    <label class="form-label" for="edad">Edad</label>
                                    <input class="form-control" name="edad" type="number" id="edad" required>
                                </div>
                            </section>
                            <section class="d-flex align-items-center justify-content-center row">
                                <div class="mb-3 col-12 col-sm-6">
                                    <label class="form-label" for="ciudad">Ciudad</label>
                                    <input class="form-control" name="ciudad" type="text" id="ciudad" required>
                                </div>
                                <div class="mb-3 col-12 col-sm-6">
                                    <label class="form-label" for="pais">Pais</label>
                                    <input class="form-control" name="pais" type="text" id="pais" required>
                                </div>
                            </section>
                            <div class="mb-3 d-flex justify-content-center">
                                <input type="submit" name="agregar_colaborador" value="Agregar Colaborador">
                            </div>
                            <div class="msg"></div>
                       </form>
                   </div>
             </div>
             <div class="modal-footer justify-content-center">
               <button type="button" class="btn btn-secondary"  data-bs-dismiss="modal">Cerrar</button>
             </div>
           </div>
         </div>
       </div>';     

}