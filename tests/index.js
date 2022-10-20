
let grupos = document.getElementById("grupos");

function filterGroups(event){

    let options_grupos = "";
    for(let i = 0; i < grupos.options.length; i++){
        if(grupos.options[i].text.includes(event.options[event.selectedIndex].text)){
            options_grupos += "<option value="+grupos.options[i].value+">"+grupos.options[i].text+"</option>";
        }
    }
    document.getElementById("gruposInner").innerHTML = options_grupos;
    document.getElementById("gruposInsert").innerHTML = options_grupos;
    
}
