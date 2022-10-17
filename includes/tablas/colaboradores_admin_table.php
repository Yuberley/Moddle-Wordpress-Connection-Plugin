<?php
require_once plugin_dir_path( __FILE__ ) . '../../settings/enviroment.php';

function tabla_superior(){
    global $wpdb;

    $sql_empresa="SELECT * FROM {$wpdb->prefix}empresas";
    $empresas=$wpdb->get_results($sql_empresa);

    $sql_grupo="SELECT * FROM {$wpdb->prefix}grupos";
    $grupos=$wpdb->get_results($sql_grupo);

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
                   <select class="form-select"  name="select_empresa" id="select_empresa">
                    <option selected value="0">Seleccione una Empresa</option>';
                        foreach($empresas as $empresa){
                            echo '<option value="'.$empresa->id.'">'.$empresa->empresa.'</option>';
                        }

    echo '                   
                   </select>
               </div>
               <div class="col-md-3">
                   <label for="grupos">Grupos: </label>
                   <select class="form-select" name="select_grupo">
                    <option selected value="0">Seleccione un Grupo</option>';
                        foreach($grupos as $grupo){
                            echo '<option value="'.$grupo->id.'">'.$grupo->nombre.'</option>';
                        }
                      
    echo '                   
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
           
           <table class="table order-table table-hover " id="table" >
               <thead class="table-dark">
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
   '; 

}

function tabla_inferior(){
    global $wpdb;

    $sql_empresa="SELECT * FROM {$wpdb->prefix}empresas";
    $empresas=$wpdb->get_results($sql_empresa);

    $sql_grupo="SELECT * FROM {$wpdb->prefix}grupos";
    $grupos=$wpdb->get_results($sql_grupo);

    if(isset($_POST['agregar_colaborador'])){

        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $usuario = $_POST['usuario'];
        $documento = $_POST['documento'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $edad = $_POST['edad'];
        $ciudad = $_POST['ciudad'];
        $pais = $_POST['pais'];
        $tipo_licencia = $_POST['tipo_licencia'];
        $empresa = $_POST['empresa'];
        $grupo = $_POST['grupo'];

        
        $sql="INSERT INTO {$wpdb->prefix}colaboradores (nombre,apellido,email,id_empresa,id_grupo)  VALUES('$nombre', '$apellido',  '$email', '$empresa', '$grupo')";
        $respuesta=$wpdb->query($sql);
        
        if($respuesta){
            //agregar usuario en moodle
            $peticion_md = file_get_contents(getMoodleUrl().'/webservice/rest/server.php?wstoken='.getMoodleKey().'&moodlewsrestformat=json&wsfunction=core_user_create_users&users[0][username]='.$usuario.'&users[0][firstname]='.$nombre.'&users[0][lastname]='.$apellido.'&users[0][email]='.$email.'&users[0][customfields][0][type]=identification&users[0][customfields][0][value]='.$documento.'&users[0][city]='.$ciudad.'&users[0][country]='.$pais.'&users[0][createpassword]=1');
            

            $respuesta_md = json_decode($peticion_md);
            var_dump($respuesta_md);}
          else{
            echo '<script>alert("Error al agregar el colaborador")</script>';}
        
       }
       
    echo '

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
                                    <label for="consolidado" class="col-form-label">Grupo</label>
                                    <select class="form-select" name="gruposInner" id="gruposInner" required>

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
                            <div class="mb-3">
                            <label class="form-label" for="pais">Tipo de Licencia: </label>
                            <label class="form-label" for="pais">Basic </label>
                            </div>
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
       </div>

      <script>
            
            let grupos = document.getElementById("grupos");

            function filterGroups(event){
                console.log(event.options[event.selectedIndex].text);

                let options_grupos = "";
                for(let i = 0; i < grupos.options.length; i++){
                    if(grupos.options[i].text.includes(event.options[event.selectedIndex].text)){
                        options_grupos += "<option value="+grupos.options[i].value+">"+grupos.options[i].text+"</option>";
                    }
                }
                document.getElementById("gruposInner").innerHTML = options_grupos;
                console.log("data ", options_grupos);
            }

         </script>
 
   </body>'; 



}