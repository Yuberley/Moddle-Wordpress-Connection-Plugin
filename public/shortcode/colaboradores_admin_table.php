<?php

function tabla_superior(){
   
   echo '
    <body >
       <div class="container mt-5">
  
           <div class="row">
               <div class="col-md-8"><h1>COLABORADORES</h1></div>
           </div>
           <div class="row">
               <div class="col-md-4"> 
                  <br>
                   <div class="input-group mb-3">
                       <input type="text" class="form-control light-table-filter" data-table="order-table" placeholder="Buscar Reporte">
                   </div>
               </div>
               <div class="col-md-1"></div>
               <div class="col-md-3">
                   <label for="empresa">Empresa: </label>
                   <select class="form-select" >
                       <option selected>Seleccione una Empresa</option>
                       <option value="1">Sasoftco</option>
                       <option value="2">Bancolombia</option>
                       <option value="3">Cafesalud</option>
                   </select>
               </div>
               <div class="col-md-3">
                   <label for="grupos">Grupo: </label>
                   <select class="form-select" >
                       <option selected>Seleccione un Grupo</option>
                       <option value="1">Grupo 02-08-22</option>
                       <option value="2">Grupo 19-03-21</option>
                       <option value="3">Grupo 30/03-20</option>
                   </select>
               </div>
               
               <div class="col-md-1">
                   <br>
                   <button class="btn btn-secondary" type="button" id="button-addon2">Filtrar</button>
               </div>

           </div> 
       </div>
       
       <div class="container mt-5">
           
           <table class="table order-table table-hover " id="table" >
               <thead class="table-dark">
                    <tr>
                       <th scope="col">Usuario</th>
                       <th scope="col">Nombre </th>
                       <th scope="col">Apellido</th>
                       <th scope="col">Email</th>
                       <th scope="col">Ciudad</th>
                       <th scope="col">Pais</th>
                       <th scope="col">Ajustes</th>
                       
                   </tr>
               </thead>
               <tbody id="personas">
   '; 

}

function tabla_inferior(){

    echo '
                    <tr>
                    <td>Camilo22</td>
                    <td>Camilo Esteban</td>
                    <td>Morales Peña</td>
                    <td>camilopeña@gmail.com</td>
                    <td>Bogota</td>
                    <td>Colombia</td>
                    <td><button type="button" class="btn btn-outline-warning">Editar</button></td>
                    </tr>
               </tbody>
           </table> 
       </div>
       <div class="container mt-5">
       
       <div class="row">
           <div class="col-md-8"><h1></h1></div>
               <div class="col-md-4"> 
                   <div class="input-group mb-3 d-flex justify-content-end">
                   <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#modal_agregar_colaborador" >Agregar Nuevo Colaborador</button>
                   </div>
               </div>
           </div>
       </div>
       
       
       <!-- Modal agregar usuario -->
       <div class="modal fade" id="modal_agregar_colaborador" data-bs-backdrop="static" tabindex="-1" >
         <div class="modal-dialog ">
           <div class="modal-content">
             <div class="modal-header justify-content-center">
               <h5 class="modal-title mb-0" >Agregar Nuevo Colaborador</h5>
             </div>
             <div class="modal-body px-5">
                   <div>
                       <form  id="signup">
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
                               <label  class="form-label" for="Nombre">Nombre</label>
                               <input class="form-control" name="nombre" type="text" id="Nombre">
                           </div>
                           <div class="mb-3">
                               <label class="form-label" for="apellido">Apellido</label>
                               <input class="form-control" name="apellido" type="text" id="apellido">
                           </div>
                           <div class="mb-3">
                               <label class="form-label" for="usuario">Usuario</label>
                               <input class="form-control" name="usuario" type="email" id="email">
                           </div>
                           <div class="mb-3">
                               <label class="form-label" for="email">Email</label>
                               <input class="form-control" name="email" type="email" id="Name">
                           </div>
                           <div class="mb-3">
                               <label class="form-label" for="password">Contraseña</label>
                               <input class="form-control" name="password"  type="password" id="password">
                           </div>
                           <div class="mb-3">
                               <label class="form-label" for="edad">Edad</label>
                               <input class="form-control" name="edad" type="number" id="edad">
                           </div>
                           <div class="mb-3">
                               <label class="form-label" for="ciudad">Ciudad</label>
                               <input class="form-control" name="ciudad" type="text" id="ciudad">
                           </div>
                           <div class="mb-3">
                               <label class="form-label" for="pais">Pais</label>
                               <input class="form-control" name="pais" type="text" id="pais">
                           </div>
                           <div class="mb-3">
                           <label class="form-label" for="pais">Tipo de Licencia: </label>
                           <label class="form-label" for="pais">Basic </label>
                           </div>
                           <div class="mb-3 d-flex justify-content-center">
                               <input type="submit" value="Agregar Colaborador">
                           </div>
                           <div class="msg"></div>
                       </form>
                   </div>
             </div>
             <div class="modal-footer justify-content-center">
               <button type="button" class="btn btn-secondary"  data-bs-dismiss="modal">Cerrar</button>
             
             </div>
           </div>
         </div>
       </div>


 
   </body>   '; 


}