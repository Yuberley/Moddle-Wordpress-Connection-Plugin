<?php
require_once plugin_dir_path(__FILE__ ) . '../../settings/enviroment.php';
require_once plugin_dir_path(__FILE__).'../../src/vendor/autoload.php';
require_once plugin_dir_path(__FILE__) . '../../widgets/data_table_dinamic.php';
require_once plugin_dir_path(__FILE__) . '../../src/components/reportes_admin/modal_reporte_curso.php';
require_once plugin_dir_path(__FILE__) . '../../src/components/reportes_admin/modal_reporte_consolidado.php';
require_once plugin_dir_path(__FILE__) . '../../helpers/functions_selects.php';


function reportes_admin(){


    global $wpdb;



   echo '
        <body >
        <div class="container mt-5">
            <div class="row">
                <div class="col-md-8"><h1>REPORTES</h1></div>
            </div>
            <form method="POST">
            <div class="row">
                <div class="col-md-4"> 
                    <br>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control light-table-filter" data-table="order-table" placeholder="Buscar Colaborador">
                    </div>
                </div>
                <div class="col-md-1"></div>
                <div class="col-md-3">
                    <label for="empresa">Empresas: </label>
                    <select class="form-select"  name="select_empresa" id="select_empresa" onChange="filterGroups(this);">
                        <option selected value="0">Seleccione una Empresa</option>'
                           .select_empresas().
        '                   
                    </select>
                </div>
                <div class="col-md-3">
                       <select hidden class="form-select" name="select_grupo" id="grupos">
                            '.select_grupos().'            
                       </select>
                       <label for="grupos">Grupos: </label>
                        <select class="form-select" name="gruposInner" id="gruposInner" required>
    
                        </select>
                </div>
                
                <div class="col-md-1">
                    <br>
                    <button class="btn btn-secondary" value="123" type="submit" name="filtrar" id="button-addon2">Filtrar</button>
                </div>

            </div> 
            </form>
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
                <td>Prime</td>
                <td>Juan Andres</td>
                <td>Perez Garcia</td>
                <td>100.663.773</td>
                <td>juan@gmail.com</td>

                </tr>';


                echo '

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
    '.modal_reporte_curso().'


    <!-- Modal Reporte Consolidado -->
    '.modal_reporte_consolidado().'
   

    
 <script>
    let grupos = document.getElementById("grupos");
    function filterGroups(event){

        let options_grupos = "";
        for(let i = 0; i < grupos.options.length; i++){
            if(grupos.options[i].text.includes(event.options[event.selectedIndex].text)){
                options_grupos += "<option value="+grupos.options[i].value+">"+grupos.options[i].text+"</option>";
            }
        }
        document.getElementById("gruposInner").innerHTML = options_grupos;
        document.getElementById("gruposInsert").innerHTML = options_grupos;
        
    }

</script>


    </body>  ';

    return data_table_dinamic();

}

add_shortcode('reportes_admin', 'reportes_admin');