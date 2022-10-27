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

function filterCoursesMultiselect(event, get_element_basic, get_element_premium, set_element){
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