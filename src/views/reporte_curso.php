<?php
require_once plugin_dir_path(__FILE__ ) . '../../settings/enviroment.php';
require_once plugin_dir_path(__FILE__) . '../../widgets/data_table_dinamic.php';


function reporte_curso(){
    global $wpdb;
    $grupo = $_POST['curso_grupos'];
    $id_curso = $_POST['curso_cursos'];
    
    $ID_EMPRESA = "SELECT id_empresa,nombre FROM {$wpdb->prefix}grupos WHERE id = '$grupo'";
    $ID_EMPRESA = $wpdb->get_results($ID_EMPRESA);
    $NOMBRE_GRUPO = $ID_EMPRESA[0]->nombre;
    $ID_EMPRESA = $ID_EMPRESA[0]->id_empresa;
    
    $EMPRESA = "SELECT empresa FROM {$wpdb->prefix}empresas WHERE id = '$ID_EMPRESA'";
    $EMPRESA = $wpdb->get_results($EMPRESA);
    $EMPRESA = $EMPRESA[0]->empresa;

    $PETICION_CURSO_NAME = file_get_contents(getMoodleUrl().'&wsfunction=core_course_get_courses_by_field&field=id&value='.$id_curso);
    $NOMBRE_CURSO = json_decode($PETICION_CURSO_NAME);
    $NOMBRE_CURSO = $NOMBRE_CURSO->courses[0]->fullname;
    
    echo '

    <body >
        <div class="container mt-5">
   
            <div class="row">
                <div class="col-md-8"><h1>REPORTES POR CURSO</h1></div>
            </div>
                <br>
               
            <div class="row">
                <div class="col-md-12">
                <section class="float-start" id="">
                    <label class="text-muted">Empresa: </label>
                    <span class="badge bg-dark">'.$EMPRESA.'</span>
                    <label class="ps-2 text-muted">Grupo: </label>
                    <span class="badge bg-dark">'.$NOMBRE_GRUPO.'</span>
                    <label class="ps-2 text-muted">Curso: </label>
                    <span class="badge bg-dark">'.$NOMBRE_CURSO.'</span>
               </section>
                </div>
            </div> 
        </div>
        
        <div class="container mt-5">
            
            <table class="table table-hover border" id="table">
                <thead style="background-color: #041541; color: white;">
                    <tr>
                        <th scope="col">Nombre </th>
                        <th scope="col">Apellido</th>
                        <th scope="col">Documento</th>
                        <th scope="col">Email</th>
                        <th scope="col">Estado</th>
                        <th scope="col">Modulo 1</th>
                        <th scope="col">Modulo 2</th>
                        <th scope="col">Modulo 3</th>
                        <th scope="col">Modulo 4</th>
                        <th scope="col">Progreso</th>
                        
                    </tr>
                </thead>
                <tbody id="personas">
                    <!-- Aqui se cargan los datos de la base de datos -->
                    <tr>
                    <td>Juan Andres</td>
                    <td>Perez Garcia</td>
                    <td>100.663.773</td>
                    <td>juan@gmail.com</td>
                    <td>Iniciado</td>
                    <td>100%</td>
                    <td>100%</td>
                    <td>100%</td>
                    <td>100%</td>
                    <td>100%</td>
                    
                    </tr>
                    <tr>
                    <td>Maria Andrea</td>
                    <td>Pinzon Gomez</td>
                    <td>109.939.123</td>
                    <td>maria@gmail.com</td>
                    <td>Iniciado</td>
                    <td>75%</td>
                    <td>75%</td>
                    <td>75%</td>
                    <td>75%</td>
                    <td>75%</td>
                    
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

add_shortcode('reporte_curso', 'reporte_curso');