
function deleteCollaborator(idUsuario, nombre, apellido){
    Swal.fire({
        position: "center",
        icon: "info",
        title: "¿Está seguro de eliminar a " + nombre + " " + apellido + "?",
        showConfirmButton: false,
        showCancelButton: true,
        cancelButtonText: "Cancelar",
        cancelButtonColor: "#d33",
        html: `<form method="POST">
                    <input type="hidden" name="idEliminar" value="${idUsuario}">
                    <button type="submit" class="btn btn-primary" name="eliminar_usuario">Confirmar</button>
                </form>`,
    });
}
