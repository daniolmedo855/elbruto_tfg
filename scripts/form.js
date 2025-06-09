//VARIABLES
//FORM
const form = document.querySelector(".form");
const input = form.querySelector("input");

document.addEventListener("DOMContentLoaded", () => {
    form.addEventListener("submit", (e) => {
        e.preventDefault();

        const datos = new FormData(form);
        
        fetch("controllers/form_controller.php", {
            method: "POST",
            body: datos
        }).then(response => response.json())
        .then(data => {
            if (data.status=="success") {
                alert("Iniciado con exito");
                window.location.href = "index.php";
            } else {
                alert("Error: " + data.message);
            }
        });
    });
});
