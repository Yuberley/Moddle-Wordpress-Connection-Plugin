
function editarColaborador(idUsuario, nombre, apellido, usuario, documento, email, ciudad, pais){
    document.getElementById("idEditar").value = idUsuario;
    document.getElementById("nombreEditar").value = nombre;
    document.getElementById("apellidoEditar").value = apellido;
    document.getElementById("usuarioEditar").value = usuario;
    document.getElementById("documentoEditar").value = documento;
    document.getElementById("emailEditar").value = email;
    document.getElementById("ciudadEditar").value = ciudad;
    document.getElementById("paisEditar").value = pais;
}