<?php
require_once plugin_dir_path(__FILE__) . '../../helpers/license_registration.php';


function license_registration_executable(){
    licenseRegistration();
}

add_shortcode('license_registration_executable', 'license_registration_executable');
    