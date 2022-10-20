<?php
require_once plugin_dir_path(__FILE__ ) . '../../settings/enviroment.php';
require_once plugin_dir_path(__FILE__).'../../src/vendor/autoload.php';
require_once plugin_dir_path(__FILE__) . '../../widgets/data_table_dinamic.php';

function reportes_admin(){


    global $wpdb;

    $sql_empresa="SELECT * FROM {$wpdb->prefix}empresas";
    $empresas=$wpdb->get_results($sql_empresa);

    $sql_grupo="SELECT * FROM {$wpdb->prefix}grupos";
    $grupos=$wpdb->get_results($sql_grupo);

   echo '
        <body >
        <div class="container mt-5">
            <div class="row">
                <div class="col-md-8"><h1>REPORTES</h1></div>
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
                        <option selected value="0">Seleccione una Empresa</option>';
                            foreach($empresas as $empresa){
                                echo '<option value="'.$empresa->id.'">'.$empresa->empresa.'</option>';
                            }

        echo '                   
                    </select>
                </div>
                <div class="col-md-3">
                    <select hidden class="form-select" name="select_grupo" id="grupos">';
                            foreach($grupos as $grupo){
                                echo '<option value="'.$grupo->id.'">'.$grupo->nombre.'</option>';
                            }
                        
        echo '                   
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
        
        <table class="table table-hover order-table" id="table">
            <thead class="table-dark">
                <tr>
                    <th scope="col">Grupo</th>
                    <th scope="col">Nombre </th>
                    <th scope="col">Apellido</th>
                    <th scope="col">Documento</th>
                    <th scope="col">Email</th>
                    
                    
                </tr>
            </thead>
            <tbody id="personas">
                <!-- Aqui se cargan los datos de la base de datos -->
                <tr>
                <td>Prime</td>
                <td>Juan Andres</td>
                <td>Perez Garcia</td>
                <td>100.663.773</td>
                <td>juan@gmail.com</td>

                </tr>';


                echo '

                </tbody>
            </table> 
    </div>
    <div class="container mt-5">

    <div class="row">
        <div class="col-md-9">
            <div class="input-group mb-3 d-flex justify-content-end">
                <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#modal_reporte_curso">Reporte por Curso</button>
            </div>
        </div>
        <div class="col-md-3"> 
            <div class="input-group mb-3 d-flex justify-content-end">
                <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#modal_reporte_consolidado">Reporte Consolidado</button>
            </div>
        </div>
    </div>
    </div>


    <!-- Modal Reporte Cursos -->
    <div class="modal fade" id="modal_reporte_curso" data-bs-backdrop="static" tabindex="-1" >
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" >Reporte por Curso</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body ">
            <form>
                    <div class="mb-3">
                        <label for="empresa" class="col-form-label">Empresa</label>
                        <select class="form-select" >
                            <option selected>Seleccione una empresa</option>
                            <option value="1">Bancolombia</option>
                            <option value="2">Nutresa</option>
                            <option value="3">Sasoftco</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="grupo" class="col-form-label">Grupo</label>
                        <select class="form-select" >
                            <option selected>Seleccione un grupo</option>
                            <option value="1">Grupo 02-08-22</option>
                            <option value="2">Grupo 05-07-21</option>
                            <option value="3">Grupo 18-04-20</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label">Curso:</label>
                        <select class="form-select" >
                            <option selected>Seleccione un curso</option>
                            <option value="1">Servicio al Cliente</option>
                            <option value="2">Finanzas Personales</option>
                            <option value="3">Negocios y Emprendimiento</option>
                        </select>
                    </div>
                    <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary" >Generar Reporte</button>
                    </div>
                </form>
            </div>  
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            
            </div>
        </div>
    </div>
    </div>


    <!-- Modal Reporte Consolidado -->
    <div class="modal fade" id="modal_reporte_consolidado" data-bs-backdrop="static" tabindex="-1" >
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" >Reporte por Consolidado</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body ">
            <form>
                    <div class="mb-3">
                        <label for="empresa" class="col-form-label">Empresa</label>
                        <select class="form-select" >
                            <option selected>Seleccione una empresa</option>
                            <option value="1">Bancolombia</option>
                            <option value="2">Nutresa</option>
                            <option value="3">Sasoftco</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="consolidado" class="col-form-label">Grupo</label>
                        <select class="form-select">
                            <option selected>Seleccione un grupo</option>
                            <option value="1">Grupo 02-08-22</option>
                            <option value="2">Grupo 05-07-21</option>
                            <option value="3">Grupo 18-04-20</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label">Curso:</label>
                        <select class="form-select">
                            <option selected>Seleccione un curso</option>
                            <option value="1">Servicio al Cliente</option>
                            <option value="2">Finanzas Personales</option>
                            <option value="3">Negocios y Emprendimiento</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="recipient-name" class="col-form-label">Estudiantes:</label>
                        <select class="form-select" >
                            <option selected>Seleccione los Estudiantes</option>
                            <option value="1">Juan Perez</option>
                            <option value="2">Camilo Roa</option>
                            <option value="3">Daniel Gomez</option>
                        </select>
                    </div>
                    <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary" >Generar Reporte</button>
                    </div>
                </form>
            </div>  
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            
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


    </body>  ';

    return data_table_dinamic();

}

add_shortcode('reportes_admin', 'reportes_admin');