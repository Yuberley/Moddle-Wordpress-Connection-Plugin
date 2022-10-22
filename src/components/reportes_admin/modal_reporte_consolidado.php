<?php

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
                        <label for="empresa" class="col-form-label">Empresa</label>
                        <select class="form-select" >
                            <option selected>Seleccione una empresa</option>
                            <option value="1">Bancolombia</option>
                            <option value="2">Nutresa</option>
                            <option value="3">Sasoftco</option>
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