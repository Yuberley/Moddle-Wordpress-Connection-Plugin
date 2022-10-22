<?php

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