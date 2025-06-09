//VARIABLES
//BRUTOS
const divBrutos = document.querySelector(".brutos>div");

//FUNCIONES
function mostrar_brutos() {
    get_brutos().then(brutos => {
        brutos.forEach(bruto => {
            const divBruto = document.createElement("div");
            const imgBruto = document.createElement("img");
            if(bruto.imagen==null){
                imgBruto.src = "img/aspectos/aspecto_1.png";
            } else {
                imgBruto.src = `img/aspectos/aspecto_${bruto.id_aspecto}.png`;
            }
            const nombre = document.createElement("p");
            nombre.textContent = bruto.nombre;

            divBruto.addEventListener("click", () => {
                window.location.href = `index.php?action=inventario&id=${bruto.id_bruto}`;
            });

            divBruto.append(imgBruto);
            divBruto.append(nombre);
            divBrutos.append(divBruto);
        });


        if(brutos.length<3){
            const div = document.createElement("div");
            const crearBruto = document.createElement("button");
            crearBruto.textContent = "+";
            div.addEventListener("click", () => {
                window.location.href = "index.php?action=crear_bruto";
            });
            div.append(crearBruto);
            divBrutos.append(div);
        }
    })
}

function get_brutos() {
    return fetch("controllers/controller.php?action=get_brutos_nombre")
        .then(response => response.json())
}

document.addEventListener("DOMContentLoaded", () => {
    mostrar_brutos();
}); 