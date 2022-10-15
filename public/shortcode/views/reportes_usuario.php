<?php

function reportes_usuario(){

    $response= '

    <body >
        <div class="container mt-5">
   
            <div class="row">
                <div class="col-md-8"><h1>REPORTES</h1></div>
                <div class="col-md-4"> 
                    <div class="input-group mb-3">
                    <input type="text" class="form-control light-table-filter" data-table="order-table" placeholder="Buscar Reporte">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <label for="empresa">Empresa: </label>
                    <label for="name-empresa"> Sasoftco </label>
                </div>

            </div> 
        </div>
        
        <div class="container mt-5">
            
            <table class="table table-hover order-table" id="table">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">Grupo</th>
                        <th scope="col">Nombre </th>
                        <th scope="col">Apellido</th>
                        <th scope="col">Documento</th>
                        <th scope="col">Email</th>
                        
                        
                    </tr>
                </thead>
                <tbody id="personas">
                    <!-- Aqui se cargan los datos de la base de datos -->
                    <tr>
                    <td>Prime 02-20-22</td>
                    <td>Juan Andres</td>
                    <td>Perez Garcia</td>
                    <td>100.663.773</td>
                    <td>juan@gmail.com</td>

                    </tr>
                    <tr>
                    <td>Sasoftco 03-15-22</td>
                    <td>Camilo Mario</td>
                    <td>Garcia Peña</td>
                    <td>100.454.343</td>
                    <td>camilo@gmail.com</td>

                    </tr>
                    <tr>
                    <td>Prime 02-20-22</td>
                    <td>Maria Andrea</td>
                    <td>Pinzon Gomez</td>
                    <td>109.939.123</td>
                    <td>maria@gmail.com</td>

                    </tr>
                    <tr>
                    <td>Sasoftco 03-15-22</td>
                    <td>Armando Enrique</td>
                    <td>Posada Rocha</td>
                    <td>103.004.334</td>
                    <td>armado.rocha.posada@gmail.com</td>

                    </tr>
                </tbody>
            </table> 
        </div>
        <div class="container mt-5">
        
            <div class="row">
                <div class="col-md-9">
                    <div class="input-group mb-3 d-flex justify-content-end">
                        <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#modal_reporte_curso">Reporte por Curso</button>
                    </div>
                </div>
                <div class="col-md-3"> 
                    <div class="input-group mb-3 d-flex justify-content-end">
                        <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#modal_reporte_consolidado">Reporte Consolidado</button>
                    </div>
                </div>
            </div>
        </div>
        

        <!-- Modal Reporte Cursos -->
        <div class="modal fade" id="modal_reporte_curso" data-bs-backdrop="static" tabindex="-1" >
            <div class="modal-dialog ">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" >Reporte por Curso</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body ">
                    <form>
                            <div class="mb-3">
                                <label for="cursos" class="col-form-label">Grupo</label>
                                <select class="form-select" aria-label="Default select example">
                                    <option selected>Seleccione un grupo</option>
                                    <option value="1">Grupo 02-08-22</option>
                                    <option value="2">Grupo 05-07-21</option>
                                    <option value="3">Grupo 18-04-20</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="recipient-name" class="col-form-label">Curso:</label>
                                <select class="form-select" aria-label="Default select example">
                                    <option selected>Seleccione un curso</option>
                                    <option value="1">Servicio al Cliente</option>
                                    <option value="2">Finanzas Personales</option>
                                    <option value="3">Negocios y Emprendimiento</option>
                                </select>
                            </div>
                            <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary" >Generar Reporte</button>
                            </div>
                        </form>
                    </div>  
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    
                    </div>
                </div>
            </div>
        </div>


        <!-- Modal Reporte Consolidado -->
        <div class="modal fade" id="modal_reporte_consolidado" data-bs-backdrop="static" tabindex="-1" >
            <div class="modal-dialog ">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" >Reporte por Consolidado</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body ">
                    <form>
                            <div class="mb-3">
                                <label for="consolidado" class="col-form-label">Grupo</label>
                                <select class="form-select">
                                    <option selected>Seleccione un grupo</option>
                                    <option value="1">Grupo 02-08-22</option>
                                    <option value="2">Grupo 05-07-21</option>
                                    <option value="3">Grupo 18-04-20</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="recipient-name" class="col-form-label">Curso:</label>
                                <select class="form-select">
                                    <option selected>Seleccione un curso</option>
                                    <option value="1">Servicio al Cliente</option>
                                    <option value="2">Finanzas Personales</option>
                                    <option value="3">Negocios y Emprendimiento</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="recipient-name" class="col-form-label">Estudiantes:</label>
                                <select class="form-select" >
                                    <option selected>Seleccione los Estudiantes</option>
                                    <option value="1">Juan Perez</option>
                                    <option value="2">Camilo Roa</option>
                                    <option value="3">Daniel Gomez</option>
                                </select>
                            </div>
                            <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary" >Generar Reporte</button>
                            </div>
                        </form>
                    </div>  
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    
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

add_shortcode('reportes_usuario', 'reportes_usuario');