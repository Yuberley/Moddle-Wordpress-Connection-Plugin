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
                    <select class="select select_custom" multiple multiselect-search="true" multiselect-select-all="true">
                    <option value="1">One</option>
                    <option value="2">Two</option>
                    <option value="3">Three</option>
                    <option value="4">Four</option>
                    <option value="5">Five</option>
                    <option value="6">Six</option>
                    <option value="7">Seven</option>
                    <option value="8">Eight</option>
                </select>

                        <label for="empresa" class="col-form-label">Empresa</label>
                        <select class="form-select" >
                            <option selected>Seleccione una empresa</option>
                           '.select_empresas().'
                        </select>
                    </div>
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



';
}