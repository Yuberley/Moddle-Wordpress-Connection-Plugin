
const removeAccents = (str) => {
    let string = str.value.normalize("NFD").replace(/[\u0300-\u036f]/g, "") ;
    str.value = string.toLowerCase();
}