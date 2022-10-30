<?php
require_once plugin_dir_path(__FILE__ ) . '../../settings/enviroment.php';
require_once plugin_dir_path(__FILE__) . '../../widgets/data_table_dinamic.php';

function reporte_consolidado(){
    global $wpdb;
    $grupo = $_POST['consolidado_grupos'];
    $cursos = $_POST['consolidado_cursos'];
    $estudiantes = $_POST['consolidado_estudiantes'];

    $ID_EMPRESA = "SELECT id_empresa,nombre FROM {$wpdb->prefix}grupos WHERE id = '$grupo'";
    $ID_EMPRESA = $wpdb->get_results($ID_EMPRESA);
    $NOMBRE_GRUPO = $ID_EMPRESA[0]->nombre;
    $ID_EMPRESA = $ID_EMPRESA[0]->id_empresa;
    
    $EMPRESA = "SELECT empresa FROM {$wpdb->prefix}empresas WHERE id = '$ID_EMPRESA'";
    $EMPRESA = $wpdb->get_results($EMPRESA);
    $EMPRESA = $EMPRESA[0]->empresa;
   

    // //peticion para traer las calificaciones de un curso
    // $peticion_moodle_calificaciones = file_get_contents(getMoodleUrl().'&wsfunction=gradereport_user_get_grade_items&courseid=8&userid=21');
    // $calificaciones = json_decode($peticion_moodle_calificaciones);
    // var_dump($calificaciones);

    // echo $empresa.' empresas <br>';
    // echo $grupo.' grupos <br>';
    // echo ' var_dump($cursos) <br>';
    // var_dump($cursos);
    // echo "<br>";
    // var_dump($estudiantes);
    // echo ' estudiantes <br>';


    echo '
    
    <body >
        <div class="container mt-5">
   
            <div class="row">
                <div class="col-md-8"><h1>REPORTE CONSOLIDADO</h1></div>
                <br>
            </div>
            <div class="row">
                <section class="float-start" id="">
                       <label class="text-muted">Empresa: </label>
                       <span class="badge bg-dark">'.$EMPRESA.'</span>
                       <label class="ps-2 text-muted">Grupo: </label>
                       <span class="badge bg-dark">'.$NOMBRE_GRUPO.'</span>
               </section>
                </div>
            </div> 
        </div>
        
        <div class="container mt-5">
            
            <table class="table table-hover border" id="table" >
                <thead style="background-color: #041541; color: white;">
                    <tr>
                        <th scope="col">Nombre </th>
                        <th scope="col">Apellido</th>
                        <th scope="col">Documento</th>
                        <th scope="col">Email</th>
                        <th scope="col">Curso 1</th>
                        <th scope="col">Curso 2</th>
                        <th scope="col">Curso 3</th>
                        <th scope="col">Promedio</th>
                        
                    </tr>
                </thead>
                <tbody id="personas">
                    <!-- Aqui se cargan los datos de la base de datos -->
                    <tr>
                    <td>Camilo Esteban</td>
                    <td>Morales Peña</td>
                    <td>100.663.773</td>
                    <td>camilo@gmail.com</td>
                    <td>0%</td>
                    <td>0%</td>
                    <td>0%</td>
                    <td>0%</td>
                    
                    </tr>
                    <tr>
                    <td>Maria Andrea</td>
                    <td>Pinzon Garcia</td>
                    <td>103.004.334</td>
                    <td>armado.posada@gmail.com</td>
                    <td>25%</td>
                    <td>25%</td>
                    <td>25%</td>
                    <td>25%</td>
                    
                    </tr>
                </tbody>
            </table> 
        </div>
        <div class="container mt-5">
        
        <div class="row">
            <div class="col-md-8"><h1></h1></div>
                <div class="col-md-4"> 
                    <div class="input-group mb-3 d-flex justify-content-end">
                    <button type="button" class="btn btn-success">Descargar</button>
                    </div>
                </div>
            </div>
        </div>
        
    </body>   
    
    ';
    
    
    return data_table_dinamic();

}

add_shortcode('reporte_consolidado', 'reporte_consolidado');
