<?php

function head(){
    
    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';

    $response ='
    <head>
    <!-- sweetalert2 -->

    <!-- jquery -->
    <script src="https://code.jquery.com/jquery-3.6.1.slim.min.js" integrity="sha256-w8CvhFs7iHNVUtnSP0YKEg00p9Ih13rlL9zGqvLdePA=" crossorigin="anonymous"></script>


    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script type="text/javascript" src="../../../tests/index.js"></script>


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
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.12.1/b-2.2.3/b-html5-2.2.3/b-print-2.2.3/datatables.min.css"/>
 
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.12.1/b-2.2.3/b-html5-2.2.3/b-print-2.2.3/datatables.min.js"></script>
    
    
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