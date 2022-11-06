<?php
require_once plugin_dir_path(__FILE__ ) . '../../settings/enviroment.php';
require_once plugin_dir_path(__FILE__) . '../../widgets/data_table_dinamic.php';
require_once plugin_dir_path(__FILE__) . '../../helpers/functions_requests.php';
require_once plugin_dir_path(__FILE__) . '../../helpers/functions_tables_report.php';

function reporte_consolidado(){
    global $wpdb;
    $grupo = $_POST['consolidado_grupos'];
    $cursos = $_POST['consolidado_cursos'];
    $estudiantes = $_POST['consolidado_estudiantes'];
    $numero_cursos= count($cursos);
    

    $ID_EMPRESA = "SELECT id_empresa,nombre FROM {$wpdb->prefix}grupos WHERE id = $grupo";
    $ID_EMPRESA = $wpdb->get_results($ID_EMPRESA);
    $NOMBRE_GRUPO = $ID_EMPRESA[0]->nombre;
    $ID_EMPRESA = $ID_EMPRESA[0]->id_empresa;
    
    $EMPRESA = "SELECT empresa FROM {$wpdb->prefix}empresas WHERE id = $ID_EMPRESA";
    $EMPRESA = $wpdb->get_results($EMPRESA);
    $EMPRESA = $EMPRESA[0]->empresa;

    $listEstudiantesId = implode(',', $estudiantes);
    $INFORMACION_ESTUDIANTE_CONSULTA = "SELECT * FROM {$wpdb->prefix}colaboradores WHERE id IN ($listEstudiantesId)";
    $INFORMACION_ESTUDIANTE = $wpdb->get_results($INFORMACION_ESTUDIANTE_CONSULTA);
   
    $body_table='';
    foreach($INFORMACION_ESTUDIANTE as $estudiante){
        $body_table .= '<tr>
                            <td>'.$estudiante->nombre.'</td>
                            <td>'.$estudiante->apellido.'</td>
                            <td>'.$estudiante->documento.'</td>
                            <td>'.$estudiante->email.'</td>';

        $promedio_total = 0;
        foreach($cursos as $curso){
            $calificaciones = getMoodleGradesUser($curso, $estudiante->id);
            $calificaciones = $calificaciones->usergrades;
            $gradeitems = $calificaciones[0]->gradeitems;
            $cantidad_modulos = 0;
            $progreso_curso = 0;
            foreach($gradeitems as $gradeitem){
                if(contiene_evaluacion($gradeitem->itemname)){
                    $cantidad_modulos++;
                    if($gradeitem->gradeformatted != '-'){
                        $progreso_curso += 100;
                    }
                }
            }
            if($cantidad_modulos != 0){
                $progreso_curso = $progreso_curso/$cantidad_modulos;
            }
            
            $promedio_total += $progreso_curso;
            $body_table .= '<td>'.$progreso_curso.'%</td>';
        }
        $promedio_total = $promedio_total/$numero_cursos;
        $body_table .= '<td>'.$promedio_total.'%</td>';
        $body_table .= '</tr>';
    }


    echo '
    
    <body >
        <div class="container mt-5">
   
            <div class="row">
                <div class="col-md-8"><h1>REPORTE CONSOLIDADO 📚</h1></div>
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
                        '.crear_columnas_curso($cursos).'
                        <th scope="col">Promedio</th>
                        
                    </tr>
                </thead>
                <tbody id="personas">
                    <!-- Aqui se cargan los datos de la base de datos -->
                    '.$body_table.'
                </tbody>
            </table> 
        </div>
        <div class="container mt-5">
        

        </div>
        
    </body>   
    
    ';
    
    
    return data_table_dinamic();

}

add_shortcode('reporte_consolidado', 'reporte_consolidado');
