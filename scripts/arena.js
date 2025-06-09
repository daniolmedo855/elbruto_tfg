//VARIABLES
const marcadores = document.querySelectorAll(".marcadores");
const peleadores = document.querySelectorAll(".peleadores");
const id_retado = parseInt(new URLSearchParams(window.location.search).get("id_bruto"));
const objeto = {"id_bruto": null, "nombre": null, "nivel": null, "vida": null, "fuerza": null, "velocidad": null, "puntos_arena": null, "experiencia": null, "id_usuario": null, "id_aspecto": null, "habilidades":[], "herramientas":[], "animales":[]};
let bruto_retado = objeto;
let bruto_retador = objeto;

//FUNCIONES

async function cargar_participantes() {
    let retado = await get_retado_bruto();
    let retador = await get_retador_bruto();

    copiar_objetos(bruto_retado, retado[0]);
    copiar_objetos(bruto_retador, retador[0]);

    console.log(retador[0], retado[0]);

    retado = await get_retado_habilidades();
    retador = await get_retador_habilidades();
}

function get_retado_bruto() {   
    return fetch("controllers/controller.php?action=get_retado_bruto&id_bruto="+id_retado)
        .then(response => response.json())
}

function get_retador_bruto() {   
    return fetch("controllers/controller.php?action=get_retador_bruto")
        .then(response => response.json())
}

function get_retado_habilidades() {   
    return fetch("controllers/controller.php?action=get_retado_habilidades&id_bruto="+id_retado)
        .then(response => response.json())
}

function get_retador_habilidades() {   
    return fetch("controllers/controller.php?action=get_retador_habilidades")
        .then(response => response.json())
}

function ronda() {
}

function copiar_objetos(destino, origen) {
    for (let clave in origen) {
    if (destino.hasOwnProperty(clave)) {
      destino[clave] = origen[clave];
    }
  }
}

document.addEventListener("DOMContentLoaded", () => {
    cargar_participantes();
});
