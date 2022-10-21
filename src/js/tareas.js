(function () {
  obtenerTareas();
  let tareas = [];
  let filtradas = [];

  // Botón para mostrar el modal de agregar tarea
  const nuevaTareaBtn = document.querySelector("#agregar-tarea");
  nuevaTareaBtn.addEventListener("click", function () {
    mostrarFormulario();
  });

  // Filtros de búsqueda
  const filtros = document.querySelectorAll('#filtros input[type="radio"]');
  filtros.forEach((radio) => {
    radio.addEventListener("input", filtrarTareas);
  });

  function filtrarTareas(e) {
    const filtro = e.target.value;

    if (filtro !== "") {
      filtradas = tareas.filter((tarea) => tarea.estado === filtro);
    } else filtradas = [];

    mostrarTareas();
  }

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
    totalTareas("0", "#pendientes");
    totalTareas("1", "#completadas");

    const arrayTareas = filtradas.length ? filtradas : tareas;

    if (arrayTareas.length === 0) {
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

    arrayTareas.forEach((tarea) => {
      const contenedorTarea = document.createElement("li");
      contenedorTarea.dataset.tareaId = tarea.id;
      contenedorTarea.classList.add("tarea");

      const nombreTarea = document.createElement("p");
      nombreTarea.textContent = tarea.nombre;
      nombreTarea.ondblclick = function () {
        mostrarFormulario(true, { ...tarea });
      };

      const opcionesDiv = document.createElement("div");
      opcionesDiv.classList.add("opciones");

      // Botones
      const btnEstadoTarea = document.createElement("button");
      btnEstadoTarea.classList.add("estado-tarea");
      btnEstadoTarea.classList.add(`${estados[tarea.estado].toLowerCase()}`);
      btnEstadoTarea.textContent = estados[tarea.estado];
      btnEstadoTarea.dataset.estadoTarea = tarea.estado;
      btnEstadoTarea.onclick = function () {
        cambiarEstadoTarea({ ...tarea });
      };

      const btnEliminarTarea = document.createElement("button");
      btnEliminarTarea.classList.add("eliminar-tarea");
      btnEliminarTarea.dataset.idTarea = tarea.id;
      btnEliminarTarea.textContent = "Eliminar";
      btnEliminarTarea.onclick = function () {
        confirmarEliminarTarea({ ...tarea });
      };

      opcionesDiv.appendChild(btnEstadoTarea);
      opcionesDiv.appendChild(btnEliminarTarea);

      contenedorTarea.appendChild(nombreTarea);
      contenedorTarea.appendChild(opcionesDiv);

      const listadoTareas = document.querySelector("#listado-tareas");
      listadoTareas.appendChild(contenedorTarea);
    });
  }

  function totalTareas(estado, idRadio) {
    const total = tareas.filter((tarea) => tarea.estado === estado);
    const radio = document.querySelector(idRadio);

    if (total.length === 0) radio.disabled = true;
    else radio.disabled = false;
  }

  function mostrarFormulario(editar = false, tarea = {}) {
    const modal = document.createElement("div");
    modal.classList.add("modal");

    modal.innerHTML = /*html*/ `
        <form class="formulario nueva-tarea">
            <legend>${
              editar ? "Editar tarea" : "Agrega una tarea nueva"
            }</legend>

            <div class="campo">
              <label>Tarea:</label>
              <input 
              type="text" 
              name="tarea" 
              id="tarea" 
              placeholder="${
                tarea.nombre
                  ? "edita la tarea"
                  : "añadir tarea al proyecto actual"
              }" 
              value="${tarea.nombre ? tarea.nombre : ""}"/>
            </div>

            <div class="opciones">
              <input type="submit" class="submit-nueva-tarea" value="${
                tarea.nombre ? "Editar tarea" : "Añadir tarea"
              }"/>
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
        const nombreTarea = document.querySelector("#tarea").value.trim();

        if (nombreTarea === "") {
          mostrarAlerta(
            "El nombre de la tarea es obligatorio",
            "error",
            document.querySelector(".formulario legend")
          );

          return;
        }

        if (editar) {
          tarea.nombre = nombreTarea;
          actualizarTarea(tarea);
        } else agregarTarea(nombreTarea);
      }
    });

    document.querySelector(".dashboard").appendChild(modal);
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

  function cambiarEstadoTarea(tarea) {
    const nuevoEstado = tarea.estado === "1" ? "0" : "1";
    tarea.estado = nuevoEstado;

    actualizarTarea(tarea);
  }

  async function actualizarTarea(tarea) {
    const { estado, id, nombre } = tarea;

    const datos = new FormData();
    datos.append("id", id);
    datos.append("nombre", nombre);
    datos.append("estado", estado);
    datos.append("url", obtenerProyecto());

    // for (let valor of datos.values()) console.log(valor);

    try {
      const url = "http://localhost:3000/api/task/update";

      const respuesta = await fetch(url, {
        method: "POST",
        body: datos,
      });

      const resultado = await respuesta.json();

      if (resultado.respuesta.tipo === "exito") {
        Swal.fire(resultado.respuesta.mensaje, "", "success");

        const modal = document.querySelector(".modal");
        if (modal) modal.remove();

        tareas = tareas.map((tareaMemoria) => {
          if (tareaMemoria.id === id) {
            tareaMemoria.estado = estado;
            tareaMemoria.nombre = nombre;
          }

          return tareaMemoria;
        });

        mostrarTareas();
      }
    } catch (error) {
      console.log(error);
    }
  }

  function confirmarEliminarTarea(tarea) {
    Swal.fire({
      title: "¿Eliminar tarea?",
      showCancelButton: true,
      confirmButtonText: "Si",
      cancelButtonText: "No",
    }).then((result) => {
      /* Read more about isConfirmed, isDenied below */
      if (result.isConfirmed) {
        elimninarTarea(tarea);
      }
    });
  }

  async function elimninarTarea(tarea) {
    const { estado, id, nombre } = tarea;

    const datos = new FormData();
    datos.append("id", id);
    datos.append("nombre", nombre);
    datos.append("estado", estado);
    datos.append("url", obtenerProyecto());

    const url = "http://localhost:3000/api/task/delete";

    try {
      const url = "http://localhost:3000/api/task/delete";

      const respuesta = await fetch(url, {
        method: "POST",
        body: datos,
      });

      const resultado = await respuesta.json();

      if (resultado.resultado) {
        Swal.fire("Eliminado!", resultado.mensaje, "success");

        tareas = tareas.filter((tareaMemoria) => tareaMemoria.id !== tarea.id);

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
