function filterGroups(event, get_element, set_element){
    let grupos = document.getElementById(get_element);
    let options_grupos = "";
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
select_grupos_consolidado.addEventListener("change", filterColaboradores);
function filterColaboradores(){

    value_select = select_grupos_consolidado.value;

    const base_url = window.location.origin + "/primedigital";
    
    //consumir api colaboradores
    fetch(base_url + "/wp-json/api/colaboradores/" + value_select)
    .then(response => response.json())
    .then(data => {
        let colaboradores = document.getElementById("consolidado_colaboradores_set");
        let options_colaboradores = "";
        for(let i = 0; i < data.length; i++){
            options_colaboradores += "<option value="+data[i].id+">"+data[i].nombre+" "+data[i].apellido+"</option>";
        }
        colaboradores.innerHTML = options_colaboradores;
    }
    )

    
}