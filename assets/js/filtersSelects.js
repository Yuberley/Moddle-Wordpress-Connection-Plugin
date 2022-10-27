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

    let options_cursos = `
    <option value="1">One</option>
    <option value="2">Two</option>
    <option value="3">Three</option>
    <option value="4">Four</option>
    <option value="5">Five</option>
    <option value="6">Six</option>
    <option value="7">Seven</option>
    <option value="8">Eight</option>`;
    console.log(options_cursos);
    if(event.options[event.selectedIndex].text.includes("basic")){
        cursos_inner.innerHTML = options_cursos;
        
        
    }
    if(event.options[event.selectedIndex].text.includes("premium")){
        cursos_inner.innerHTML = options_cursos;
        
    }
        
}