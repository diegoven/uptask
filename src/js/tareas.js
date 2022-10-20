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
})();
