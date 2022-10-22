<?php
require_once plugin_dir_path( __FILE__ ) . '../../../settings/enviroment.php';
require_once plugin_dir_path( __FILE__ ) . '../../../helpers/functions_selects.php';


function modal_reporte_curso() {



echo '
<div class="modal fade" id="modal_reporte_curso" data-bs-backdrop="static" tabindex="-1" >
<div class="modal-dialog ">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" >Reporte por Curso</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body ">
            <form>
                <div class="mb-3 ">
                    <label for="empresa" class="col-form-label">Empresa</label>
                    <select class="form-select" name="empresas" id="empresas" onChange="filterGroups(this);">
                        <option selected value="0">Seleccione una empresa</option>'
                        .select_empresas().
                        '
                    </select>
                </div>
                <div class="mb-3 ">
                    <select hidden class="form-select" name="grupos" id="grupos">
                        '.select_grupos().' 
                    </select>
                    <label  class="col-form-label">Grupos</label>
                    <select class="form-select" name="grupos" id="gruposInsert" required onChange="filterCourses(this);">
                    

                    </select>
                </div>
                <div class="mb-3">
                    <label  class="col-form-label">Curso:</label>
                    <select name="cursos_basic" id="cursos_basic" hidden class="form-select" >
                       '.select_cursos_basic().'
                    </select>
                    
                    <select name="cursos_premium" id="cursos_premium" class="form-select" hidden >
                       '.select_cursos_premium().'
                    </select>
                    <select name="curso" id="cursos_inner" class="form-select" required>

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
