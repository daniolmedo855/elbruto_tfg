//VARIABLES
const divBrutos = document.querySelector(".brutos>div");

//FUNCIONES
function mostrar_brutos() {
    get_brutos().then(brutos => {
        for (let i = 0; i < brutos.length && i < 5; i++) {
            const bruto = brutos[i];
            const divBruto = document.createElement("div");
            const imgBruto = document.createElement("img");
            imgBruto.src = `img/aspectos/aspecto_${bruto.id_aspecto}.png`;

            const nombre = document.createElement("p");
            nombre.textContent = bruto.nombre;

            const vida = document.createElement("p");
            vida.textContent = `Vida: ${bruto.vida}`;

            const fuerza = document.createElement("p");
            fuerza.textContent = `Fuerza: ${bruto.fuerza}`;

            const velocidad = document.createElement("p");
            velocidad.textContent = `Velocidad: ${bruto.velocidad}`;

            divBruto.addEventListener("click", () => {
            window.location.href = `index.php?action=arena&id_bruto=${bruto.id_bruto}`;
            });

            divBruto.append(nombre);
            divBruto.append(vida);
            divBruto.append(fuerza);
            divBruto.append(velocidad);
            divBruto.append(imgBruto);
            divBrutos.append(divBruto);
            }
    })
}

function get_brutos() {   
    return fetch("controllers/controller.php?action=get_brutos")
        .then(response => response.json())
}
document.addEventListener("DOMContentLoaded", () => {
    mostrar_brutos();
})