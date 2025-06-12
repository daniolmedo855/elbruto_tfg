//VARIABLES
const sectionAdmin = document.querySelector(".admin");
const select = document.querySelector(".form_admin select");
const tabla = document.querySelector(".admin .tabla");
const botonAñadir = document.querySelector(".buscador button");
//FUNCIONES
function limpiar(div){
    div.innerHTML = "";
}

function mostrar_tabla(array, tipo) {
    limpiar(tabla); 
    sectionAdmin.querySelectorAll(".tabla+.form_admin").forEach(form => form.remove());

    botonAñadir.onclick = () => {
        form_crear(tipo);
    };

    const table = document.createElement("table");
    const tHeader = document.createElement("tr");

    if(array.length > 0){
        const keys = Object.keys(array[0]);

            keys.forEach(key => {
                const th = document.createElement("th");
                th.innerText = key;
                tHeader.appendChild(th);
            });

            table.appendChild(tHeader);

            array.forEach(element => {
                const tr = document.createElement("tr");

                keys.forEach(key => {
                    const td = document.createElement("td");
                    td.innerText = element[key];
                    tr.appendChild(td);
                });

                const borrar = document.createElement("button");
                borrar.innerText = "Borrar";
                borrar.addEventListener("click", () => {
                    fetch(`controllers/controller.php?action=borrar_${tipo}&id_${tipo}=${element[`id_${tipo}`]}`)
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            if(tipo == "usuario"){
                                usuarios();
                            } else {
                                brutos();
                            }
                        } else {
                            alert(`Error al borrar el ${tipo}`);
                        }
                    })
                    .catch(error => {
                        alert("Error en la conexión con el servidor");
                    });
                });

                const modificar = document.createElement("button");
                modificar.innerText = "Modificar";
                modificar.addEventListener("click", () => {
                    form_modificar(tipo, element[`id_${tipo}`]);
                });
                tr.appendChild(modificar);
                tr.appendChild(borrar);
                table.appendChild(tr);
            });

            tabla.appendChild(table); 
    } else {
        tabla.innerHTML = "No hay usuarios";
    }
}


function form_crear(tipo){
    sectionAdmin.querySelectorAll(".tabla+.form_admin").forEach(form => form.remove());

    const form = document.createElement("form");
    form.classList.add("form_admin");
    switch(tipo){
        case "usuario":
            form.innerHTML = `
                <input type="hidden" name="action" value="crear_usuario">
                <input type="text" name="username" placeholder="Usuario" required>
                <input type="password" name="password" placeholder="Contraseña" required>
                <input type="submit" value="Crear" class="btn">
            `

            form.addEventListener("submit", (e) => {
                e.preventDefault();
                fetch("controllers/form_controller.php", {
                    method: "POST",
                    body: new FormData(form)
                }).then(response => response.json())
                .then(data => {
                    if (data.status=="success") {
                        alert("Creado con exito");
                        location.reload();
                    } else {
                        alert("Error: " + data.message);
                    }    
                })
            })
            break;
        case "bruto":
            fetch ("controllers/controller.php?action=get_aspectos")
            .then(response => response.json())
            .then(aspectos => {
                fetch ("controllers/controller.php?action=get_usuarios")
                .then(response => response.json())
                .then(usuarios => {
                    form.innerHTML = `
                    <input type="hidden" name="action" value="crear_bruto">
                    <input type="text" name="nombre" placeholder="Nombre" required>
                    
                    <label for="usuario">Usuario</label>
                    <select name="usuario" id="usuario" required></select>
                    <label for="apariencia">Apariencia</label>
                    <select name="apariencia" id="apariencia" required></select>
                    `;

                    form.querySelector("select[name=usuario]").innerHTML = `<option value="" disabled selected>Seleccionar usuario</option>`;

                    usuarios.forEach(usuario => {
                        form.querySelector("select[name=usuario]").innerHTML += `
                        <option value="${usuario.nombre}">${usuario.nombre}</option>
                        `
                    });

                    form.querySelector("select[name=apariencia]").innerHTML = `<option value="" disabled selected>Seleccionar apariencia</option>`;

                    aspectos.forEach(aspecto => {
                        form.querySelector("select[name=apariencia]").innerHTML += `
                        <option value="${aspecto.id_aspecto}">${aspecto.imagen}</option>
                        `
                    });

                    form.innerHTML += `
                        <input type="submit" value="Crear" class="btn">
                    `

                    form.addEventListener("submit", (e) => {
                        e.preventDefault();
                        fetch("controllers/form_controller.php", {
                            method: "POST",
                            body: new FormData(form)
                        }).then(response => response.json())
                        .then(data => {
                            if (data.status=="success") {
                                alert("Creado con exito");
                                brutos();
                            } else {
                                brutos();
                            }    
                        })
                })
                })
            })
            
            
    }
    
    sectionAdmin.appendChild(form);
    
}

function form_modificar(tipo, id){
    sectionAdmin.querySelectorAll(".tabla+.form_admin").forEach(form => form.remove());

    const form = document.createElement("form");
    form.classList.add("form_admin");
    switch(tipo){
        case "usuario":
            form.innerHTML = `
                <input type="hidden" name="action" value="modificar_usuario">
                <input type="hidden" name="id_usuario" value="${id}">
                <input type="text" name="username" placeholder="Usuario" required>
                <input type="password" name="password" placeholder="Contraseña" required>
                <input type="submit" value="Modificar" class="btn">
            `

            form.addEventListener("submit", (e) => {
                e.preventDefault();
                fetch("controllers/form_controller.php", {
                    method: "POST",
                    body: new FormData(form)
                }).then(response => response.json())
                .then(data => {
                    if (data.status=="success") {
                        alert("Modificado con exito");
                        location.reload();
                    } else {
                        alert("Error: " + data.message);
                    }    
                })
            })
            break;
        case "bruto":
            form.innerHTML = `
                <input type="hidden" name="action" value="modificar_bruto">
                <input type="hidden" name="id_bruto" value="${id}">
                <input type="text" name="nombre" placeholder="Nombre" required>
                <input type="number" name="vida" placeholder="Vida" required>
                <input type="number" name="fuerza" placeholder="Fuerza" required>
                <input type="number" name="velocidad" placeholder="Velocidad" required>
                <input type="number" name="nivel" placeholder="Nivel" required>
                <input type="number" name="experiencia" placeholder="Experiencia" required>
                <input type="number" name="puntos_arena" placeholder="Puntos arena" required>
                <input type="submit" value="Modificar" class="btn">
            `

            form.addEventListener("submit", (e) => {
                e.preventDefault();
                console.log(form);
                fetch("controllers/form_controller.php", {
                    method: "POST",
                    body: new FormData(form)
                }).then(response => response.json())
                .then(data => {
                    if (data.status=="success") {
                        alert("Modificado con exito");
                        location.reload();
                    } else {
                        alert("Error: " + data.message);
                    }    
                })
            })
    }
    
    sectionAdmin.appendChild(form);
}

function usuarios(){
    get_usuarios().then(usuarios => {
        mostrar_tabla(usuarios, "usuario");
    });
    
}

function brutos(){
    get_brutos().then(brutos => {
        mostrar_tabla(brutos, "bruto");
    });
    
}

function get_usuarios(){
    return fetch("controllers/controller.php?action=get_usuarios")
        .then(response => response.json())
}

function get_brutos(){
    return fetch("controllers/controller.php?action=get_brutos_admin")
        .then(response => response.json())
}



document.addEventListener("DOMContentLoaded", () => {
    usuarios();
    select.addEventListener("change", (e) => {
    const valor = e.target.value.toLowerCase();
    sectionAdmin.querySelectorAll(".tabla+.form_admin").forEach(form => form.remove());

    switch (valor) {
        case "usuarios":
            usuarios();
            break;
        case "brutos":
            brutos();
            break;
    }
});

})