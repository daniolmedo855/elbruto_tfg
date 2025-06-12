//VARIABLES
//CARRUSEL
const carruselContenedor = document.querySelector(".carrusel");
const carruselImagenes = document.querySelectorAll(".imagenes img");
const btnAnterior = document.querySelector(".carrusel .anterior");
const btnSiguiente = document.querySelector(".carrusel .siguiente");
let indice = 0;

//COMBATE
const divHabilidades = document.querySelector(".habilidades");
const divHerramientas = document.querySelector(".herramientas");

//FUNCIONES
function limpiar(div){
    div.innerHTML = "";
}

//CARRUSEL
function mostrar_imagen() {
  const desplazamiento = -indice * 100;
  document.querySelector(".imagenes").style.transform = `translateX(${desplazamiento}%)`;
}

//COMBATE
function mostrar_habilidades() {
    get_habilidades().then(habilidades => {
        habilidades.forEach(habilidad => {
            const divHabilidad = document.createElement("div");
            const imgHabilidad = document.createElement("img");
            imgHabilidad.src = `img/habilidades/${habilidad.imagen}`;
            divHabilidad.append(imgHabilidad);

            divHabilidad.addEventListener("mouseenter", () => {
                const modal = document.createElement("div");
                modal.classList.add("modal");
                const titulo = document.createElement("h4");
                titulo.textContent = habilidad.nombre;
                modal.append(titulo);
                habilidad.efectos.forEach(efecto => {
                        const p = document.createElement("p");
                        p.textContent = efecto.nombre+": +" + Math.round((efecto.multiplicador-1 )* 100) + "%";
                        modal.append(p);
                    })
                divHabilidad.append(modal);
            })

            divHabilidad.addEventListener("mouseleave", () => {
                const modal = document.querySelector(".modal");
                divHabilidad.removeChild(modal);
            })

            divHabilidades.append(divHabilidad);
        });
    })
}

function mostrar_herramientas() {
    get_herramientas().then(herramientas => {
        herramientas.forEach(herramienta => {
            const divHerramienta = document.createElement("div");
            const imgHerramienta = document.createElement("img");
            imgHerramienta.src = `img/herramientas/${herramienta.imagen}`;
            divHerramienta.append(imgHerramienta);

            divHerramienta.addEventListener("mouseenter", () => {
                const modal = document.createElement("div");
                modal.classList.add("modal");
                const titulo = document.createElement("h4");
                titulo.textContent = herramienta.nombre;
                modal.append(titulo);
                const danio = document.createElement("p");
                danio.textContent = "Daño: " + herramienta.danio;
                modal.append(danio);
                herramienta.efectos.forEach(efecto => {
                    const p = document.createElement("p");
                    p.textContent = efecto.nombre+": ";
                    if(Math.round((efecto.multiplicador-1 )* 100) > 0){
                        p.textContent += "+" + Math.round((efecto.multiplicador-1 )* 100) + "%";
                    } else {
                        p.textContent += Math.round((efecto.multiplicador-1 )* 100) + "%";
                    }
                    modal.append(p);
                })
                divHerramienta.append(modal);
            })

            divHerramienta.addEventListener("mouseleave", () => {
                const modal = document.querySelector(".modal");
                divHerramienta.removeChild(modal);
            })

            divHerramientas.append(divHerramienta);
        });
    })
}

function get_habilidades() {
    return fetch("controllers/controller.php?action=get_habilidades")
        .then(response => response.json())
}

function get_herramientas() {
    return fetch("controllers/controller.php?action=get_herramientas")
        .then(response => response.json())
}

document.addEventListener("DOMContentLoaded", () => {
    /*Carrusel*/
    btnSiguiente.addEventListener("click", () => {
        indice = (indice + 1) % carruselImagenes.length;
        mostrar_imagen();
    });

    btnAnterior.addEventListener("click", () => {
        indice = (indice - 1 + carruselImagenes.length) % carruselImagenes.length;
        mostrar_imagen();
    });


    //Combate
    mostrar_habilidades();
    mostrar_herramientas();
});