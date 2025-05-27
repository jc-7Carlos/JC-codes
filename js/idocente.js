// idocente.js

document.addEventListener('DOMContentLoaded', () => {
    const alumnos = {
      carlitos: {
        nombre: 'Carlitos',
        rol: 'Sanador | Nivel 2',
        fondo: 'imagenes/f1.jpg',
        foto: 'imagenes/p1.png',
        hp: 100,
        ap: 30,
        ep: 1000,
        gp: 500,
        poderes: ['Curación rápida', 'Escudo protector', 'Ola sanadora'],
        sentencias: ['"La luz me guía"', '"La esperanza nunca muere"', '"Solo los dignos pueden sanar"']
      },
      ana: {
        nombre: 'Ana',
        rol: 'Guerrera | Nivel 3',
        fondo: 'imagenes/f2.jpg',
        foto: 'imagenes/p2.png',
        hp: 120,
        ap: 40,
        ep: 1200,
        gp: 600,
        poderes: ['Golpe de espada', 'Carga heroica', 'Escudo divino'],
        sentencias: ['"No temo a la oscuridad"', '"Mi espada es mi justicia"', '"Venceré o moriré"']
      },
      juan: {
        nombre: 'Juan',
        rol: 'Mago | Nivel 4',
        fondo: 'imagenes/f3.jpg',
        foto: 'imagenes/p3.png',
        hp: 80,
        ap: 50,
        ep: 1500,
        gp: 700,
        poderes: ['Bola de fuego', 'Teletransportación', 'Hechizo arcano'],
        sentencias: ['"El conocimiento es poder"', '"Todo tiene un precio"', '"La magia lo es todo"']
      }
    };
  
    const alumnoBtns = document.querySelectorAll('.alumno-btn');
  
    alumnoBtns.forEach(btn => {
      btn.addEventListener('click', () => {
        const alumnoId = btn.getAttribute('data-alumno');
        const alumno = alumnos[alumnoId];
  
        if (alumno) {
          document.getElementById('nombreAlumno').textContent = alumno.nombre;
          document.getElementById('rolAlumno').textContent = alumno.rol;
  
          // Actualizar la imagen de fondo y del personaje
          document.getElementById('fondoAlumno').src = alumno.fondo;
          document.getElementById('fotoAlumno').src = alumno.foto;
  
          // Actualizar las barras y sus valores
          document.getElementById('hpValue').textContent = alumno.hp;
          document.getElementById('apValue').textContent = alumno.ap;
          document.getElementById('epValue').textContent = alumno.ep;
          document.getElementById('gpValue').textContent = alumno.gp;
  
          document.getElementById('hpBar').style.width = `${alumno.hp}%`;
          document.getElementById('apBar').style.width = `${alumno.ap}%`;
          document.getElementById('epBar').style.width = `${alumno.ep / 20}%`; // Ajusta según escala
          document.getElementById('gpBar').style.width = `${alumno.gp / 10}%`; // Ajusta según escala
  
          // Actualizar la lista de poderes
          const poderesList = document.getElementById('poderesList');
          poderesList.innerHTML = '';
          alumno.poderes.forEach(poder => {
            const li = document.createElement('li');
            li.textContent = poder;
            poderesList.appendChild(li);
          });
  
          // Actualizar la lista de sentencias
          const sentenciasList = document.getElementById('sentenciasList');
          sentenciasList.innerHTML = '';
          alumno.sentencias.forEach(sentencia => {
            const li = document.createElement('li');
            li.textContent = sentencia;
            sentenciasList.appendChild(li);
          });
        }
      });
    });
  });
  