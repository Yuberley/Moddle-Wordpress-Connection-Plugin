<?php

require_once plugin_dir_path( __FILE__ ) . '../../../settings/enviroment.php';

function modal_editar_colaborador(){

    global $wpdb;
    $id = $_POST['id'];
    $sql_colaborador = "SELECT * FROM {$wpdb->prefix}colaboradores WHERE id = '$id'";
    $colaborador = $wpdb->get_results($sql_colaborador);
    $colaborador = $colaborador[0];

    $sql_empresa = "SELECT * FROM {$wpdb->prefix}empresas WHERE id = '$colaborador->id_empresa'";
    $empresa = $wpdb->get_results($sql_empresa);
    $empresa = $empresa[0];

    $sql_grupo = "SELECT * FROM {$wpdb->prefix}grupos WHERE id = '$colaborador->id_grupo'";
    $grupo = $wpdb->get_results($sql_grupo);
    $grupo = $grupo[0];

    $sql_cursos = "SELECT * FROM {$wpdb->prefix}cursos WHERE id_empresa = '$colaborador->id_empresa'";
    $cursos = $wpdb->get_results($sql_cursos);

    $sql_cursos_colaborador = "SELECT * FROM {$wpdb->prefix}cursos_colaborador WHERE id_colaborador = '$id'";
    $cursos_colaborador = $wpdb->get_results($sql_cursos_colaborador);

    $cursos_colaborador_array = array();
    foreach($cursos_colaborador as $curso_colaborador){
        array_push($cursos_colaborador_array, $curso_colaborador->id_curso);
    }

    $cursos_colaborador_array = json_encode($cursos_colaborador_array);

    $sql_cursos_colaborador = "SELECT * FROM {$wpdb->prefix}cursos_colaborador WHERE id_colaborador = '$id'";
    $cursos_colaborador = $wpdb->get_results($sql_cursos_colaborador);

    $cursos_colaborador_array = array();
    foreach($cursos_colaborador as $curso_colaborador){
        array_push($cursos_colaborador_array, $curso_colaborador->id_curso);
    }

    $cursos_colaborador_array = json_encode($cursos_colaborador_array);

    $peticion_moodle = file_get_contents(getMoodleUrl().'&wsfunction=core_user_get_users_by_field&field=email&values[0]='.$colaborador->email.'&moodlewsrestformat=json');

    $respuesta_moodle = json_decode($peticion_moodle);


}