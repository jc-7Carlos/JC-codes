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
  });
  