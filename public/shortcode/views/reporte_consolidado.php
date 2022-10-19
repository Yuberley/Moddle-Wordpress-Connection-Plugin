<?php

function reporte_consolidado(){

    $response = '
    
    <body >
        <div class="container mt-5">
   
            <div class="row">
                <div class="col-md-8"><h1>REPORTE CONSOLIDADO</h1></div>

            </div>
            <div class="row">
                <div class="col-md-4">
                    <label for="empresa">Empresa: </label>
                    <label for="name-empresa"> Sasoftco </label>
                    <br>
                    <label for="nit">NIT:  </label>
                    <label for="nit">  100.55.353</label>
                </div>
                <div class="col-md-4">
                    <label for="grupo">Grupo: </label>
                    <label for="name-grupo"> Sasoftco 16-09-22 </label>
                </div>
            </div> 
        </div>
        
        <div class="container mt-5">
            
            <table class="table table-hover" id="table" >
                <thead style="background-color: #041541; color: white;">
                    <tr>
                        <th scope="col">Nombre </th>
                        <th scope="col">Apellido</th>
                        <th scope="col">Documento</th>
                        <th scope="col">Email</th>
                        <th scope="col">Curso 1</th>
                        <th scope="col">Curso 2</th>
                        <th scope="col">Curso 3</th>
                        <th scope="col">Promedio</th>
                        
                    </tr>
                </thead>
                <tbody id="personas">
                    <!-- Aqui se cargan los datos de la base de datos -->
                    <tr>
                    <td>Camilo Esteban</td>
                    <td>Morales Peña</td>
                    <td>100.663.773</td>
                    <td>camilo@gmail.com</td>
                    <td>0%</td>
                    <td>0%</td>
                    <td>0%</td>
                    <td>0%</td>
                    
                    </tr>
                    <tr>
                    <td>Maria Andrea</td>
                    <td>Pinzon Garcia</td>
                    <td>103.004.334</td>
                    <td>armado.posada@gmail.com</td>
                    <td>25%</td>
                    <td>25%</td>
                    <td>25%</td>
                    <td>25%</td>
                    
                    </tr>
                    <tr>
                    <td>Teresa Liliana</td>
                    <td>Ramirez Gomez</td>
                    <td>100.454.343</td>
                    <td>teresa.ramirez@gmail.com</td>
                    <td>75%</td>
                    <td>75%</td>
                    <td>75%</td>
                    <td>75%</td>
                    
                    </tr>
                    <tr>
                    <td>Juan Andres</td>
                    <td>Perez Garcia</td>
                    <td>100.663.773</td>
                    <td>juan@gmail.com</td>
                    <td>0%</td>
                    <td>0%</td>
                    <td>0%</td>
                    <td>0%</td>
                    
                    </tr>
                </tbody>
            </table> 
        </div>
        <div class="container mt-5">
        
        <div class="row">
            <div class="col-md-8"><h1></h1></div>
                <div class="col-md-4"> 
                    <div class="input-group mb-3 d-flex justify-content-end">
                    <button type="button" class="btn btn-success">Descargar</button>
                    </div>
                </div>
            </div>
        </div>
        
        <script>
        $("#table").DataTable( {
            language: {
                "search": "Buscar: ",
                "info": "Mostrando del _START_ al _END_ de _TOTAL_ datos",
                "paginate": {
                    "first":      "Primera",
                    "last":       "Ultima",
                    "next":       "Siguiente",
                    "previous":   "Anterior"
                },
                "lengthMenu":     "Mostrando _MENU_ datos",
                "emptyTable":     "No hay datos disponibles en la tabla",
                "zeroRecords":    "No se encontraron datos"
                
            },
            searching: false
        } );
        </script>
    
    </body>   
    
    ';
    
    
    return $response;

}

add_shortcode('reporte_consolidado', 'reporte_consolidado');
