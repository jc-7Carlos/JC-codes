//js/añ_alumno.js*/



document.addEventListener('DOMContentLoaded', () => {
  // Referencias a secciones
  const seccionInicial = document.getElementById('seccion-inicial');
  const seccionCrearNuevas = document.getElementById('seccion-crear-nuevas');
  const seccionAñadirExistentes = document.getElementById('seccion-añadir-existentes');
  const seccionCrearEquipos = document.getElementById('seccion-crear-equipos');

  // Botones/opciones en la sección inicial
  const btnCrearNuevas = document.getElementById('crear-nuevas-cuentas');
  const btnAñadirExistentes = document.getElementById('añadir-alumnos-existentes');
  const btnCrearEquipos = document.getElementById('crear-equipos');

  // Botones volver
  const btnVolverInicio1 = document.getElementById('volver-inicio1');
  const btnVolverInicio2 = document.getElementById('volver-inicio2');
  const btnVolverInicio3 = document.getElementById('volver-inicio3');

  // Nuevo botón terminado
  const btnTerminado = document.getElementById('btn-terminado');

  // Formulario crear equipos
  const formCrearEquipos = seccionCrearEquipos.querySelector('form');

  // Función para ocultar todas las secciones (menos inicial)
  function ocultarTodas() {
    seccionCrearNuevas.classList.add('hidden');
    seccionAñadirExistentes.classList.add('hidden');
    seccionCrearEquipos.classList.add('hidden');
  }

  // Mostrar crear nuevas cuentas
  btnCrearNuevas.addEventListener('click', () => {
    seccionInicial.classList.add('hidden');
    ocultarTodas();
    seccionCrearNuevas.classList.remove('hidden');
  });

  // Mostrar añadir alumnos existentes
  btnAñadirExistentes.addEventListener('click', () => {
    seccionInicial.classList.add('hidden');
    ocultarTodas();
    seccionAñadirExistentes.classList.remove('hidden');
  });

  // Mostrar crear equipos
  btnCrearEquipos.addEventListener('click', () => {
    seccionInicial.classList.add('hidden');
    ocultarTodas();
    seccionCrearEquipos.classList.remove('hidden');
    btnTerminado.classList.add('hidden'); // asegurar que botón terminado esté oculto al entrar
    formCrearEquipos.style.display = 'flex'; // mostrar formulario por si estaba oculto
  });

  // Botones volver a opciones
  btnVolverInicio1.addEventListener('click', () => {
    ocultarTodas();
    seccionInicial.classList.remove('hidden');
  });

  btnVolverInicio2.addEventListener('click', () => {
    ocultarTodas();
    seccionInicial.classList.remove('hidden');
  });

  btnVolverInicio3.addEventListener('click', () => {
    ocultarTodas();
    seccionInicial.classList.remove('hidden');
  });

  // Evento submit formulario crear equipos
  formCrearEquipos.addEventListener('submit', (e) => {
    e.preventDefault(); // evitar envío real / recarga

    // Aquí puedes agregar lógica para crear el equipo (ej. llamada a backend)

    // Mostrar botón Terminado y ocultar formulario
    formCrearEquipos.style.display = 'none';
    btnTerminado.classList.remove('hidden');
  });

  // Evento click botón Terminado
  btnTerminado.addEventListener('click', () => {
    btnTerminado.classList.add('hidden');
    ocultarTodas();
    seccionInicial.classList.remove('hidden');
    formCrearEquipos.reset(); // resetear formulario para próxima vez
    formCrearEquipos.style.display = 'flex'; // mostrar formulario para próxima vez
  });
});


// En tu archivo añ_alumno.js

document.getElementById('btn-terminado').addEventListener('click', () => {
  window.location.href = 'mis_clases.html';
});
