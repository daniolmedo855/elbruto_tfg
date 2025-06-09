//VARIABLES
const divHabilidades = document.querySelector(".habilidades");
const divHerramientas = document.querySelector(".herramientas");
const divAnimales = document.querySelector(".animales");
const divPersonaje = document.querySelector(".personaje");
const divCombate= document.querySelector(".combate");

//FUNCIONES
function mostrar_habilidades() {
    get_habilidades().then(habilidades => {

        get_habilidades_bruto().then(habilidades_bruto => {
            habilidades.forEach(habilidad => {
                const divHabilidad = document.createElement("div");
                const imgHabilidad = document.createElement("img");
                imgHabilidad.src = `img/habilidades/${habilidad.imagen}`;

                if (!habilidades_bruto.some(h => h.id_habilidad == habilidad.id_habilidad)) {
                    imgHabilidad.classList.add("opc"); // No la tengo, bajo la opacidad
                }
                divHabilidad.append(imgHabilidad);

                divHabilidad.addEventListener("mouseenter", () => {
                    const modal = document.createElement("div");
                    modal.classList.add("modal");
                    const titulo = document.createElement("h4");
                    titulo.textContent = habilidad.nombre;
                    modal.append(titulo);
                    divHabilidad.append(modal);
                })

                divHabilidad.addEventListener("mouseleave", () => {
                    const modal = document.querySelector(".modal");
                    divHabilidad.removeChild(modal);
                })

                divHabilidades.append(divHabilidad);
            });
        })
    })
}

function mostrar_herramientas() {
    get_herramientas().then(herramientas => {
        get_herramientas_bruto().then(herramientas_bruto => {
            herramientas.forEach(herramienta => {
            const divHerramienta = document.createElement("div");
            const imgHerramienta = document.createElement("img");
            imgHerramienta.src = `img/herramientas/${herramienta.imagen}`;

            if (!herramientas_bruto.some(h => h.id_herramienta == herramienta.id_herramienta)) {
                imgHerramienta.classList.add("opc"); // No la tengo, bajo la opacidad
            }
            divHerramienta.append(imgHerramienta);

            divHerramienta.addEventListener("mouseenter", () => {
                const modal = document.createElement("div");
                modal.classList.add("modal");
                const titulo = document.createElement("h4");
                titulo.textContent = herramienta.nombre;
                modal.append(titulo);
                divHerramienta.append(modal);
            })

            divHerramienta.addEventListener("mouseleave", () => {
                const modal = document.querySelector(".modal");
                divHerramienta.removeChild(modal);
            })

            divHerramientas.append(divHerramienta);
        });
        })
        
    })
}

function mostrar_bruto(){
    get_bruto_nombre().then(bruto => {
        const divBruto = document.createElement("div");
        const imgBruto = document.createElement("img");
        imgBruto.src = `img/aspectos/aspecto_${bruto[0].id_aspecto}.png`;

        const nombre = document.createElement("p");
        nombre.textContent = bruto[0].nombre;

        const nivel = document.createElement("p");
        nivel.textContent = `Nivel: ${bruto[0].nivel}`;

        const experiencia = document.createElement("p");
        experiencia.textContent = `Experiencia: ${bruto[0].experiencia}`;

        const vida = document.createElement("p");
        vida.textContent = `Vida: ${bruto[0].vida}`;

        const fuerza = document.createElement("p");
        fuerza.textContent = `Fuerza: ${bruto[0].fuerza}`;

        const velocidad = document.createElement("p");
        velocidad.textContent = `Velocidad: ${bruto[0].velocidad}`;
        
        divBruto.append(nombre);
        divBruto.append(imgBruto);
        divBruto.append(nivel);
        divBruto.append(experiencia);
        divBruto.append(vida);
        divBruto.append(fuerza);
        divBruto.append(velocidad);
        divPersonaje.append(divBruto);
    })
}

function mostrar_combates_bruto() {
    get_combates_bruto().then(combates => {

        const texto = document.createElement("p");
        if(combates[0].combates < 6) {
            const arenaButton = document.createElement("button");
            arenaButton.textContent = "Arena";
            arenaButton.classList.add("btn");
            arenaButton.addEventListener("click", () => {
                window.location.href = "index.php?action=buscador";
            });
            divCombate.append(arenaButton);

            texto.textContent = `Te quedan ${6 - combates[0].combates} combates`;
        } else {
            texto.textContent = "No te quedan combates";
        }
           
        divCombate.append(texto);
    })
}

function mostrar_animales_bruto() {
    get_animales_bruto().then(animales => {
        animales.forEach(animal => {
        const imgAnimal = document.createElement("img");
        imgAnimal.src = `img/animales/${animal.imagen}`;

        divAnimales.append(imgAnimal);
    });
    
    })
}

function get_id_bruto() {
    return fetch("controllers/controller.php?action=get_id_bruto")
        .then(response => response.json())
}   

function get_habilidades() {
    return fetch("controllers/controller.php?action=get_habilidades")
        .then(response => response.json())
}

function get_herramientas() {
    return fetch("controllers/controller.php?action=get_herramientas")
        .then(response => response.json())
}

function get_habilidades_bruto() {
    return fetch("controllers/controller.php?action=get_habilidades_bruto")
        .then(response => response.json())
}

function get_bruto_nombre() {
    return fetch("controllers/controller.php?action=get_bruto_id")
        .then(response => response.json())
}

function get_herramientas_bruto() {
    return fetch("controllers/controller.php?action=get_herramientas_bruto")
        .then(response => response.json())
}

function get_animales_bruto(){
    return fetch("controllers/controller.php?action=get_animales_bruto")
        .then(response => response.json())
}

function get_combates_bruto(){
    return fetch("controllers/controller.php?action=get_combates_bruto")
        .then(response => response.json())
}

document.addEventListener("DOMContentLoaded", () => {
    mostrar_habilidades();
    mostrar_herramientas();
    mostrar_bruto();
    mostrar_animales_bruto();
    mostrar_combates_bruto();
});