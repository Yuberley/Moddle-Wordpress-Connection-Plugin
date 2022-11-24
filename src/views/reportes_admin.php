<?php
require_once plugin_dir_path(__FILE__ ) . '../../settings/enviroment.php';
require_once plugin_dir_path(__FILE__) . '../../widgets/data_table_dinamic.php';
require_once plugin_dir_path(__FILE__) . '../../src/components/reportes_admin/modal_reporte_curso.php';
require_once plugin_dir_path(__FILE__) . '../../src/components/reportes_admin/modal_reporte_consolidado.php';
require_once plugin_dir_path(__FILE__) . '../../helpers/functions_selects.php';
require_once plugin_dir_path(__FILE__) . '../../helpers/functions_requests.php';


function reportes_admin(){

    $userLogin = get_current_user_id();
    $userRole = get_userdata($userLogin)->roles[0];

    if ($userRole == 'customer') {
        wp_redirect('/reportes-usuario/');
        exit;
    }


    global $wpdb;
    $EMPRESA = 'Sin seleccionar';
    $GRUPO = 'Sin seleccionar';
    $colaboradores = "";

    if (isset($_POST['filtrar'])){
        $empresaId = $_POST['select_empresa'];
        $grupoId = $_POST['gruposInner'];
        
        $EMPRESA = "SELECT empresa FROM {$wpdb->prefix}empresas WHERE id = '$empresaId'";
        $EMPRESA = $wpdb->get_results($EMPRESA);
        $EMPRESA = $EMPRESA[0]->empresa;
        $GRUPO = "SELECT nombre FROM {$wpdb->prefix}grupos WHERE id = '$grupoId'";
        $GRUPO = $wpdb->get_results($GRUPO);
        $GRUPO = $GRUPO[0]->nombre;


        $SQL_COLABORADORES = "SELECT id,email FROM {$wpdb->prefix}colaboradores WHERE id_empresa = '$empresaId' AND id_grupo = '$grupoId'";
        $WP_COLABORADORES = $wpdb->get_results($SQL_COLABORADORES);

        $colaboradores_moodle = [];

        if (count($WP_COLABORADORES) > 0){
            $colaboradores_moodle = getMoodleUsersByField('id', $WP_COLABORADORES);
        }
    
        foreach($colaboradores_moodle as $colaborador){
                         
                
            $colaboradores .= "
            <tr>
                <td><img src='".$colaborador->profileimageurlsmall."' /></td>
                <td>".$colaborador->firstname."</td>
                <td>".$colaborador->lastname."</td>
                <td>".$colaborador->customfields[0]->value."</td>
                <td>".$colaborador->email."</td>
                <td>".$colaborador->city."</td>

            </tr>";
            
        }
    }

   echo '
        <body >
        <div class="container mt-5">
            <div class="border-bottom mb-4">
                <div class="row">
                    <div class="col-md-8"><h1>REPORTES 📂</h1></div>
                    <div class="col-md-4">
                        <div class="d-flex justify-content-end">
                            <a href="'.get_site_url().'/colaboradores-admin/">
                                <button class="btn btn-outline-dark" >👥 Ir a colaboradores</button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <form method="POST">
            <div class="row">
                <div class="col-md-4 pt-3 d-flex align-items-center"> 
                    <section class="float-start" id="cantidad_licencias">
                        <label class="text-muted">Empresa: </label>
                        <span class="badge bg-dark">'.$EMPRESA.'</span>
                        <label class="ps-2 text-muted">Grupo: </label>
                        <span class="badge bg-dark">'.$GRUPO.'</span>
                    </section>
                </div>
                <div class="col-md-1"></div>
                <div class="col-md-3">
                    <label for="empresa">Empresas: </label>
                    <select class="form-select"  name="select_empresa" id="select_empresa" onChange="filterGroups(this,`grupos_get`, `grupos_set`);">
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
                
                <div class="col-md-1">
                    <br>
                    <button class="btn btn-secondary" value="123" type="submit" name="filtrar" id="button-addon2">Filtrar</button>
                </div>

            </div>
            <div class="row">
                <div class="col-md-5"></div>
                <div class="col-md-7 mt-2 d-flex justify-content-center">                                    
                    <span class="badge bg-light text-dark">Para obtener información sobre tus colaboradores primero debes filtrar </span>                                  
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
   

    <script src='.plugin_dir_url(__FILE__)."../../assets/js/filtersSelects.js".' ></script>
    </body>  

    <script src='.plugin_dir_url(__FILE__)."../../assets/js/loadingAlert.js".' ></script>
    </body>  ';
    
    return data_table_dinamic();

}

add_shortcode('reportes_admin', 'reportes_admin');