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
        $peticion_moodle_cursos_basic= file_get_contents(getMoodleUrl().'&wsfunction=core_course_get_courses_by_field&field=category&value='.getMoodleCategoryId()['basic']);
        $peticion_moodle_cursos_premium = file_get_contents(getMoodleUrl().'&wsfunction=core_course_get_courses_by_field&field=category&value='.getMoodleCategoryId()['premium']);
        $cursos_basic = json_decode($peticion_moodle_cursos_basic);
        $cursos_premium = json_decode($peticion_moodle_cursos_premium);
   
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
        $peticion_moodle_cursos_basic= file_get_contents(getMoodleUrl().'&wsfunction=core_course_get_courses_by_field&field=category&value='.getMoodleCategoryId()['basic']);

        $cursos_basic = json_decode($peticion_moodle_cursos_basic);
   
        $opcionesCursosBasic = '';
        foreach($cursos_basic->courses as $curso){
            $opcionesCursosBasic .= '<option value="'.$curso->id.'">'.$curso->fullname.'</option>';
        }

        return $opcionesCursosBasic;

    }