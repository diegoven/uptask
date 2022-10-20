(function () {
  // Botón para mostrar el modal de agregar tarea
  const nuevaTareaBtn = document.querySelector("#agregar-tarea");
  nuevaTareaBtn.addEventListener("click", mostrarFormulario);

  function mostrarFormulario() {
    const modal = document.createElement("div");
    modal.classList.add("modal");

    modal.innerHTML = /*html*/ `
        <form class="formulario nueva-tarea">
            <legend>Agrega una tarea nueva</legend>

            <div class="campo">
              <label>Tarea:</label>
              <input type="text" name="tarea" id="tarea" placeholder="añadir tarea al proyecto actual"/>
            </div>

            <div class="opciones">
              <input type="submit" class="submit-nueva-tarea" value="Añadir tarea"/>
              <button type="button" class="cerrar-modal">Cancelar</button>
            </div>
        </form>
    `;

    setTimeout(() => {
      const formulario = document.querySelector(".formulario");
      formulario.classList.add("animar");
    }, 0);

    modal.addEventListener("click", function (e) {
      e.preventDefault();

      if (e.target.classList.contains("cerrar-modal")) {
        // Modelo de concurrencia: loop de eventos
        const formulario = document.querySelector(".formulario");
        formulario.classList.add("cerrar");

        setTimeout(() => {
          modal.remove();
        }, 500);
      }

      if (e.target.classList.contains("submit-nueva-tarea")) {
        submitNuevaTarea();
      }
    });

    document.querySelector(".dashboard").appendChild(modal);
  }

  function submitNuevaTarea() {
    const tarea = document.querySelector("#tarea").value.trim();

    if (tarea === "") {
      mostrarAlerta(
        "El nombre de la tarea es obligatorio",
        "error",
        document.querySelector(".formulario legend")
      );

      return;
    }

    agregarTarea(tarea);
  }

  function mostrarAlerta(mensaje, tipo, referencia) {
    const alertaPrevia = document.querySelector(".alerta");
    if (alertaPrevia) alertaPrevia.remove();

    const alerta = document.createElement("div");
    alerta.classList.add("alerta", tipo);
    alerta.textContent = mensaje;
    alerta.style.fontSize = "1.4rem";

    referencia.parentElement.insertBefore(
      alerta,
      referencia.nextElementSibling
    );

    setTimeout(() => {
      alerta.remove();
    }, 3000);
  }

  async function agregarTarea(tarea) {
    // Construir petición
    const datos = new FormData();
    datos.append("nombre", tarea);
    datos.append("proyectoUrl", obtenerProyecto());

    try {
      const url = "http://localhost:3000/api/task";
      const respuesta = await fetch(url, {
        method: "POST",
        body: datos,
      });
      const resultado = await respuesta.json();

      mostrarAlerta(
        resultado.mensaje,
        resultado.tipo,
        document.querySelector(".formulario legend")
      );

      if (resultado.tipo === "exito") {
        document.querySelector("#tarea").value = "";
        const modal = document.querySelector(".modal");
        setTimeout(() => {
          modal.remove();
        }, 3000);
      }
    } catch (error) {
      console.log(error);
    }
  }

  function obtenerProyecto() {
    const proyectoParams = new URLSearchParams(window.location.search);
    const proyecto = Object.fromEntries(proyectoParams.entries());

    return proyecto.id;
  }
})();
