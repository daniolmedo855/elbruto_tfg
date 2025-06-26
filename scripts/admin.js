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
                    if(tipo == "usuario" || tipo == "bruto"){
                        fetch(`controllers/controller.php?action=borrar_${tipo}&id_${tipo}=${element[`id_${tipo}`]}`)
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                if(tipo == "usuario"){
                                    usuarios();
                                } else if(tipo == "bruto"){
                                    brutos();
                                }
                            } else {
                                alert(`Error al borrar el ${tipo}`);
                            }
                        })
                        .catch(error => {
                            alert("Error en la conexión con el servidor");
                        });

                    } else if(tipo=="bruto_habilidad"){
                        fetch(`controllers/controller.php?action=borrar_bruto_habilidad&id_bruto=${element.id_bruto}&id_habilidad=${element.id_habilidad}`)
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                habilidades();
                            } else {
                                alert(`Error al borrar}`);
                            }
                        })
                        .catch(error => {
                            alert("Error en la conexión con el servidor");
                        });

                    } else if(tipo=="bruto_herramienta"){
                        fetch(`controllers/controller.php?action=borrar_bruto_herramienta&id_bruto=${element.id_bruto}&id_herramienta=${element.id_herramienta}`)
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                herramientas();
                            } else {
                                alert(`Error al borrar}`);
                            }
                        })
                        .catch(error => {
                            alert("Error en la conexión con el servidor");
                        });
                    } else if(tipo=="bruto_animal"){
                        fetch(`controllers/controller.php?action=borrar_bruto_animal&id_bruto=${element.id_bruto}&id_animal=${element.id_animal}`)
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                animales();
                            } else {
                                alert(`Error al borrar}`);
                            }
                        })
                        .catch(error => {
                            alert("Error en la conexión con el servidor");
                        });
                    }
                    
                });
                if(tipo == "usuario" || tipo == "bruto"){
                    const modificar = document.createElement("button");
                    modificar.innerText = "Modificar";
                    modificar.addEventListener("click", () => {
                        form_modificar(tipo, element);
                    });
                    tr.appendChild(modificar);
                }
                
                tr.appendChild(borrar);
                table.appendChild(tr);
            });

            tabla.appendChild(table); 
    } else {
        tabla.innerHTML = "No hay datos";
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
                        usuarios();
                        alert("Creado con exito");
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
                });
            });
            
            form.addEventListener("submit", (e) => {
                e.preventDefault();
                fetch("controllers/form_controller.php", {
                    method: "POST",
                    body: new FormData(form)
                }).then(response => response.json())
                .then(data => {
                    if (data.success) {
                        brutos();
                        alert("Creado con exito");
                    } else {
                        alert("Error: " + data.error);
                    }
                })
            });
            break;

        case "bruto_habilidad":
            fetch ("controllers/controller.php?action=get_habilidades")
            .then(response => response.json())
            .then(habilidades => {
                fetch ("controllers/controller.php?action=get_brutos_all")
                .then(response => response.json())
                .then(brutos => {
                    form.innerHTML = `
                    <input type="hidden" name="action" value="crear_bruto_habilidad">
                    
                    <label for="bruto">Bruto</label>
                    <select name="id_bruto" id="bruto" required></select>
                    <label for="habilidad">Habilidad</label>
                    <select name="id_habilidad" id="habilidad" required></select>
                    `;

                    form.querySelector("select[name=id_bruto]").innerHTML = `<option value="" disabled selected>Seleccionar bruto</option>`;

                    brutos.forEach(bruto => {
                        form.querySelector("select[name=id_bruto]").innerHTML += `
                        <option value="${bruto.id_bruto}">${bruto.nombre}</option>
                        `
                    });

                    form.querySelector("select[name=id_habilidad]").innerHTML = `<option value="" disabled selected>Seleccionar habilidad</option>`;

                    habilidades.forEach(habilidad => {
                        form.querySelector("select[name=id_habilidad]").innerHTML += `
                        <option value="${habilidad.id_habilidad}">${habilidad.nombre}</option>
                        `
                    });

                    form.innerHTML += `
                        <input type="submit" value="Añadir" class="btn">
                    `
                });
            });
            
            form.addEventListener("submit", (e) => {
                e.preventDefault();
                fetch("controllers/form_controller.php", {
                    method: "POST",
                    body: new FormData(form)
                }).then(response => response.json())
                .then(data => {
                    if (data.success) {
                        habilidades();
                        alert("Creado con exito");
                    } else {
                        alert("Error: " + data.error);
                    }
                })
            });
            break;

        case "bruto_herramienta":
            fetch ("controllers/controller.php?action=get_herramientas")
            .then(response => response.json())
            .then(herramientas => {
                fetch ("controllers/controller.php?action=get_brutos_all")
                .then(response => response.json())
                .then(brutos => {
                    form.innerHTML = `
                    <input type="hidden" name="action" value="crear_bruto_herramienta">
                    
                    <label for="bruto">Bruto</label>
                    <select name="id_bruto" id="bruto" required></select>
                    <label for="herramienta">Herramienta</label>
                    <select name="id_herramienta" id="herramienta" required></select>
                    `;

                    form.querySelector("select[name=id_bruto]").innerHTML = `<option value="" disabled selected>Seleccionar bruto</option>`;

                    brutos.forEach(bruto => {
                        form.querySelector("select[name=id_bruto]").innerHTML += `
                        <option value="${bruto.id_bruto}">${bruto.nombre}</option>
                        `
                    });

                    form.querySelector("select[name=id_herramienta]").innerHTML = `<option value="" disabled selected>Seleccionar herramienta</option>`;

                    herramientas.forEach(herramienta => {
                        form.querySelector("select[name=id_herramienta]").innerHTML += `
                        <option value="${herramienta.id_herramienta}">${herramienta.nombre}</option>
                        `
                    });

                    form.innerHTML += `
                        <input type="submit" value="Añadir" class="btn">
                    `
                });
            });
            
            form.addEventListener("submit", (e) => {
                e.preventDefault();
                fetch("controllers/form_controller.php", {
                    method: "POST",
                    body: new FormData(form)
                }).then(response => response.json())
                .then(data => {
                    if (data.success) {
                        herramientas();
                        alert("Creado con exito");
                    } else {
                        alert("Error: " + data.error);
                    }
                })
            });
            break;

        case "bruto_animal":
            fetch ("controllers/controller.php?action=get_animales_all")
            .then(response => response.json())
            .then(animales => {
                fetch ("controllers/controller.php?action=get_brutos_all")
                .then(response => response.json())
                .then(brutos => {
                    form.innerHTML = `
                    <input type="hidden" name="action" value="crear_bruto_animal">
                    
                    <label for="bruto">Bruto</label>
                    <select name="id_bruto" id="bruto" required></select>
                    <label for="animal">Animales</label>
                    <select name="id_animal" id="animal" required></select>
                    `;

                    form.querySelector("select[name=id_bruto]").innerHTML = `<option value="" disabled selected>Seleccionar bruto</option>`;

                    brutos.forEach(bruto => {
                        form.querySelector("select[name=id_bruto]").innerHTML += `
                        <option value="${bruto.id_bruto}">${bruto.nombre}</option>
                        `
                    });

                    form.querySelector("select[name=id_animal]").innerHTML = `<option value="" disabled selected>Seleccionar animales</option>`;

                    animales.forEach(animal => {
                        form.querySelector("select[name=id_animal]").innerHTML += `
                        <option value="${animal.id_animal}">${animal.nombre}</option>
                        `
                    });

                    form.innerHTML += `
                        <input type="submit" value="Añadir" class="btn">
                    `
                });
            });
            
            form.addEventListener("submit", (e) => {
                e.preventDefault();
                fetch("controllers/form_controller.php", {
                    method: "POST",
                    body: new FormData(form)
                }).then(response => response.json())
                .then(data => {
                    if (data.success) {
                        animales();
                        alert("Creado con exito");
                    } else {
                        alert("Error: " + data.error);
                    }
                })
            });
            break;
    }

    const cerrar = document.createElement("button");
    cerrar.innerText = "X";
    cerrar.classList.add("cerrar");
    cerrar.addEventListener("click", () => {
        form.remove();
    });
    form.appendChild(cerrar);
    
    sectionAdmin.appendChild(form);
}

    

function form_modificar(tipo, objeto){
    sectionAdmin.querySelectorAll(".tabla+.form_admin").forEach(form => form.remove());

    const form = document.createElement("form");
    form.classList.add("form_admin");
    switch(tipo){
        case "usuario":
            form.innerHTML = `
                <input type="hidden" name="action" value="modificar_usuario">
                <input type="hidden" name="id_usuario" value="${objeto.id_usuario}">
                <input type="text" name="username" placeholder="Usuario" value="${objeto.nombre}">
                <input type="password" name="password" placeholder="Contraseña">
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
                        usuarios();
                        alert("Modificado con exito");
                    } else {
                        alert("Error: " + data.message);
                    }    
                })
            })
            break;

        case "bruto":
            form.innerHTML = `
                <input type="hidden" name="action" value="modificar_bruto">
                <input type="hidden" name="id_bruto" value="${objeto.id_bruto}">
                <label for="Nombre">Nombre</label>
                <input type="text" name="nombre" placeholder="Nombre" value="${objeto.nombre}">
                <label for="vida">Vida</label>
                <input type="number" name="vida" placeholder="Vida" value="${objeto.vida}">
                <label for="fuerza">Fuerza</label>
                <input type="number" name="fuerza" placeholder="Fuerza" value="${objeto.fuerza}">
                <label for="velocidad">Velocidad</label>
                <input type="number" name="velocidad" placeholder="Velocidad" value="${objeto.velocidad}">
                <label for="nivel">Nivel</label>
                <input type="number" name="nivel" placeholder="Nivel" value="${objeto.nivel}">
                <label for="experiencia">Experiencia</label>
                <input type="number" name="experiencia" placeholder="Experiencia" max="10" min="0" value="${objeto.experiencia}">
                <label for="puntos_arena">Puntos arena</label>
                <input type="number" name="puntos_arena" placeholder="Puntos arena" value="${objeto.puntos_arena}">
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
                        brutos();
                        alert("Modificado con exito");
                    } else {
                        alert("Error: " + data.message);
                    }    
                })
            })
            break;  
    }

    const cerrar = document.createElement("button");
    cerrar.innerText = "X";
    cerrar.classList.add("cerrar");
    cerrar.addEventListener("click", () => {
        form.remove();
    });
    form.appendChild(cerrar);
    
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

function herramientas(){
    get_herramientas().then(herramientas => {
        mostrar_tabla(herramientas, "bruto_herramienta");
    });
    
}

function habilidades(){
    get_habilidades().then(bruto_habilidad => {
        mostrar_tabla(bruto_habilidad, "bruto_habilidad");
    });
    
}

function animales(){
    get_animales().then(animales => {
        mostrar_tabla(animales, "bruto_animal");
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

function get_habilidades(){
    return fetch("controllers/controller.php?action=get_habilidades_admin")
        .then(response => response.json())
}

function get_herramientas(){
    return fetch("controllers/controller.php?action=get_herramientas_admin")
        .then(response => response.json())
}

function get_animales(){
    return fetch("controllers/controller.php?action=get_animales_admin")
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
            case "herramientas":
                herramientas();
                break;
            case "habilidades":
                habilidades();
                break;
            case "animales":
                animales();
                break;
        }
    });

})