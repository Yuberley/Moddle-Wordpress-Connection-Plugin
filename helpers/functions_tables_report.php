<?php
require_once plugin_dir_path( __FILE__ ) . '../settings/enviroment.php';

function contiene_evaluacion($palabra){
    if (strpos($palabra, 'Evaluación Módulo') !== false) {       
        return true;
    }elseif (strpos($palabra, 'evaluacion modulo') !== false) {       
            return true;
    }elseif (strpos($palabra, 'Evaluacion Modulo') !== false) {       
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