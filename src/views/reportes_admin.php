<?php
require_once plugin_dir_path(__FILE__ ) . '../../settings/enviroment.php';
require_once plugin_dir_path(__FILE__).'../../src/vendor/autoload.php';
require_once plugin_dir_path(__FILE__) . '../../widgets/data_table_dinamic.php';
require_once plugin_dir_path(__FILE__) . '../../src/components/reportes_admin/modal_reporte_curso.php';
require_once plugin_dir_path(__FILE__) . '../../src/components/reportes_admin/modal_reporte_consolidado.php';
require_once plugin_dir_path(__FILE__) . '../../helpers/functions_selects.php';
require_once plugin_dir_path(__FILE__) . '../../helpers/functions_requests.php';


function reportes_admin(){


    global $wpdb;

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
                    <td><img src='".$colaborador_moodle[0]->profileimageurlsmall."' /></td>
                    <td>".$colaborador_moodle[0]->firstname."</td>
                    <td>".$colaborador_moodle[0]->lastname."</td>
                    <td>".$colaborador_moodle[0]->customfields[0]->value."</td>
                    <td>".$colaborador_moodle[0]->email."</td>
                    <td>".$colaborador_moodle[0]->city."</td>

                </tr>";
            }
        }
    }

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
                    <select class="form-select"  name="select_empresa" id="select_empresa" onChange="filterGroups(this,`grupos_get`, `grupos_set`);">
                        <option selected value="0">Seleccione una Empresa</option>'
                           .select_empresas().
        '                   
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
                
                <div class="col-md-1">
                    <br>
                    <button class="btn btn-secondary" value="123" type="submit" name="filtrar" id="button-addon2">Filtrar</button>
                </div>

            </div> 
            </form>
    </div>

    <div class="container mt-5">
        
        <table class="table table-hover order-table border" id="table">
            <thead style="background-color: #041541; color: white;">
                <tr>
                    <th scope="col">Avatar</th>
                    <th scope="col">Nombre </th>
                    <th scope="col">Apellido</th>
                    <th scope="col">Documento</th>
                    <th scope="col">Email</th>
                    <th scope="col">Ciudad</th>   
                    
                </tr>
            </thead>
            <tbody id="personas">
                <!-- Aqui se cargan los datos de la base de datos -->
                '.$colaboradores.'
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
    '.modal_reporte_curso().'


    <!-- Modal Reporte Consolidado -->
    '.modal_reporte_consolidado().'
   

    

<script src='.plugin_dir_url(__FILE__)."../../assets/js/multiselectDropdown.js".' ></script>
<script src='.plugin_dir_url(__FILE__)."../../assets/js/filtersSelects.js".' ></script>
    </body>  ';

    return data_table_dinamic();

}

add_shortcode('reportes_admin', 'reportes_admin');