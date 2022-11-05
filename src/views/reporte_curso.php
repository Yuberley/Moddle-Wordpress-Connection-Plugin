<?php
require_once plugin_dir_path(__FILE__ ) . '../../settings/enviroment.php';
require_once plugin_dir_path(__FILE__) . '../../widgets/data_table_dinamic.php';
require_once plugin_dir_path(__FILE__) . '../../helpers/functions_tables_report.php';


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

    //trae el nombre del curso de moodle
    $PETICION_CURSO_NAME = file_get_contents(getMoodleUrl().'&wsfunction=core_course_get_courses_by_field&field=id&value='.$id_curso);
    $NOMBRE_CURSO = json_decode($PETICION_CURSO_NAME);
    $NOMBRE_CURSO = $NOMBRE_CURSO->courses[0]->fullname;

    //peticion para traer las calificaciones de un curso y saber la cantidad de modulos
    $peticion_moodle_calificaciones = file_get_contents(getMoodleUrl().'&wsfunction=gradereport_user_get_grade_items&courseid='.$id_curso);
    $calificaciones = json_decode($peticion_moodle_calificaciones);
    $calificaciones = $calificaciones->usergrades;
    
    $gradeitems = $calificaciones[0]->gradeitems;
    $cantidad_modulos=0;
    foreach($gradeitems as $gradeitem){
        if(contiene_evaluacion($gradeitem->itemname)){
            $cantidad_modulos++;
        }
    }
    
    //colaboradores del grupo
    $peticion_colaboradores = "SELECT id FROM {$wpdb->prefix}colaboradores WHERE id_grupo = '$grupo'";
    $peticion_colaboradores = $wpdb->get_results($peticion_colaboradores);
    $body_table = '';
    foreach($peticion_colaboradores as $peticion_colaborador){
        //obtener calificaciones de cada colaborador
        $peticion_moodle_calificaciones = file_get_contents(getMoodleUrl().'&wsfunction=gradereport_user_get_grade_items&courseid='.$id_curso.'&userid='.$peticion_colaborador->id);
        $calificaciones = json_decode($peticion_moodle_calificaciones);

        $calificaciones = $calificaciones->usergrades;
        $gradeitems = $calificaciones[0]->gradeitems;
        $body_table .= '<tr>';
        $body_table .= '<td>'.$calificaciones[0]->userid.'</td>';
        $body_table .= '<td>'.$calificaciones[0]->userfullname.'</td>';

        foreach($gradeitems as $gradeitem){
            if(contiene_evaluacion($gradeitem->itemname)){
                $body_table .= '<td>'.$gradeitem->gradeformatted.'</td>';
            }
        }

        $body_table .= '</tr>';
    
    }
   
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
                        '.crear_columnas_modulos($cantidad_modulos).'
                        <th scope="col">Progreso</th>
                        
                    </tr>
                </thead>
                <tbody id="personas">
                    <!-- Aqui se cargan los datos de la base de datos -->
                    '.$body_table.'
                   
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