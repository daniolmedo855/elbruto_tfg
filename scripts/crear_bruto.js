//VARIABLES
//CARRUSEL
const carruselContenedor = document.querySelector(".carrusel");
const carruselImagenes = document.querySelectorAll(".imagenes img");
const btnAnterior = document.querySelector(".carrusel .anterior");
const btnSiguiente = document.querySelector(".carrusel .siguiente");
let indice = 0;

//FORM
const form = document.querySelector(".form");
const input = form.querySelector("input");
const apariencia = document.querySelector("input[name=apariencia]");
apariencia.value = indice + 1;

//FUNCIONES
function mostrar_imagen() {
    const desplazamiento = -indice * 100;
    document.querySelector(".imagenes").style.transform = `translateX(${desplazamiento}%)`;
}

document.addEventListener("DOMContentLoaded", () => {
    /*Carrusel*/
    btnSiguiente.addEventListener("click", () => {
        indice = (indice + 1) % carruselImagenes.length;
        apariencia.value = indice + 1;
        mostrar_imagen();
    });

    btnAnterior.addEventListener("click", () => {
        indice = (indice - 1 + carruselImagenes.length) % carruselImagenes.length;
        apariencia.value = indice + 1;
        mostrar_imagen();
    });

    //Form
    form.addEventListener("submit", (e) => {
        e.preventDefault();

        const datos = new FormData(form);
        
        fetch("controllers/controller.php", {
            method: "POST",
            body: datos
        }).then(response => response.json())
        .then(data => {
            if (data.success==true) {
                alert("Creado con exito");
                window.location.href = "index.php?action=inventario&id_bruto="+data.id_bruto;
            } else {
                alert("Error: " + data.error);
            }
        });
    });
});