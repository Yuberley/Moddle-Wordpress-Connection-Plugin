<?php

require_once plugin_dir_path(__FILE__) . '../../helpers/license_registration.php';

function head(){
    
    $userLogin = get_current_user_id();
    $userRole = get_userdata($userLogin)->roles[0];
    
    if ($userRole != 'administrator' && $userRole != 'customer') {
        wp_redirect(home_url());
        exit;
    }

    licenseRegistration();

    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';

    $response ='
                <head>
                <!-- flechas input number -->
                <style> input[type=number]::-webkit-outer-spin-button,
                input[type=number]::-webkit-inner-spin-button {-webkit-appearance: none;margin: 0;}
                input[type=number] {-moz-appearance:textfield;}</style>
                <!-- jquery -->
                <script src="https://code.jquery.com/jquery-3.6.1.slim.min.js" integrity="sha256-w8CvhFs7iHNVUtnSP0YKEg00p9Ih13rlL9zGqvLdePA=" crossorigin="anonymous"></script>


                <!-- Bootstrap CSS -->
                <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>


                <!-- DataTables --> 
                <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.12.1/b-2.2.3/b-html5-2.2.3/b-print-2.2.3/datatables.min.css"/>
            
                <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
                <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
                <script type="text/javascript" src="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.12.1/b-2.2.3/b-html5-2.2.3/b-print-2.2.3/datatables.min.js"></script>
                
                
                <script>
                $(document).ready( function () {
                    $("#table").DataTable();
                } );
                </script>

                </head>';

    return $response;

}

add_shortcode('head', 'head');