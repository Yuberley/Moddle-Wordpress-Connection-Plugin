<?php
require_once plugin_dir_path( __FILE__ ) . '../settings/enviroment.php';
require_once plugin_dir_path(__FILE__ ) . 'functions_requests.php';

function contiene_evaluacion($palabra){
    
    if (strpos($palabra, 'Evaluación Módulo') !== false) {       
        return true;
    }
    if (strpos($palabra, 'evaluacion modulo') !== false) {       
            return true;
    }
    if (strpos($palabra, 'Evaluacion Modulo') !== false) {       
            return true;
    }
    if (strpos($palabra, 'EVALUACIÓN MÓDULO') !== false) {       
        return true;
    }
    if (strpos($palabra, 'EVALUACION MODULO') !== false) {       
        return true;
    }

    return false;
}

function crear_columnas_modulos($cantidad_modulos){
    $columnas = '';
    for($i=1;$i<=$cantidad_modulos;$i++){
        $columnas .= '<th scope="col">Modulo '.$i.'</th>';
    }
    return $columnas;
}

function crear_columnas_curso($cursos){
    $columnas = '';
    foreach($cursos as $curso){
        $NOMBRE_CURSO = getMoodleCourse($curso);
        $columnas .= '<th scope="col">'.$NOMBRE_CURSO[0]->fullname.'</th>';
    }
    return $columnas;
}