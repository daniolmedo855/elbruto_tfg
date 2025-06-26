//VARIABLES
const marcadores = document.querySelectorAll(".marcadores");
const peleadores = document.querySelectorAll(".peleadores");
const id_retado = parseInt(new URLSearchParams(window.location.search).get("id_bruto"));
const cronologia = document.querySelector(".cronologia");
const div_bruto_retador = document.querySelector(".bruto1");
const div_bruto_retado = document.querySelector(".bruto2");
const objeto = {"id_bruto": null, "nombre": null, "nivel": null, "vida": null, "fuerza": null, "velocidad": null, "puntos_arena": null, "experiencia": null, "id_usuario": null, "id_aspecto": null, "habilidades":[], "herramientas":[], "animales":[], "armado": null, "caracteristicas_combate": [], "vida_maxima": null};
let bruto_retado = {...objeto};
let bruto_retador = {...objeto};
let vida_maxima_bruto_retado = 0;
let vida_maxima_bruto_retador = 0;
//FUNCIONES

async function cargar_participantes() {
    let retado = await get_retado_bruto();
    let retador = await get_retador_bruto();

    copiar_objetos(bruto_retador, retador[0]);
    copiar_objetos(bruto_retado, retado[0]);

    bruto_retado.vida_maxima = bruto_retado.vida;
    bruto_retador.vida_maxima = bruto_retador.vida;

    retado = await get_retado_habilidades();
    retador = await get_retador_habilidades();

    bruto_retado.habilidades = retado;
    bruto_retador.habilidades = retador;

    retado = await get_retado_herramientas();
    retador = await get_retador_herramientas();

    bruto_retado.herramientas = retado;
    bruto_retador.herramientas = retador;

    retado = await get_retado_animales();
    retador = await get_retador_animales();

    bruto_retado.animales = retado;
    bruto_retador.animales = retador;

}

function mostrar_participantes() {
    div_bruto_retado.innerHTML = `<img src="img/aspectos/aspecto_${bruto_retado.id_aspecto}.png" alt="" class="bruto">`;
    div_bruto_retado.setAttribute("id", `bruto_${bruto_retado.id_bruto}`);
    if(bruto_retado.animales.length > 0) {
        div_bruto_retado.innerHTML += `<img src="img/animales/animal_${bruto_retado.animales[0].id_animal}.png" alt="${bruto_retado.animales[0].nombre}}" class="${bruto_retado.animales[0].nombre}">`;
    }
    div_bruto_retado.innerHTML += `<h2>${bruto_retado.nombre}</h2>`;
    
    div_bruto_retador.innerHTML = `<img src="img/aspectos/aspecto_${bruto_retador.id_aspecto}.png" alt="" class="bruto">`;
    div_bruto_retador.setAttribute("id", `bruto_${bruto_retador.id_bruto}`);
    if(bruto_retador.animales.length > 0) {
        div_bruto_retador.innerHTML += `<img src="img/animales/${bruto_retador.animales[0].imagen}" alt="${bruto_retador.animales[0].nombre}" class="${bruto_retador.animales[0].nombre}">`;
    }
    div_bruto_retador.innerHTML += `<h2>${bruto_retador.nombre}</h2>`;
}

function limpiar(div) {
    div.innerHTML = "";
}

function ronda(bruto1, bruto2) {
    console.log(bruto1, bruto2);
    let delay = 0;

    function delayStep(fn, ms) {
        setTimeout(fn, delay);
        delay += ms;
    }

    const paso = 2000;

    // ARMADO
    if (bruto1.herramientas.length > 0 && bruto1.armado === null) {
        bruto1.armado = bruto1.herramientas.shift();
        div_bruto_retador.innerHTML += `<img src="img/herramientas/${bruto1.armado.imagen}" alt="${bruto1.armado.nombre}" class="armado ${bruto1.armado.nombre}">`;
    }
    if (bruto2.herramientas.length > 0 && bruto2.armado === null) {
        bruto2.armado = bruto2.herramientas.shift();
        div_bruto_retado.innerHTML += `<img src="img/herramientas/${bruto2.armado.imagen}" alt="${bruto2.armado.nombre}" class="armado ${bruto2.armado.nombre}">`;
    }

    // COMBATE por turnos
    delayStep(() => ataque(bruto1, bruto2), paso);

    
    if(bruto2.armado != null) {
        if (desarmar(bruto1)) {
        const arma = document.querySelector(`#bruto_${bruto2.id_bruto} img.armado`);
        if(arma != null){
            arma.remove();
        }
        delayStep(() => {
            bruto2.armado = null;
            console.log("AQUI "+bruto2.armado);
            limpiar(cronologia);
            cronologia.innerHTML += `<p>${bruto1.nombre} desarma a ${bruto2.nombre}<p>`;
        }, paso);
    }
    }
    

    if (bruto2.vida < 1) {
        delayStep(() => {
            limpiar(cronologia);
            cronologia.innerHTML += `<p>${bruto1.nombre} gana la ronda<p>`;
            console.log(bruto1, bruto2);
            terminar_ronda(bruto1.id_bruto, bruto2.id_bruto);
        }, paso);
        return; 
    }

    if (multigolpe(bruto1)) {
        delayStep(() => ataque(bruto1, bruto2), paso);
    }

    if (bruto2.vida < 1) {
        delayStep(() => {
            limpiar(cronologia);
            cronologia.innerHTML += `<p>${bruto1.nombre} gana la ronda<p>`;
            console.log(bruto1, bruto2);
            terminar_ronda(bruto1.id_bruto, bruto2.id_bruto);
        }, paso);
        return; 
    }

    if (contraataque(bruto2)) {
        delayStep(() => ataque(bruto2, bruto1), paso);
    }

    delayStep(() => ataque(bruto2, bruto1), paso);

    if(bruto1.armado != null){
        if (desarmar(bruto2)) {
        const arma = document.querySelector(`#bruto_${bruto1.id_bruto} img.armado`);
        if(arma != null){
            arma.remove();
        }
        delayStep(() => {
            bruto1.armado = null;
            console.log("AQUI "+bruto1.armado);
            limpiar(cronologia);
            cronologia.innerHTML += `<p>${bruto2.nombre} desarma a ${bruto1.nombre}<p>`;
        }, paso);
    }
    }
    
    if (bruto1.vida < 1) {
        delayStep(() => {
            limpiar(cronologia);
            cronologia.innerHTML += `<p>${bruto2.nombre} gana la ronda<p>`;
            console.log(bruto1, bruto2);
            terminar_ronda(bruto2.id_bruto, bruto1.id_bruto);
        }, paso);
        return;
    }

    if (multigolpe(bruto2)) {
        delayStep(() => ataque(bruto2, bruto1), paso);
    }

    if (bruto1.vida < 1) {
        delayStep(() => {
            limpiar(cronologia);
            cronologia.innerHTML += `<p>${bruto2.nombre} gana la ronda<p>`;
            console.log(bruto1, bruto2);
            terminar_ronda(bruto2.id_bruto, bruto1.id_bruto);
        }, paso);
        return;
    }

    if (contraataque(bruto1)) {
        delayStep(() => ataque(bruto1, bruto2), paso);
    }

    if (bruto1.animales.length > 0) {
        delayStep(() => ataque_animal(bruto1, bruto1.animales[0], bruto2), paso);
    }

    if (bruto2.vida < 1) {
        delayStep(() => {
            limpiar(cronologia);
            cronologia.innerHTML += `<p>${bruto1.nombre} gana la ronda<p>`;
            console.log(bruto1, bruto2);
            terminar_ronda(bruto1.id_bruto, bruto2.id_bruto);
        }, paso);
        return; 
    }

    if (bruto2.animales.length > 0) {
        delayStep(() => ataque_animal(bruto2, bruto2.animales[0], bruto1), paso);
    }

    delayStep(() => {
        if (bruto1.vida > 0 && bruto2.vida > 0) {
            ronda(bruto1, bruto2);
        } else {
            limpiar(cronologia);
            if(bruto1.vida > 0) {
                cronologia.innerHTML += `<p>${bruto1.vida > 0 ? bruto1.nombre : bruto2.nombre} gana la ronda<p>`;
                console.log(bruto1, bruto2);
                terminar_ronda(bruto1.id_bruto, bruto2.id_bruto);

            } else {
                cronologia.innerHTML += `<p>${bruto2.vida > 0 ? bruto2.nombre : bruto1.nombre} gana la ronda<p>`;
                console.log(bruto1, bruto2);
                terminar_ronda(bruto2.id_bruto, bruto1.id_bruto);
            }
        }
    }, paso + 500);
}

function ataque(bruto1, bruto2) {
    if(!esquivar(bruto2)) {
        bruto2.vida -= Math.round(bruto1.fuerza + (bruto1.armado?.danio || 0));
        animacion_ataque(bruto2.id_bruto);
        limpiar(cronologia);
        cronologia.innerHTML += `<p>${bruto1.nombre} golpea a ${bruto2.nombre} y le inflinge ${bruto1.fuerza + (bruto1.armado?.danio || 0)} de daño<p>`;
    } else{
        limpiar(cronologia);
        cronologia.innerHTML += `<p>${bruto2.nombre} esquiva el ataque de ${bruto1.nombre}<p>`;
    }

    actualizar_vida();
}

function ataque_animal(bruto1, animal, bruto2){
    if(!esquivar(bruto2)) {
        bruto2.vida -= Math.round(animal.danio * bruto1.fuerza)
        animacion_ataque_animal(bruto2.id_bruto);
        limpiar(cronologia);
        cronologia.innerHTML += `<p>${animal.nombre} de ${bruto1.nombre} golpea a ${bruto2.nombre} y le inflinge ${Math.round(animal.danio * bruto1.fuerza)} de daño<p>`;
    } else{
        limpiar(cronologia);
        cronologia.innerHTML += `<p> ${bruto2.nombre} esquiva el ataque de ${animal.nombre} de ${bruto1.nombre}<p>`;
    }
    actualizar_vida();
}

function esquivar(bruto) {
    if(bruto.caracteristicas_combate?.esquivar > 0) {
        return random_booleano(bruto.caracteristicas_combate.esquivar);
    } else {
        return false;
    }
}

function desarmar(bruto) {
    const base = bruto.caracteristicas_combate?.desarmar ?? 1;
    const arma = bruto.armado?.efectos?.find(ef => ef.nombre === "desarmar")?.multiplicador ?? 1;

    return random_booleano(base * arma);
}

function contraataque(bruto) {
    const base = bruto.caracteristicas_combate?.contraataque ?? 1;
    const arma = bruto.armado?.efectos?.find(ef => ef.nombre === "contraataque")?.multiplicador ?? 1;

    return random_booleano(base * arma);
}

function multigolpe(bruto) {
    const base = bruto.caracteristicas_combate?.multigolpe ?? 1;
    const arma = bruto.armado?.efectos?.find(ef => ef.nombre === "multigolpe")?.multiplicador ?? 1;

    return random_booleano(base * arma);
}

function aplicar_habilidades_estadisticas(bruto) {
    //MEJORAS DE ESTADISTICAS PRINCIPALES POR HABILIDAD
    bruto.habilidades.forEach(habilidad => {
        habilidad.efectos.forEach(efecto => {
            if (efecto.nombre === "vida") {
                bruto.vida *= efecto.multiplicador;
            }
            if (efecto.nombre === "fuerza") {
                bruto.fuerza *= efecto.multiplicador;
            }
            if (efecto.nombre === "velocidad") {
                bruto.velocidad *= efecto.multiplicador;
            }
            if (efecto.nombre === "contraataque"){
                bruto.caracteristicas_combate.contraataque = efecto.multiplicador;
            }
            if (efecto.nombre === "desarmar"){
                bruto.caracteristicas_combate.desarmar = efecto.multiplicador;
            }
            if (efecto.nombre === "esquivar"){
                bruto.caracteristicas_combate.esquivar = efecto.multiplicador;
            }
            if (efecto.nombre === "multigolpe"){
                bruto.caracteristicas_combate.multigolpe = efecto.multiplicador;
            }
            if (efecto.nombre === "fuerza_arma_blanca"){
                bruto.caracteristicas_combate.fuerza_arma_blanca = efecto.multiplicador;
            }
            if (efecto.nombre === "fuerza_arma_pesada"){
                bruto.caracteristicas_combate.fuerza_arma_pesada = efecto.multiplicador;
            }
            if (efecto.nombre === "fuerza_puño"){
                bruto.caracteristicas_combate.fuerza_puño = efecto.multiplicador;
            }
        })
    });
}

function actualizar_vida() {
    bruto_retador.vida = Math.max(0, bruto_retador.vida);
    bruto_retador.vida = Math.min(bruto_retador.vida, bruto_retador.vida_maxima);

    const porcentaje_retador = (bruto_retador.vida / bruto_retador.vida_maxima) * 100;
    const barra_retador = document.querySelector(".barra_vida1");
    barra_retador.style.width = `${porcentaje_retador}%`;

    if (porcentaje_retador > 60) {
        barra_retador.style.background = "linear-gradient(to right, #00c853, #64dd17)"; // verde
    } else if (porcentaje_retador > 30) {
        barra_retador.style.background = "linear-gradient(to right, #ffd600, #ffab00)"; // amarillo
    } else {
        barra_retador.style.background = "linear-gradient(to right, #dd2c00, #ff1744)"; // rojo
    }

    bruto_retado.vida = Math.max(0, bruto_retado.vida);
    bruto_retado.vida = Math.min(bruto_retado.vida, bruto_retado.vida_maxima);
    
    const porcentaje_retado = (bruto_retado.vida / bruto_retado.vida_maxima) * 100;
    const barra_retado = document.querySelector(".barra_vida2");
    barra_retado.style.width = `${porcentaje_retado}%`;

    if (porcentaje_retado > 60) {
        barra_retado.style.background = "linear-gradient(to right, #00c853, #64dd17)"; // verde
    } else if (porcentaje_retado > 30) {
        barra_retado.style.background = "linear-gradient(to right, #ffd600, #ffab00)"; // amarillo
    } else {
        barra_retado.style.background = "linear-gradient(to right, #dd2c00, #ff1744)"; // rojo
    }
}

function animacion_ataque(id_bruto){
    const img = document.querySelector(`#bruto_${id_bruto} img`);
    img.classList.add("daño");
    const img_ataque = document.createElement("img");
    img_ataque.src = "img/assets/ataque.png";
    img_ataque.classList.add("ataque");
    img.parentNode.append(img_ataque);
    setTimeout(() => {
        img.classList.remove("daño");
        img_ataque.remove();
    }, 1000);
}
function animacion_ataque_animal(id_bruto){
    const img = document.querySelector(`#bruto_${id_bruto} img`);
    img.classList.add("daño");
    const img_ataque = document.createElement("img");
    img_ataque.src = "img/assets/ataque_animal.png";
    img_ataque.classList.add("ataque");
    img.parentNode.append(img_ataque);
    setTimeout(() => {
        img.classList.remove("daño");
        img_ataque.remove();
    }, 1000);
}

function terminar_ronda(id_ganador, id_perdedor) {
    document.body.style.cursor = "pointer";
    document.body.addEventListener("click", () => {
        actualizar_resultado(id_ganador, id_perdedor).then(() => {
            window.location.href = "index.php?action=inventario&id_bruto="+bruto_retador.id_bruto;
        })
    })
}

function actualizar_resultado(id_ganador, id_perdedor) {
    return fetch("controllers/controller.php?action=actualizar_resultado&id_ganador="+id_ganador+"&id_perdedor="+id_perdedor)
        .then(response => response.json())
}

function copiar_objetos(destino, origen) {
    for (let clave in origen) {
    if (destino.hasOwnProperty(clave)) {
      destino[clave] = origen[clave];
    }
  }
}

function random_booleano(probabilidad) {
    probabilidad = probabilidad - 1;
    return Math.random() < probabilidad;
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

function get_retado_herramientas() {   
    return fetch("controllers/controller.php?action=get_retado_herramientas&id_bruto="+id_retado)
        .then(response => response.json())
}

function get_retador_herramientas() {   
    return fetch("controllers/controller.php?action=get_retador_herramientas")
        .then(response => response.json())
}

function get_retado_animales() {   
    return fetch("controllers/controller.php?action=get_retado_animales&id_bruto="+id_retado)
        .then(response => response.json())
}

function get_retador_animales() {   
    return fetch("controllers/controller.php?action=get_retador_animales")
        .then(response => response.json())
}

document.addEventListener("DOMContentLoaded", async () => {
    await cargar_participantes();

    actualizar_vida();

    aplicar_habilidades_estadisticas(bruto_retado);
    aplicar_habilidades_estadisticas(bruto_retador);

    mostrar_participantes();

    if(bruto_retado.velocidad > bruto_retador.velocidad) {
        ronda(bruto_retado, bruto_retador);
    } else {
        ronda(bruto_retador, bruto_retado);
    }
});
