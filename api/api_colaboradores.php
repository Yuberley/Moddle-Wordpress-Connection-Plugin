<?php

function api_colaboradores(){
    register_rest_route(
        'api', 
        '/colaboradores/(?P<id>\d+)', 
        array(
            'methods' => 'GET',
            'callback' => 'get_colaboradores_callback'       
        ));
    }
    
    function get_colaboradores_callback($data){
    global $wpdb;

    $id = $data['id'];
    $sql_colaboradores = "SELECT * FROM {$wpdb->prefix}colaboradores WHERE id_grupo = $id";
    $colaboradores = $wpdb->get_results($sql_colaboradores);

    return $colaboradores;
    

}
add_action('rest_api_init', 'api_colaboradores');