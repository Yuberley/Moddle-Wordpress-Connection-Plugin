<?php

require_once plugin_dir_path( __FILE__ ) . '../../../settings/enviroment.php';
require_once plugin_dir_path( __FILE__ ) . '../../../helpers/functions_selects.php';

function modal_reporte_curso() {


echo '
<div class="modal fade" id="modal_reporte_curso" data-bs-backdrop="static" tabindex="-1" >
<div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" >Reporte por Curso</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body ">
            <form  method="POST"  action="../reporte-curso" onsubmit="loadingAlertGenerateReport()">
                <div class="mb-3 ">
                    <label for="empresa" class="col-form-label">Empresa</label>
                    <select class="form-select" name="curso_empresa" id="empresas" onChange="filterGroups(this,`grupos_curso_get`,`grupos_curso_set`);">
                        <option selected disabled >Seleccione una empresa</option>
                        '.select_empresas().'
                    </select>
                </div>
                <div class="mb-3 ">
                    <select hidden class="form-select" name="grupos" id="grupos_curso_get">
                        <option selected >Seleccione un grupo</option>
                        '.select_grupos().' 
                    </select>
                    <label  class="col-form-label">Grupos</label>
                    <select class="form-select" name="curso_grupos" id="grupos_curso_set" required onChange="filterCourses(this,`curso_cursos_basic_get`,`curso_cursos_premium_get`,`curso_cursos_set`);">                 

                    </select>
                </div>
                <div class="mb-3">
                    <label  class="col-form-label">Curso:</label>
                    <select name="curso_cursos_basic" id="curso_cursos_basic_get" class="form-select" hidden >
                        '.select_cursos_basic().'
                    </select>
                    
                    <select name="cursos_premium" id="curso_cursos_premium_get" class="form-select" hidden >
                       '.select_cursos_premium().'
                    </select>
                    <select name="curso_cursos" id="curso_cursos_set" class="form-select" required>

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
';


}
