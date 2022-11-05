<?php

require_once plugin_dir_path(__FILE__) . '../../helpers/license_registration.php';

function head(){
    
    licenseRegistration();
    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';

    $response ='
    <head>
    <!-- sweetalert2 -->

    <!-- jquery -->
    <script src="https://code.jquery.com/jquery-3.6.1.slim.min.js" integrity="sha256-w8CvhFs7iHNVUtnSP0YKEg00p9Ih13rlL9zGqvLdePA=" crossorigin="anonymous"></script>


    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>


    <!-- Buscador  -->
    <script type="text/javascript">
        (function(document) {
        "use strict";

        var LightTableFilter = (function(Arr) {

            var _input;

            function _onInputEvent(e) {
            _input = e.target;
            var tables = document.getElementsByClassName(_input.getAttribute("data-table"));
            Arr.forEach.call(tables, function(table) {
                Arr.forEach.call(table.tBodies, function(tbody) {
                Arr.forEach.call(tbody.rows, _filter);
                });
            });
            }

            function _filter(row) {
            var text = row.textContent.toLowerCase(), val = _input.value.toLowerCase();
            row.style.display = text.indexOf(val) === -1 ? "none" : "table-row";
            }

            return {
            init: function() {
                var inputs = document.getElementsByClassName("light-table-filter");
                Arr.forEach.call(inputs, function(input) {
                input.oninput = _onInputEvent;
                });
            }
            };
        })(Array.prototype);

        document.addEventListener("readystatechange", function() {
            if (document.readyState === "complete") {
            LightTableFilter.init();
            }
        });

        })(document);
    </script>


    <!-- DataTables --> 
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>
    
    <script>
    $(document).ready( function () {
        $("#table").DataTable();
    } );
    </script>

    </head>


    ';
    return $response;

}

add_shortcode('head', 'head');