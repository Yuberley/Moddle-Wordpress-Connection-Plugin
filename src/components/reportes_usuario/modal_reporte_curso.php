<?php

require_once plugin_dir_path( __FILE__ ) . '../../../settings/enviroment.php';
require_once plugin_dir_path( __FILE__ ) . '../../../helpers/functions_selects.php';

function modal_reporte_curso_usuario($empresaId) {


echo '
<div class="modal fade" id="modal_reporte_curso" data-bs-backdrop="static" tabindex="-1" >
<div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" >Reporte por Curso</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body ">
            <form  method="POST"  action="../reporte-curso">

                <div class="mb-3 ">
                    <label  class="col-form-label">Grupos</label>
                    <select class="form-select" name="curso_grupos" id="grupos_curso_set" required onChange="filterCourses(this,`curso_cursos_basic_get`,`curso_cursos_premium_get`,`curso_cursos_set`);">
                        <option selected disabled >Seleccione un grupo</option>               
                        '.select_grupos_usuarios($empresaId).'
                    </select>
                </div>
                <div class="mb-3">
                    <label  class="col-form-label">Curso:</label>
                    <select name="curso_cursos_basic" id="curso_cursos_basic_get" hidden class="form-select" >
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
