function filterGroups(event, get_element, set_element){
    let grupos = document.getElementById(get_element);
    let options_grupos = "<option value='' selected disabled>Seleccione un grupo</option>";
    for(let i = 0; i < grupos.options.length; i++){
        if(grupos.options[i].text.includes(event.options[event.selectedIndex].text)){
            options_grupos += "<option value="+grupos.options[i].value+">"+grupos.options[i].text+"</option>";
        }
    }
    document.getElementById(set_element).innerHTML = options_grupos;
 
}

function filterCourses(event, get_element_basic, get_element_premium, set_element){
    let cursos_basic = document.getElementById(get_element_basic);
    let cursos_premium = document.getElementById(get_element_premium);
    let cursos_inner = document.getElementById(set_element);

    if(event.options[event.selectedIndex].text.includes("basic")){
        cursos_inner.innerHTML = cursos_basic.innerHTML;
    }

    if(event.options[event.selectedIndex].text.includes("premium")){
        cursos_inner.innerHTML = cursos_premium.innerHTML;    
    }
        
}


let select_grupos_consolidado = document.getElementById("consolidado_grupos_set");
const original_button = `<button type="submit" class="btn btn-primary" value="form_consolidado" >Generar Reporte</button>`;
const loading_button = `<button type="submit" class="btn btn-secondary" value="form_consolidado" disabled>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> 
                            Cargando estudiantes...
                        </button>`;
select_grupos_consolidado.addEventListener("change", filterColaboradores);

function filterColaboradores(){

    const base_url = window.location.origin;
    
    value_select = select_grupos_consolidado.value;
    let colaboradores = document.getElementById("consolidado_colaboradores_set");
    let reporte_consolidado_button = document.getElementById("reporte_consolidado_button");
    let options_colaboradores = "";
                                             
    colaboradores.innerHTML = options_colaboradores;
    reporte_consolidado_button.innerHTML = loading_button;
    

    fetch(base_url + "/wp-json/api/colaboradores/" + value_select)
    .then(response => response.json())
    .then(data => {
        for(let i = 0; i < data.length; i++){
            options_colaboradores += "<option value="+data[i].id+">"+data[i].nombre+" "+data[i].apellido+"</option>";
        }
        colaboradores.innerHTML = options_colaboradores;
        reporte_consolidado_button.innerHTML = original_button;
    })
    
}

setTimeout(function(){
    $("#selectAllStudents").click(function() {

        if($("#selectAllStudents").is(':checked') ){
            $(".selectColaborador").prop("checked", true);
            $("#consolidado_colaboradores_set option").attr("selected","selected");
        }else{
            $(".selectColaborador").prop("checked", false);
            $("#consolidado_colaboradores_set option").removeAttr("selected");
        }
    });

}, 1000);

setTimeout(function(){
    $("#selectAllCourses").click(function() {

        if($("#selectAllCourses").is(':checked') ){
            $(".selectColaborador").prop("checked", true);
            $("#consolidado_cursos_set option").attr("selected","selected");
        }else{
            $(".selectColaborador").prop("checked", false);
            $("#consolidado_cursos_set option").removeAttr("selected");
        }
    });

}, 1000);