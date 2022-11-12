<?php
require_once plugin_dir_path(__FILE__ ) . '../../settings/enviroment.php';
require_once plugin_dir_path(__FILE__) . '../../widgets/data_table_dinamic.php';
require_once plugin_dir_path(__FILE__) . '../../helpers/functions_tables_report.php';
require_once plugin_dir_path(__FILE__) . '../../helpers/functions_requests.php';


function reporte_curso(){

    global $wpdb;
    $grupo=0;
    $grupo = $_POST['curso_grupos'];
    $id_curso = $_POST['curso_cursos'];
    
    $ID_EMPRESA = "SELECT id_empresa,nombre FROM {$wpdb->prefix}grupos WHERE id = '$grupo'";
    $ID_EMPRESA = $wpdb->get_results($ID_EMPRESA);
    $NOMBRE_GRUPO = $ID_EMPRESA[0]->nombre;
    $ID_EMPRESA = $ID_EMPRESA[0]->id_empresa;
    
    $EMPRESA = "SELECT empresa FROM {$wpdb->prefix}empresas WHERE id = '$ID_EMPRESA'";
    $EMPRESA = $wpdb->get_results($EMPRESA);
    $EMPRESA = $EMPRESA[0]->empresa;


    $NOMBRE_CURSO = getMoodleCourse($id_curso);
    $NOMBRE_CURSO = $NOMBRE_CURSO[0]->fullname;

    //peticion para traer las calificaciones de un curso y saber la cantidad de modulos
    $calificaciones = getMoodleGradesCourse($id_curso);
    $calificaciones = $calificaciones->usergrades;
    
    $gradeitems = $calificaciones[0]->gradeitems;
    $cantidad_modulos=0;
    if($calificaciones!=null){
        foreach($gradeitems as $gradeitem){
            if(contiene_evaluacion($gradeitem->itemname)){
                $cantidad_modulos++;
            }
        }}
    
    //colaboradores del grupo
    $PETICION_COLABORADORES = "SELECT * FROM {$wpdb->prefix}colaboradores WHERE id_grupo = '$grupo'";
    $PETICION_COLABORADORES = $wpdb->get_results($PETICION_COLABORADORES);
    $body_table = '';
    foreach($PETICION_COLABORADORES as $PETICION_COLABORADOR){

        $calificaciones = getMoodleGradesUser($id_curso,$PETICION_COLABORADOR->id);

        $calificaciones = $calificaciones->usergrades;
        $gradeitems = $calificaciones[0]->gradeitems;
        $body_table .= '<tr>';
        $body_table .= '<td>'.$PETICION_COLABORADOR->nombre.'</td>';
        $body_table .= '<td>'.$PETICION_COLABORADOR->apellido.'</td>';
        $body_table .= '<td>'.$PETICION_COLABORADOR->documento.'</td>';
        $body_table .= '<td>'.$PETICION_COLABORADOR->email.'</td>';

        if($cantidad_modulos!=0){
            
            //calificaciones de modulos
            $calificacion_modulos=100*$cantidad_modulos;
            $progreso_curso=0;
            foreach($gradeitems as $gradeitem){
                if(contiene_evaluacion($gradeitem->itemname)){
                    
                    if($gradeitem->gradeformatted == '-'){
                        $body_table .= '<td>0%</td>';
                    }else{
                        $body_table .= '<td>100%</td>';
                        $progreso_curso += 100;
                    }
                }   }
                
                $body_table .= '<td>'.$progreso_curso/$cantidad_modulos.'%</td>';
                //estado del curso
                if($progreso_curso == 0){
                    $body_table .= '<td> <span class="badge rounded-pill bg-secondary">Sin iniciar</span> </td>';}
                else if($progreso_curso == $calificacion_modulos){
                    $body_table .= '<td> <span class="badge rounded-pill bg-success">Finalizado</span> </td>';}
                else{
                    $body_table .= '<td> <span class="badge rounded-pill bg-primary">En Curso</span> </td>';
                }
                $body_table .= '</tr>';
        }else{
            $body_table .= '<td>0%</td>';
            $body_table .= '<td>No hay Modulos</td>';
            $body_table .= '</tr>';
        }
    }
   
    echo '

    <body >
        <div class="container mt-5">
            <div class="border-bottom mb-4">
                <div class="row">
                    <div class="col-md-8"><h1>REPORTES POR CURSO 📘</h1></div>
                    <div class="col-md-4">
                        <div class="d-flex justify-content-end">
                            <a href="javascript:history.back()">
                                <button class="btn btn-outline-dark" >🔙 Volver</button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
               
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
                        '.crear_columnas_modulos($cantidad_modulos).'
                        <th scope="col">Progreso</th>
                        <th scope="col">Estado</th>
                        
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

add_shortcode('reporte_curso', 'reporte_curso');