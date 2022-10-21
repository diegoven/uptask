(function () {
  obtenerTareas();
  let tareas = [];

  // Botón para mostrar el modal de agregar tarea
  const nuevaTareaBtn = document.querySelector("#agregar-tarea");
  nuevaTareaBtn.addEventListener("click", mostrarFormulario);

  async function obtenerTareas() {
    try {
      const proyectoId = obtenerProyecto();
      const url = `/api/tasks?id=${proyectoId}`;
      const respuesta = await fetch(url);
      const resultado = await respuesta.json();

      tareas = resultado.tareas;

      mostrarTareas();
    } catch (error) {
      console.log(error);
    }
  }

  function mostrarTareas() {
    limpiarTareas();

    if (tareas.length === 0) {
      const contenedorTareas = document.querySelector("#listado-tareas");

      const textoNoTareas = document.createElement("li");
      textoNoTareas.textContent = "No hay tareas :(";
      textoNoTareas.classList.add("no-tareas");

      contenedorTareas.appendChild(textoNoTareas);

      return;
    }

    const estados = {
      0: "Pendiente",
      1: "Completa",
    };

    tareas.forEach((tarea) => {
      const contenedorTarea = document.createElement("li");
      contenedorTarea.dataset.tareaId = tarea.id;
      contenedorTarea.classList.add("tarea");

      const nombreTarea = document.createElement("p");
      nombreTarea.textContent = tarea.nombre;

      const opcionesDiv = document.createElement("div");
      opcionesDiv.classList.add("opciones");

      // Botones
      const btnEstadoTarea = document.createElement("button");
      btnEstadoTarea.classList.add("estado-tarea");
      btnEstadoTarea.classList.add(`${estados[tarea.estado].toLowerCase()}`);
      btnEstadoTarea.textContent = estados[tarea.estado];
      btnEstadoTarea.dataset.estadoTarea = tarea.estado;

      const btnEliminarTarea = document.createElement("button");
      btnEliminarTarea.classList.add("eliminar-tarea");
      btnEliminarTarea.dataset.idTarea = tarea.id;
      btnEliminarTarea.textContent = "Eliminar";

      opcionesDiv.appendChild(btnEstadoTarea);
      opcionesDiv.appendChild(btnEliminarTarea);

      contenedorTarea.appendChild(nombreTarea);
      contenedorTarea.appendChild(opcionesDiv);

      const listadoTareas = document.querySelector("#listado-tareas");
      listadoTareas.appendChild(contenedorTarea);
    });
  }

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

        // Agregar la tarea (objeto) al global de tareas
        const tareaObj = {
          id: String(resultado.id),
          nombre: tarea,
          estado: "0",
          proyectoId: resultado.proyectoId,
        };

        tareas = [...tareas, tareaObj];
        mostrarTareas();
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

  function limpiarTareas() {
    const listadoTareas = document.querySelector("#listado-tareas");

    while (listadoTareas.firstChild) {
      listadoTareas.removeChild(listadoTareas.firstChild);
    }
  }
})();
