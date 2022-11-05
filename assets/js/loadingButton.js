
const buttonAdd = document.getElementById("agregar_colaborador");
const buttonClose = document.getElementById("close_modal");
const buttonInner = document.getElementById("button_inner");

buttonAdd.addEventListener("submit", () => {
    const spinner = `<button class="btn btn-primary" type="button" disabled>
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Loading...
                    </button>`;
    console.log("buttonAdd");
    buttonInner.innerHTML = spinner;
});

buttonClose.addEventListener("click", () => {
    const normal = `<input type="submit" name="agregar_colaborador" value="Agregar Colaborador" id="agregar_colaborador">`;
    console.log("buttonClose");
    buttonInner.innerHTML = normal;
});
