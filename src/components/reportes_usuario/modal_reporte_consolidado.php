<?php
require_once plugin_dir_path( __FILE__ ) . '../../../settings/enviroment.php';
require_once plugin_dir_path( __FILE__ ) . '../../../helpers/functions_selects.php';


function modal_reporte_consolidado_usuario($empresaId){
    echo '
    <div class="modal fade" id="modal_reporte_consolidado" data-bs-backdrop="static" tabindex="-1" >
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" >Reporte por Consolidado</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body ">

       
            <form method="POST" id="form_reporte_consolidado" action="../reporte-consolidado" onsubmit="loadingAlertGenerateReport()">

                    <div class="mb-3 ">
                        <label  class="col-form-label">Grupos: </label>
                        <select class="form-select" name="consolidado_grupos" id="consolidado_grupos_set" required onChange="filterCourses(this,`consolidado_cursos_basic_get`,`consolidado_cursos_premium_get`,`consolidado_cursos_set`);">
                            <option value="" selected disabled>Seleccione un grupo</option>
                            '.select_grupos_usuarios($empresaId).'
                        </select>
                    </div>
                    <div class="mb-3">
                         <div>
                            <label class="" >Cursos: </label>
                            <span class="badge rounded-pill bg-light text-dark float-end">Presione Ctrl o Shift para selección múltiple</span>
                        </div>
                        <select name="curso_cursos_basic" id="consolidado_cursos_basic_get" class="select form-control" multiple hidden>
                        '.select_cursos_basic().'
                        </select>
                        
                        <select name="curso_cursos_premium" id="consolidado_cursos_premium_get" class="select form-control" multiple hidden>
                        '.select_cursos_premium().'
                        </select>
                        <select  name="consolidado_cursos[]" id="consolidado_cursos_set" class="select form-control" multiple required>
                        
                        </select>
                        <div class="form-check form-switch">
                            <span class="float-start">Selecionar todos</<span>
                            <input class="form-check-input" id="selectAllCourses" type="checkbox" id="flexSwitchCheckDefault">
                        </div>
                    </div>
                    <div class="mb-3">
                        <div>
                            <label id="consolidado_estudiantes">Estudiantes:</label>
                            <span class="badge rounded-pill bg-light text-dark float-end">Presione Ctrl o Shift para selección múltiple</span>
                        </div>
                        <select class="select form-control" name="consolidado_estudiantes[]" id="consolidado_colaboradores_set" multiple data-select="false" required>
                        
                        </select>
                        <div class="form-check form-switch">
                            <span class="float-start">Selecionar todos</<span>
                            <input class="form-check-input" id="selectAllStudents" type="checkbox" id="flexSwitchCheckDefault">
                        </div>
                    </div>
                    <div class="d-flex justify-content-center" id="reporte_consolidado_button">
                        <button type="submit" class="btn btn-primary" value="form_consolidado" >Generar Reporte</button>
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