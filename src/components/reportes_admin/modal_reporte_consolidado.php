<?php
require_once plugin_dir_path( __FILE__ ) . '../../../settings/enviroment.php';
require_once plugin_dir_path( __FILE__ ) . '../../../helpers/functions_selects.php';


function modal_reporte_consolidado(){
    echo '
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
                        <select class="select " multiple multiselect-search="true" multiselect-select-all="true">
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                            <option value="4">Four</option>
                            <option value="5">Five</option>
                            <option value="6">Six</option>
                            <option value="7">Seven</option>
                            <option value="8">Eight</option>
                        </select>
                    </div>

                    <div class="mb-3 ">
                        <label for="empresa" class="col-form-label">Empresa</label>
                        <select class="form-select" name="empresas" id="empresas" onChange="filterGroups(this,`grupos_consolidado_get`,`grupos_consolidado_set`);">
                            <option selected value="0">Seleccione una empresa</option>'
                            .select_empresas().
                            '
                        </select>
                    </div>
                    <div class="mb-3 ">
                        <select hidden class="form-select" name="grupos" id="grupos_consolidado_get">
                            '.select_grupos().' 
                        </select>
                        <label  class="col-form-label">Grupos</label>
                        <select class="form-select" name="grupos" id="grupos_consolidado_set" required onChange="filterCoursesConsolidado(this,`consolidado_cursos_basic_get`,`consolidado_cursos_premium_get`,`consolidado_cursos_set`);">
                        

                        </select>
                    </div>
                    <div class="mb-3">
                        <label  class="col-form-label">Curso:</label>
                        <select name="curso_cursos_basic" id="consolidado_cursos_basic_get" hidden class="form-select" >
                        '.select_cursos_basic().'
                        </select>
                        
                        <select name="cursos_premium" id="consolidado_cursos_premium_get" class="form-select" hidden >
                        '.select_cursos_premium().'
                        </select>
                        <select name="curso" id="consolidado_cursos_set" class="select" multiple multiselect-search="true" multiselect-select-all="true" required>
                        
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="col-form-label">Estudiantes:</label>
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



';
}