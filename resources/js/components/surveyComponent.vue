<!-- MyComponent.vue -->
<template>
    <div v-if="siguientePaso == false"> 
      <h3 class="titulo">Encuesta de evaluación de calidad </h3>
      <div class="row" v-if="isMobile">
        <!-- Primer grupo -->
        <div class="col-md-4" v-show="group === 1">
          <p class="subtitulo">CAMPUS/SEDE</p>
          <div class="botones-container">
            <button v-if="sedes"
              v-for="sede in sedes"
              :key="sede"
              class="boton-naranja"
              @click="seleccionarSede(sede)"
              :class="{ 'seleccionado': encuesta.campus === sede }"
            >
              {{ sede.sede }}
            </button>
          </div>
        </div>
        <!-- Segundo grupo -->
        <div class="col-md-4 " v-show="group === 2">
          <p class="subtitulo">SERVICIOS</p>
          <div class="botones-container">
            <button v-if="unidades.length > 0"
            v-for="(servicio, index) in unidades"
              :key="index"
              class="boton-naranja"
              @click="seleccionarServicio(servicio)"
              :class="{ 'seleccionado': encuesta.unidad === servicio }"
            >
              {{ servicio.name }}
            </button>
            <button v-else class="boton-naranja">Seleccione un Campus/Sede</button>
          </div>
        </div>
        <!-- Tercer grupo -->
        <div class="col-md-4 " v-show="group === 3">
          <p class="subtitulo">SUBSERVICIOS</p>
          <div class="botones-container">
            <button  v-if="subunidades.length > 0"
              v-for="(subservicio, index) in subunidades"
              :key="index"
              class="boton-naranja"
              @click="seleccionarSubservicio(subservicio)"
              :class="{ 'seleccionado': encuesta.subunidad === subservicio }"
            >
              {{ subservicio.name }}
            </button>
            <button v-else class="boton-naranja">Seleccione un Servicio</button>
          </div>
        </div>
        <button v-if="group != 1" class="boton-azul2" @click="group = group - 1">Volver</button>
      </div>
      <div class="row" v-else>
        <!-- Primer grupo -->
        <div class="col-md-4">
          <h2 class="subtitulo">Campus/Sede</h2>
          <div class="botones-container">
            <button v-if="sedes"
              v-for="sede in sedes"
              :key="sede"
              class="boton-naranja"
              @click="seleccionarSede(sede)"
              :class="{ 'seleccionado': encuesta.campus === sede }"
            >
              {{ sede.sede }}
            </button>
          </div>
        </div>
        <!-- Segundo grupo -->
        <div class="col-md-4">
          <h2 class="subtitulo">Servicios</h2>
          <div class="botones-container">
            <button v-if="unidades.length > 0"
            v-for="(servicio, index) in unidades"
              :key="index"
              class="boton-naranja"
              @click="seleccionarServicio(servicio)"
              :class="{ 'seleccionado': encuesta.unidad === servicio }"
            >
              {{ servicio.name }}
            </button>
            <button v-else class="boton-naranja">Seleccione un Campus/Sede</button>
          </div>
        </div>
        <!-- Tercer grupo -->
        <div class="col-md-4 ">
          <h2 class="subtitulo">Subservicios</h2>
          <div class="botones-container">
            <button  v-if="subunidades.length > 0"
              v-for="(subservicio, index) in subunidades"
              :key="index"
              class="boton-naranja"
              @click="seleccionarSubservicio(subservicio)"
              :class="{ 'seleccionado': encuesta.subunidad === subservicio }"
            >
              {{ subservicio.name }}
            </button>
            <button v-else class="boton-naranja">Seleccione un Servicio</button>
          </div>
        </div>
      </div>
    <br>
    </div>
    <div class="modal" v-if="showModal" >
      <div class="modal-contenido">
        <div class="modal-cuerpo">
          <div class="row">
            <h2 class="subtitulo2 pt-4">¿Cómo evalúas tu experiencia?</h2>
            <div class="boton-estrella-container">
              <div
                class="boton-estrella"
                v-for="i in 5"
                :key="i"
                @mouseover="hoverStar(i)"
                @mouseleave="leaveStar(i)"
              >
                <button
                  class="boton-icono"
                  @click="onClick(i)"
                  :class="{ 'seleccionado': i <= valorSeleccionado, 'hover': i === estrellaHover }"
                >
                  <i class="fas fa-star"></i> <!-- Icono de Font Awesome -->
                  <span class="numero">{{ i }}</span> <!-- Número dentro del botón -->
                  <!-- Opcional: Texto para accesibilidad -->
                  <span class="sr-only">Seleccionar</span>
                </button>
              </div>
            </div>
            <div class="contenedor-centralizado pt-4">
              <button class="boton-azul" @click="showModal = false">Volver</button>
              &nbsp;
              <button class="boton-azul float-end" @click="handleClick2">Enviar Feedback</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="modal" v-if="pantallaGracias" >
      <div class="modal-contenido2">
        <div class="modal-cuerpo">
          <div class="row">
            <div class="contenedor-centralizado pt-5">
              <img src="https://cdn-icons-png.flaticon.com/512/8279/8279756.png" alt="Imagen del círculo" style="width: 200px;">
            </div>
            <p class="subtitulo2">¡Muchas Gracias! <br>Eres parte importante del cambio</p>
            <div class="contenedor-centralizado">
              <button class="boton-azul" @click="startAgain()">Evaluar otro servicio</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="modal" v-if="encuestaLarga" >
      <div class="modal-contenido3">
        <div class="modal-cuerpo">
          <div class="row">
            <div class="col-md-12 ">
              <h2 class="subtitulo2">¿Cómo evalúas tu experiencia?</h2>
              <div class="contenedor-centralizado">
                <div v-for="pregunta in preguntas" :key="pregunta.id">
                  <div v-if="pregunta.tipo === 'Opciones'">
                    <h4>{{ pregunta.pregunta }}</h4>
                    <div class="form-check" v-for="opcion in pregunta.opciones" :key="opcion.id">
                      <input class="form-check-input" type="checkbox" :id="'opcion_' + opcion.id" v-model="opcion.seleccionado" @change="limitarSeleccion">
                      <label class="form-check-label" :for="'opcion_' + opcion.id">{{ opcion.opcion }}</label>
                    </div>
                    <br>
                  </div>
                  <div v-else-if="pregunta.tipo === 'Texto'">
                    <div class="form-group">
                      <label :for="'texto_' + pregunta.id">{{ pregunta.pregunta }}</label>
                      <textarea class="form-control" :id="'texto_' + pregunta.id" rows="3"></textarea>
                    </div>
                    <br>
                  </div>
                </div>
                
                <div class="contenedor-centralizado">
                  <button class="boton-azul2" @click="showModal = true,encuestaLarga = false">Volver</button>
                  &nbsp;
                  <button class="boton-azul2 float-end" @click="handleClick2">Enviar</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import axios from 'axios'

  import {mixin} from '../mixins.js'
  
  export default {
    mixins: [mixin],
    data: () => ({
      encuesta: {
        campus: '',
        unidad: '',
        subunidad: '',
      },
      isMobile: false,
      group: 1,
      errors: [],
      sedes: [],
      unidades: [],
      subunidades: [],
      token: '',
      tokenAdmin: '',
      encuestaLarga: false,
      siguientePaso: false,
      pantallaGracias: false,
      valorSeleccionado: 0, 
      estrellaHover: null,
      showModal: false,
      preguntas: [],
    }),
    created(){
      //this.loginToken();
      this.loginAdmin();
      // Obtener la URL actual
      const url = window.location.href;
      
      // Extraer el ID de la URL
      const urlParts = url.split('/');
      this.id = urlParts[urlParts.length - 1];
      
      if(this.id != 'survey'){
        console.log('El ID es:', this.id);
        this.subunidad = this.id;
      }
      
    },
    mounted() {
      this.isMobile = window.innerWidth <= 576;
      window.addEventListener('resize', this.checkMobile);
      // Escuchar el evento keydown en el documento
      document.addEventListener('keydown', this.cerrarModalConEscape);
    },
    beforeDestroy() {
      window.removeEventListener('resize', this.checkMobile);
      // Eliminar el evento keydown del documento al destruir el componente
      document.removeEventListener('keydown', this.cerrarModalConEscape);
    },
    methods: {
        startAgain(){
          if(this.isMobile){
            this.group = 1;
          };
          this.valorSeleccionado = 0; 
          this.siguientePaso = false;
          this.pantallaGracias = false;
          this.encuestaLarga = false; 
          this.encuesta.campus = '';
          this.encuesta.unidad = ''; 
          this.encuesta.subunidad = '';
        },
        checkMobile() {
          this.isMobile = window.innerWidth <= 576;
        },
        cerrarModalConEscape(evento) {
          // Verificar si la tecla presionada es la tecla "Escape"
          if (evento.keyCode === 27) {
            // Lógica para cerrar el modal aquí
            this.showModal = false;
            this.pantallaGracias = false;
            this.encuestaLarga = false;
          }
        },
        onClick(valor) {
          // Función para manejar el clic en el botón
          this.valorSeleccionado = valor;
        },
        hoverStar(valor) {
          // Función para manejar el hover sobre la estrella
          this.estrellaHover = valor;
        },
        leaveStar() {
          // Función para manejar el hover fuera de la estrella
          this.estrellaHover = null;
        },
        seleccionarServicio(servicio) {
          this.encuesta.unidad = servicio;
          if(this.isMobile){
            this.group = 3;
          }
          if(this.encuesta.campus && this.encuesta.unidad && this.encuesta.subunidad){
            this.showModal = true;
          }
          this.getSubunidades(this.tokenAdmin);
        },
        seleccionarSubservicio(subservicio) {
          this.encuesta.subunidad = subservicio;
          if(this.encuesta.campus && this.encuesta.unidad && this.encuesta.subunidad){
            this.showModal = true;
          }
        },
        seleccionarSede(sede) {
          this.encuesta.campus = sede;
          if(this.isMobile){
            this.group = 2;
          }
          if(this.encuesta.campus && this.encuesta.unidad && this.encuesta.subunidad){
            this.showModal = true;
          }
          this.getUnidades(this.tokenAdmin);
        },
        limitarSeleccion() {
          // Limita la selección a un máximo de 2 checkboxes
          const opcionesSeleccionadas = this.preguntas[1].opciones.filter(opcion => opcion.seleccionado);
          if (opcionesSeleccionadas.length > 2) {
            // Desmarca la última opción seleccionada si se excede el límite
            opcionesSeleccionadas[opcionesSeleccionadas.length - 1].seleccionado = false;
          }
        },
        capitalizeFirstLetter(string) {
            return string.charAt(0).toUpperCase() + string.slice(1);
        },
        loginAdmin(){
          const credentials = {
            username: 'ADMIN',
            password: 'ac3e'
          };

          axios.post('https://evaluacionservicios.usm.cl/api/admin/login', null, {
            headers: {
              authorization: `Basic ${btoa(`${credentials.username}:${credentials.password}`)}`
            }
          })
            .then(response => {
              const token = response.data.token;
              console.log('Token recibido:', token);
              this.tokenAdmin = token;
              this.getSedes2(this.tokenAdmin);
              // Aquí puedes almacenar o utilizar el token según tus necesidades
            })
            .catch(error => {
              console.error('Error en la autenticación:', error);
            });

        },
        loginToken(){
          axios.post(`https://evaluacionservicios.usm.cl/api/encuesta/login`).then( response =>{
              this.token = response.data.token;
              //this.getSedes(this.token);
          }).catch(e=> console.log(e))
        },
        getSedes(token) {
          const tokenValue = token;
          // Configuración de los encabezados con el token
          const headers = {
            authorization: `${tokenValue}`
          };

          axios.get('https://evaluacionservicios.usm.cl/api/encuesta/consulta/sedes', {
            headers: headers
          }).then(response => {
            this.sedes = response.data;
          }).catch(error => {
            console.log(error);
          });
        },
        getSedes2(token) {
          const tokenValue = token;
          // Configuración de los encabezados con el token
          const headers = {
            authorization: `${tokenValue}`
          };

          axios.get('https://evaluacionservicios.usm.cl/api/admin/totem/agregar/sede', {
            headers: headers
          }).then(response => {
            this.sedes = response.data;
            console.log(this.sedes);
          }).catch(error => {
            console.log(error);
          });
        },
        getUnidades(token) {
          this.encuesta.unidad = '';
          const tokenValue = token;
          const headers = {
            authorization: `${tokenValue}`
          };

          const idSede = this.encuesta.campus ? this.encuesta.campus.id: null;
          if (idSede) {
            // Actualiza la URL con la id de la sede seleccionada
            const url = `https://evaluacionservicios.usm.cl/api/admin/totem/agregar/unidad/${idSede}`;

            axios.get(url, { headers })
              .then(response => {
                this.unidades = response.data.unidades;
                console.log(this.unidades);
              })
              .catch(error => {
                console.error(error);
              });
          }
        },
        getSubunidades(token) {
          this.encuesta.subunidad = '';
          const tokenValue = token;
          const headers = {
            authorization: `${tokenValue}`
          };

          const idUnidad = this.encuesta.unidad ? this.encuesta.unidad.id: null;
          if (idUnidad) {
            // Actualiza la URL con la id de la sede seleccionada
            const url = `https://evaluacionservicios.usm.cl/api/admin/totem/agregar/subunidad/${idUnidad}`;

            axios.get(url, { headers })
              .then(response => {
                console.log(response.data);
                this.subunidades = response.data.sub_unidades;
              })
              .catch(error => {
                console.error(error);
              });
          }
        },
        handleClick(){
            this.errors = []

            for (const item in this.encuesta){
              if(this.encuesta[item] === "" || this.encuesta[item] === 0){
                if(item == 'subunidad' && this.encuesta.unidad.subunidades == null){
                }else{
                  this.errors.push(item);
                }
              }
            }

            var mensaje = ""
            if (this.errors.length != 0){
              this.errors.forEach(item => {
                if(item == 'campus'){
                  mensaje =   mensaje + "El campo Campus/Sede es requerido" + "\n" 
                }else if(item == 'unidad'){
                  mensaje =   mensaje + "El campo Unidad o Servicio es requerido" + "\n" 
                }else{
                  mensaje =   mensaje + "El campo " + this.capitalizeFirstLetter(item) + " es requerido" + "\n" 
                }
              });
              this.toast.warning( mensaje, {
                position: "top-right",
                timeout: 5000,
                closeOnClick: true,
                pauseOnFocusLoss: true,
                pauseOnHover: true,
                draggable: true,
                draggablePercent: 0.6,
                showCloseButtonOnHover: false,
                hideProgressBar: true,
                closeButton: "button",
                icon: true,
                rtl: false
              });
            }
            if(this.errors.length === 0){
              this.siguientePaso = true;
            }
        },
        handleClick2(){
          this.showModal = false;
          if(this.valorSeleccionado < 5){
            this.longSurvey(this.tokenAdmin);
            this.encuestaLarga = true;
          }else{
            this.respuestaCorta(this.token);
            this.pantallaGracias = true;
          }
        },
        respuestaCorta(token){
           const tokenValue = token;
           const headers = {
             authorization: `${tokenValue}`
           };

            axios.post('https://evaluacionservicios.usm.cl/api/encuesta/respuesta', {
              totem: 1,
              subunidad: 1,
              respuesta: 'aaaaa'
            }, {
              headers: {
                Authorization: 'Bearer ' + token
              }
            })
            .then(response => {
              console.log(response);
            })
            .catch(error => {
              console.error(error);
            });
        },
        longSurvey(token){
          // this.preguntas.forEach(pregunta => {
          //   if (pregunta.tipo === 'Opciones') {
          //     pregunta.opciones.forEach(opcion => {
          //       opcion.seleccionado = false;
          //     });
          //   } else if (pregunta.tipo === 'Texto') {
          //     // Limpia el campo de texto
          //     pregunta.respuestaTexto = ''; // Asegúrate de tener respuestaTexto en tus datos
          //   }
          // });
           const tokenValue = token;
           const headers = {
             authorization: `${tokenValue}`
           };
  
           const idSubUnidad = this.encuesta.subunidad ? this.encuesta.subunidad.id: null;
           if (idSubUnidad){
             const url = `https://evaluacionservicios.usm.cl/api/encuesta/larga/consulta/${idSubUnidad}`;
  
             axios.get(url, { headers })
               .then(response => {
                 this.preguntas = response.data;
                 console.log(response);
               })
               .catch(error => {
                 console.error(error);
               });
           }
        },
    },
  };
  </script>
  
  <style scoped>
      .textarea-container {
        width: 100%;
        margin-bottom: 20px;
      }

      .textarea {
        width: 100%;
        min-height: 100px;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 20px;
        font-size: 16px;
        resize: none; /* Permite redimensionar verticalmente el textarea */
        box-sizing: border-box; /* El tamaño incluye el borde y el padding */
      }

      .boton-estrella-container {
        display: flex; /* Mostrar los botones en una fila */
        justify-content: center; /* Centrar horizontalmente los botones */
      }

      .boton-estrella {
        margin-right: 10px; /* Espacio entre los botones */
      }

      .boton-icono {
        position: relative;
        background-color: transparent;
        border: none;
        padding: 0;
        font-size: 0;
        cursor: pointer;
      }

      .boton-icono .numero {
        position: absolute;
        top: 55%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 24px;
        font-weight: bold;
        color: #fff;
      }

      /* Estilos para el icono */
      .boton-icono i {
        font-size: 50px;
        color: #ccc; /* Color gris para las estrellas */
      }

      /* Estilo para cuando se posiciona el ratón */
      .boton-icono.hover i, .boton-icono.hover~.boton-icono i {
        color: #F4C06A; /* Color naranja para las estrellas cuando se pasa el ratón */
      }

      /* Estilo para las estrellas seleccionadas */
      .boton-icono.seleccionado i, .boton-icono.seleccionado~.boton-icono i {
        color: #F4C06A; /* Color naranja para las estrellas seleccionadas */
      }

      /* Estilos opcionales para accesibilidad */
      .sr-only {
        position: absolute;
        width: 1px;
        height: 1px;
        padding: 0;
        margin: -1px;
        overflow: hidden;
        clip: rect(0, 0, 0, 0);
        border: 0;
      }
      /* Estilos generales para el form-select */
      .form-select {
        width: 300px;
        font-size: 1rem; /* Tamaño de la fuente por defecto */
        padding: .375rem .75rem; /* Padding por defecto */
    }

    /* Media query para pantallas grandes (mayor a 992px) */
    @media (min-width: 992px) {
      .form-select {
        width: 500px;
        font-size: 1.5rem; /* Tamaño de la fuente más grande para pantallas grandes */
        padding: .5rem 1rem; /* Aumenta el padding para hacer el form-select más grande en pantallas grandes */
      }
    }
    .btn-scale {
      text-align: center;
      font-weight: bold;
      color: black;
      font-family: 'Lato', sans-serif;
      margin-top: 40px;
      margin-bottom: 100px;
      margin-right: 5px;
    }

    /* Estilos para pantalla web */
    @media (min-width: 768px) {
      .btn-scale {
        font-size: 30px;
        min-width: 180px; /* Ajusta según sea necesario para pantallas web */
        padding: 40px 20px; /* Ajusta según sea necesario para pantallas web */
      }
    }

      /* Estilos para dispositivos móviles */
      @media (max-width: 767px) {
        .btn-scale {
          min-width: 30px; /* Ajusta según sea necesario para dispositivos móviles */
          padding: 5px 12px; /* Ajusta según sea necesario para dispositivos móviles */
        }
    }

    .titulo {
      text-align: center;
      font-weight: bold;
      font-size: 40px;
      color: #24006A;
      padding-bottom: 40px;
    }
    
    .subtitulo {
      padding-top: 20px;
      padding-bottom: 10px;
      text-align: center;
      font-size: 22px;
      font-weight: bolder;
      color: #24006A;
      font-family: 'Montserrat', sans-serif;
    }

    .subtitulo2 {
      padding-bottom: 10px;
      text-align: center;
      font-size: 20px;
      font-weight: bolder;
      color: #24006A;
      font-family: 'Montserrat', sans-serif;
    }

    
    /* Media query para pantallas más pequeñas (menor o igual a 576px) */
    @media (max-width: 576px) {
      .titulo {
        font-size: 30px; /* Tamaño de fuente más pequeño para pantallas pequeñas */
      }

      .subtitulo {
        font-size: 20px; /* Tamaño de fuente más pequeño para pantallas pequeñas */
      }
    }
    
    .contenedor-centralizado {
      display: flex;
      justify-content: center;
      align-items: center;
      flex-wrap: wrap;
    }
    
    .selector {
      margin: 20px;
      margin-bottom: 30px;
    }

    .boton-naranja {
      font-family: 'Montserrat', sans-serif;
      font-weight: lighter;
      background-color: #fff; /* Fondo blanco */
      color: #000; /* Texto negro */
      min-width: 100%;
      min-height: 100px;
      text-align: center;
      text-decoration: none;
      display: inline-block;
      font-size: 20px;
      cursor: pointer;
      border-radius: 20px; /* Bordes redondeados */
      margin-bottom: 20px;
      border: none; /* Quita el borde */
    }

    .boton-naranja:hover{
      background-color: #F4C06A; /* Fondo naranja al pasar el mouse o enfocar */
      color: #fff; /* Texto blanco */
    }

    .boton-naranja.seleccionado {
      background-color: #F4C06A; /* Estilo para el botón seleccionado */
      color: #fff; /* Texto blanco */
    }
    

    .botones-container {
      max-height: 600px; /* Altura máxima del contenedor */
      padding-right: 10px;
      padding-left: 10px;
      overflow-y: auto; /* Agrega desplazamiento vertical cuando los botones exceden la altura máxima */
    }



      /* Estilo para hacer la barra de desplazamiento más pequeña */
      .botones-container::-webkit-scrollbar {
          width: 5px; /* Ancho de la barra de desplazamiento */
      }

      /* Estilo para el riel de la barra de desplazamiento */
      .botones-container::-webkit-scrollbar-track {
          background-color: #f1f1f1; /* Color de fondo del riel de la barra de desplazamiento */
      }

      /* Estilo para el pulgar de la barra de desplazamiento */
      .botones-container::-webkit-scrollbar-thumb {
          background-color: #888; /* Color del pulgar de la barra de desplazamiento */
          border-radius: 5px; /* Borde redondeado del pulgar */
      }

    .boton-azul {
      font-family: 'Montserrat', sans-serif;
      font-weight: bold;
      background-color: #495A66; /* Color azul */
      color: #fff; /* Texto blanco */
      border: none;
      padding: 10px 40px; /* Ajusta el relleno según sea necesario */
      text-align: center;
      text-decoration: none;
      display: inline-block;
      font-size: 16px;
      cursor: pointer;
      border-radius: 20px; /* Bordes redondeados */
      }

      .boton-azul2 {
        font-family: 'Montserrat', sans-serif;
        font-weight: bold;
        background-color: #005D8E; /* Color azul */
        color: #fff; /* Texto blanco */
        border: none;
        padding: 10px 30px; /* Ajusta el relleno según sea necesario */
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        cursor: pointer;
        border-radius: 10px; /* Bordes redondeados */
      }

      /* MODAAAAL */

      .modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        display: flex;
        justify-content: center;
        align-items: center;
      }

      .modal-contenido {
        background-color: #fff;
        border-radius: 90px;
        padding: 20px;
        width: 600px;
        height: 300px;
      }

      .modal-contenido2 {
        background-color: #fff;
        border-radius: 90px;
        padding: 20px;
        width: 500px;
        height: 450px;
      }

      .modal-contenido3 {
        background-color: #fff;
        border-radius: 90px;
        overflow-y: auto;
        padding: 40px;
        width: 500px;
        max-height: 80vh;
      }

      /* Estilo para ocultar la barra de desplazamiento pero aún permitir el desplazamiento */
      .modal-contenido3::-webkit-scrollbar {
          display: none; /* Oculta la barra de desplazamiento en navegadores webkit */
      }

      /* Estilo para hacer la barra de desplazamiento más pequeña */
      .modal-contenido3::-webkit-scrollbar {
          width: 5px; /* Ancho de la barra de desplazamiento */
      }

      /* Estilo para el riel de la barra de desplazamiento */
      .modal-contenido3::-webkit-scrollbar-track {
          background-color: #f1f1f1; /* Color de fondo del riel de la barra de desplazamiento */
      }

      /* Estilo para el pulgar de la barra de desplazamiento */
      .modal-contenido3::-webkit-scrollbar-thumb {
          background-color: #888; /* Color del pulgar de la barra de desplazamiento */
          border-radius: 5px; /* Borde redondeado del pulgar */
      }
      
      .imagen-circulo {
        position: absolute; /* Posicionar la imagen sobre el header */
        top: 30%; /* Ajustar la posición para que sobresalga por arriba */
        left: 50%; /* Centrar horizontalmente */
        transform: translateX(-50%); /* Centrar horizontalmente */
      }

      .imagen-circulo2 {
        position: absolute; /* Posicionar la imagen sobre el header */
        top: 30%; /* Ajustar la posición para que sobresalga por arriba */
        left: 50%; /* Centrar horizontalmente */
        transform: translateX(-50%); /* Centrar horizontalmente */
      }

      .imagen-circulo img {
        border-radius: 50%;
        width: 110px;
        background-color: #fff;
        height: 110px;
      }
  </style>
  