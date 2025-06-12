//VARIABLES
const divBrutos = document.querySelector(".brutos>div");

//FUNCIONES
function mostrar_brutos() {
    get_brutos().then(brutos => {
        for (let i = 0; i < brutos.length; i++) {
            const bruto = brutos[i];
            const divBruto = document.createElement("div");
            const imgBruto = document.createElement("img");
            const divTexto = document.createElement("div");
            imgBruto.src = `img/aspectos/aspecto_${bruto.id_aspecto}.png`;

            const nombre = document.createElement("p");
            nombre.textContent = bruto.nombre;

            const puntos_arena = document.createElement("p");
            puntos_arena.textContent = `Puntos Arena: ${bruto.puntos_arena}`;

            divBruto.addEventListener("click", () => {
                window.location.href = `index.php?action=inventario&id_bruto=${bruto.id_bruto}&ranking=1`;
            });

            divBruto.append(imgBruto);
            divTexto.append(nombre);
            divTexto.append(puntos_arena);
            divBruto.append(divTexto);
            divBrutos.append(divBruto);
        }
    })
}

function get_brutos() {   
    return fetch("controllers/controller.php?action=get_brutos_ranking")
        .then(response => response.json())
}
document.addEventListener("DOMContentLoaded", () => {
    mostrar_brutos();
})