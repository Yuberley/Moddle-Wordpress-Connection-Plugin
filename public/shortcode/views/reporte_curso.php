<?php

function reporte_curso(){

    $response= '
    

    <body >
        <div class="container mt-5">
   
            <div class="row">
                <div class="col-md-8"><h1>REPORTES POR CURSO</h1></div>
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
                    <br>
                    <label for="curso">Curso: </label>
                    <label for="name-curso">  Servicio al Cliente </label>
                </div>
            </div> 
        </div>
        
        <div class="container mt-5">
            
            <table class="table table-hover" id="table">
                <thead style="background-color: #041541; color: white;">
                    <tr>
                        <th scope="col">Nombre </th>
                        <th scope="col">Apellido</th>
                        <th scope="col">Documento</th>
                        <th scope="col">Email</th>
                        <th scope="col">Estado</th>
                        <th scope="col">Modulo 1</th>
                        <th scope="col">Modulo 2</th>
                        <th scope="col">Modulo 3</th>
                        <th scope="col">Modulo 4</th>
                        <th scope="col">Progreso</th>
                        
                    </tr>
                </thead>
                <tbody id="personas">
                    <!-- Aqui se cargan los datos de la base de datos -->
                    <tr>
                    <td>Juan Andres</td>
                    <td>Perez Garcia</td>
                    <td>100.663.773</td>
                    <td>juan@gmail.com</td>
                    <td>Iniciado</td>
                    <td>100%</td>
                    <td>100%</td>
                    <td>100%</td>
                    <td>100%</td>
                    <td>100%</td>
                    
                    </tr>
                    <tr>
                    <td>Maria Andrea</td>
                    <td>Pinzon Gomez</td>
                    <td>109.939.123</td>
                    <td>maria@gmail.com</td>
                    <td>Iniciado</td>
                    <td>75%</td>
                    <td>75%</td>
                    <td>75%</td>
                    <td>75%</td>
                    <td>75%</td>
                    
                    </tr>
                    <tr>
                    <td>Camilo Mario</td>
                    <td>Garcia Peña</td>
                    <td>100.454.343</td>
                    <td>camilo@gmail.com</td>
                    <td>Iniciado</td>
                    <td>25%</td>
                    <td>25%</td>
                    <td>25%</td>
                    <td>25%</td>
                    <td>25%</td>
                    
                    </tr>
                    <tr>
                    <td>Armando Enrique</td>
                    <td>Posada Rocha</td>
                    <td>103.004.334</td>
                    <td>armado.posada@gmail.com</td>
                    <td>Iniciado</td>
                    <td>25%</td>
                    <td>25%</td>
                    <td>25%</td>
                    <td>25%</td>
                    <td>25%</td>
                    
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

add_shortcode('reporte_curso', 'reporte_curso');