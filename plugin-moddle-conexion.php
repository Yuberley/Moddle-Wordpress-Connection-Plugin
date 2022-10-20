<?php
/**
 *Plugin name: Moddle-Conexion
 * Plugin URI:        https://sasoftco.com/
 * Description:       Conecta la plataforma Moodle con Wordpress.
 * Version:           1.0
 * Requires at least: 5.8
 * Requires PHP:      5.0
 * Author:            Sasoftco 
 * Author URI:        https://sasoftco.com/
 * License:           Derechos Reservados SasoftCo.
 * License URI:       https://sasoftco.com/
 * Text Domain:       sasoftco
*/


define('PATH', plugin_dir_path(__FILE__));


//shorcode Head
require_once PATH."src/views/head.php";
require_once PATH."src/views/colaboradores_usuario.php";
require_once PATH."src/views/colaboradores_admin.php";
require_once PATH."src/views/reportes_usuario.php";
require_once PATH."src/views/reportes_admin.php";
require_once PATH."src/views/reporte_curso.php";
require_once PATH."src/views/reporte_consolidado.php";


//crear tablas en la base de datos al activar el plugin
function ActivarPlugin(){
    
    
    global $wpdb;
    $sql_empresas= "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}empresas(
    `id` INT NOT NULL AUTO_INCREMENT,
    `nombre` VARCHAR(45) NOT NULL,
    `empresa` VARCHAR(100) NULL,
    PRIMARY KEY (`id`));";

    $wpdb->query($sql_empresas);

    $sql_grupos="CREATE TABLE IF NOT EXISTS {$wpdb->prefix}grupos(
    `id` INT NOT NULL AUTO_INCREMENT,
    `nombre` VARCHAR(100) NOT NULL,
    `id_empresa` INT NOT NULL,
    `tipo_licencia` VARCHAR(15) NOT NULL,
    `cantidad_licencia` INT NOT NULL,
    `fecha_inicio` DATE NOT NULL,
    PRIMARY KEY (`id`));";

    $wpdb->query($sql_grupos);

    $sql_colaboradores="CREATE TABLE IF NOT EXISTS {$wpdb->prefix}colaboradores(
    `id` INT NOT NULL AUTO_INCREMENT,
    `nombre` VARCHAR(45) NOT NULL,
    `apellido` VARCHAR(45) NOT NULL,
    `email` VARCHAR(45) NOT NULL UNIQUE,
    `id_empresa` INT NOT NULL,
    `id_grupo` INT NOT NULL,
    PRIMARY KEY (`id`,`email`));";

    $wpdb->query($sql_colaboradores);
}
register_activation_hook(__FILE__, 'ActivarPlugin');
