<?php

require_once plugin_dir_path( __FILE__ ) . '../settings/enviroment.php';

function select_empresas(){
    global $wpdb;
    $opcionesEmpresas = '';
    $sql_empresas = "SELECT * FROM {$wpdb->prefix}empresas";
    $empresas = $wpdb->get_results($sql_empresas);
    foreach($empresas as $empresa){
        $opcionesEmpresas .= '<option value="'.$empresa->id.'">'.$empresa->empresa.'</option>';
    }
    return $opcionesEmpresas;
}
    
function select_grupos(){
    global $wpdb;
    $opcionesGrupos = '';
    $sql_grupos = "SELECT * FROM {$wpdb->prefix}grupos";
    $grupos = $wpdb->get_results($sql_grupos);

    foreach($grupos as $grupo){
        $opcionesGrupos .= '<option value="'.$grupo->id.'">'.$grupo->nombre.'</option>';
    }

    return $opcionesGrupos;
}

function select_cursos_premium(){
  
    $cursos_basic = getMoodleCoursesByCategory( getMoodleCategoryId()['basic'] );
    $cursos_premium = getMoodleCoursesByCategory( getMoodleCategoryId()['premium'] );

    $opcionesCursosPremium = '';
    foreach($cursos_basic->courses as $curso){
        $opcionesCursosPremium .= '<option value="'.$curso->id.'">'.$curso->fullname.'</option>';
    }
    foreach($cursos_premium->courses as $curso){
        $opcionesCursosPremium .= '<option value="'.$curso->id.'">'.$curso->fullname.'</option>';
    }

    return $opcionesCursosPremium;
    
}

function select_cursos_basic(){

    $cursos_basic = getMoodleCoursesByCategory( getMoodleCategoryId()['basic'] );

    $opcionesCursosBasic = '';
    foreach($cursos_basic->courses as $curso){
        $opcionesCursosBasic .= '<option value="'.$curso->id.'">'.$curso->fullname.'</option>';
    }

    return $opcionesCursosBasic;

}

function select_grupos_usuarios($empresaId){
        
    global $wpdb;
    $opcionesGruposUsuarios = '';
    $sql_grupos_usuarios = "SELECT * FROM {$wpdb->prefix}grupos WHERE id_empresa = $empresaId";
    $grupos_usuarios = $wpdb->get_results($sql_grupos_usuarios);
    
    foreach($grupos_usuarios as $grupo_usuario){
        $opcionesGruposUsuarios .= '<option value="'.$grupo_usuario->id.'">'.$grupo_usuario->nombre.'</option>';
    }

    return $opcionesGruposUsuarios;
}
