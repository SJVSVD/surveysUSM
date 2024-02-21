<!-- MyComponent.vue -->
<template>
    <div v-if="siguientePaso == false && pantallaGracias == false && encuestaLarga == false"> 
      <h3 class="titulo">Encuesta de evaluación de la calidad de los servicios</h3>
      <p class="subtitulo">Seleccione el emplazamiento y unidad o servicio a evaluar para comenzar</p>
      <div class="contenedor-centralizado">
        <div class="selector">
          <label style="font-weight: bold; font-size: 20px;" for="campus">Campus/Sede: </label>
          <br>
          <select class="form-select" v-model="encuesta.campus" id="campus" @change="getUnidades()">
            <option disabled value="">Seleccione una opción</option>
            <option v-for="sede in sedes" v-bind:key="sede.id" v-bind:value="sede">
                {{ sede.sede }}
            </option>
          </select>
        </div>
        <div class="selector">
          <label style="font-weight: bold; font-size: 20px;" for="unidad">Unidad o Servicio: </label>
          <br>
          <select class="form-select" v-model="encuesta.unidad" id="unidad" @change="getSubunidades()">
            <option disabled value="">Seleccione una opción</option>
            <option v-for="unidad in unidades.unidades" v-bind:key="unidad.id" v-bind:value="unidad">
                {{ unidad.name }}
            </option>
          </select>
        </div>
        <div v-if="encuesta.unidad.subunidades" class="selector">
          <label style="font-weight: bold; font-size: 20px;" for="subunidad">Subunidad: </label>
          <br>
          <select class="form-select" v-model="encuesta.subunidad" id="subunidad">
            <option disabled value="">Seleccione una opción</option>
            <option v-for="subunidad in subunidades.subunidades" v-bind:key="subunidad.id" v-bind:value="subunidad.id">
                {{ subunidad.name }}
            </option>
          </select>
        </div>
    </div>
    <button class="boton-azul float-end" @click="handleClick">Comenzar</button>
    <br>
    </div>
    <div v-else-if="siguientePaso == true"> 
      <h3 class="titulo">Encuesta de evaluación de la calidad de los servicios</h3>
      <p class="subtitulo">Califique la unidad o servicio seleccionado</p>
      <div class="contenedor-centralizado">
        <div class="row">
          <div class="contenedor-centralizado d-flex flex-column">
            <div class="chart-scale">
              <button class="btn btn-scale btn-scale-desc-1" @click="longSurvey">1</button>
              <button class="btn btn-scale btn-scale-desc-2" @click="longSurvey">2</button>
              <button class="btn btn-scale btn-scale-desc-3" @click="longSurvey">3</button>
              <button class="btn btn-scale btn-scale-desc-4" @click="longSurvey">4</button>
              <button class="btn btn-scale btn-scale-desc-5" @click="handleClick2">5</button>
              <button class="btn btn-scale btn-scale-desc-6" @click="handleClick2">6</button>
              <button class="btn btn-scale btn-scale-desc-7" @click="handleClick2">7</button>
            </div>
          </div>
        </div>
    </div>
    <button class="boton-azul2" @click="siguientePaso = false">Volver</button>
    <br>
    </div>
    <div v-else-if="pantallaGracias == true"> 
      <h3 class="titulo">Encuesta de evaluación de la calidad de los servicios</h3>
      <p class="subtitulo">
      ¡Gracias por tu valiosa opinión!
      Si deseas evaluar otro servicio, simplemente haz clic en el botón a continuación.</p>
      <div class="contenedor-centralizado">
        <button class="boton-azul2" @click="siguientePaso = false, pantallaGracias = false, encuestaLarga = false, encuesta.campus = '', encuesta.unidad = ''">Evaluar otro servicio</button>
      </div>
    <br>
    </div>
    <div v-else-if="encuestaLarga == true"> 
      <h3 class="titulo">Encuesta de evaluación de la calidad de los servicios </h3>
      <br>
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
      </div>
      <button class="boton-azul2" @click="siguientePaso = true,encuestaLarga = false">Volver</button>
      <button class="boton-azul float-end" @click="handleClick2">Enviar</button>
    <br>
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
      errors: [],
      sedes: [],
      unidades: [],
      subunidades: [],
      token: '',
      tokenAdmin: '',
      encuestaLarga: false,
      siguientePaso: false,
      pantallaGracias: false,

      preguntas: [
        {
          "grupo": "Negativa",
          "id": 44,
          "opciones": [
            {"id": 231, "opcion": "Horario atención ", "pregunta": null, "pregunta_id": 44, "query": null, "query_class": null, "registry": null},
            {"id": 232, "opcion": "Instalaciones", "pregunta": null, "pregunta_id": 44, "query": null, "query_class": null, "registry": null},
            {"id": 233, "opcion": "Atención del personal", "pregunta": null, "pregunta_id": 44, "query": null, "query_class": null, "registry": null},
            {"id": 234, "opcion": "Mantenimiento aparatos/equipos ", "pregunta": null, "pregunta_id": 44, "query": null, "query_class": null, "registry": null},
            {"id": 235, "opcion": "Camerinos", "pregunta": null, "pregunta_id": 44, "query": null, "query_class": null, "registry": null},
            {"id": 236, "opcion": "Disponibilidad de lockers", "pregunta": null, "pregunta_id": 44, "query": null, "query_class": null, "registry": null},
            {"id": 237, "opcion": "Limpieza e higiene en general", "pregunta": null, "pregunta_id": 44, "query": null, "query_class": null, "registry": null},
            {"id": 239, "opcion": "Disponibilidad alcohol gel", "pregunta": null, "pregunta_id": 44, "query": null, "query_class": null, "registry": null}
          ],
          "orden": 1,
          "pregunta": "Su calificación se debió principalmente a:  ",
          "tipo": "Opciones"
        },
        {
          "grupo": "Negativa",
          "id": 15,
          "opciones": [],
          "orden": 2,
          "pregunta": "Si lo deseas, puedes dejarnos tu comentario o indicar en qué podemos mejorar",
          "tipo": "Texto"
        },
      ]
    }),
    created(){
      this.loginToken();
      this.loginAdmin();
      // Obtener la URL actual
      const url = window.location.href;
      
      // Extraer el ID de la URL
      const urlParts = url.split('/');
      this.id = urlParts[urlParts.length - 1];
      
      if(this.id != 'survey'){
        console.log('El ID es:', this.id);
        this.siguientePaso = true;
        this.subunidad = this.id;
      }
      
    },
    methods: {
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

          axios.post('http://ec2-18-191-1-205.us-east-2.compute.amazonaws.com/api/admin/login', null, {
            headers: {
              authorization: `Basic ${btoa(`${credentials.username}:${credentials.password}`)}`
            }
          })
            .then(response => {
              const token = response.data.token;
              console.log('Token recibido:', token);
              this.tokenAdmin = token;
              // Aquí puedes almacenar o utilizar el token según tus necesidades
            })
            .catch(error => {
              console.error('Error en la autenticación:', error);
            });

        },
        loginToken(){
          axios.post(`http://ec2-18-191-1-205.us-east-2.compute.amazonaws.com/api/encuesta/login`).then( response =>{
              this.token = response.data;
              console.log(response.data);
              this.getSedes();
              //this.getUnidades()
          }).catch(e=> console.log(e))
        },
        getSedes() {
          const tokenValue = this.token.token;
          // Configuración de los encabezados con el token
          const headers = {
            authorization: `${tokenValue}`
          };

          axios.get('http://ec2-18-191-1-205.us-east-2.compute.amazonaws.com/api/encuesta/consulta/sedes', {
            headers: headers
          }).then(response => {
            this.sedes = response.data;
            console.log(response);
          }).catch(error => {
            console.log(error);
          });
        },
        getUnidades() {
          this.encuesta.unidad = '';
          const tokenValue = this.token.token;
          const headers = {
            authorization: `${tokenValue}`
          };

          const idSede = this.encuesta.campus ? this.encuesta.campus.id: null;
          if (idSede) {
            // Actualiza la URL con la id de la sede seleccionada
            const url = `http://ec2-18-191-1-205.us-east-2.compute.amazonaws.com/api/encuesta/consulta/unidades/${idSede}`;

            axios.get(url, { headers })
              .then(response => {
                this.unidades = response.data;
                console.log(response);
              })
              .catch(error => {
                console.error(error);
              });
          }
        },
        getSubunidades() {
          if(this.encuesta.unidad.subunidades){
            this.encuesta.subunidad = '';
            const tokenValue = this.token.token;
            const headers = {
              authorization: `${tokenValue}`
            };
  
            const idUnidad = this.encuesta.unidad ? this.encuesta.unidad.id: null;
            if (idUnidad) {
              // Actualiza la URL con la id de la sede seleccionada
              const url = `http://ec2-18-191-1-205.us-east-2.compute.amazonaws.com/api/encuesta/consulta/subunidades/${idUnidad}`;
  
              axios.get(url, { headers })
                .then(response => {
                  this.subunidades = response.data;
                  console.log(response);
                })
                .catch(error => {
                  console.error(error);
                });
            }
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
          this.siguientePaso = false;
          this.pantallaGracias = true;
        },
        longSurvey(){
          this.siguientePaso = false;
          this.pantallaGracias = false;
          this.preguntas.forEach(pregunta => {
            if (pregunta.tipo === 'Opciones') {
              pregunta.opciones.forEach(opcion => {
                opcion.seleccionado = false;
              });
            } else if (pregunta.tipo === 'Texto') {
              // Limpia el campo de texto
              pregunta.respuestaTexto = ''; // Asegúrate de tener respuestaTexto en tus datos
            }
          });
          this.encuestaLarga = true;
          // const tokenValue = this.token.token;
          // const headers = {
          //   authorization: `${tokenValue}`
          // };
  
          // const idSubUnidad = this.encuesta.subunidad ? this.encuesta.subunidad.id: null;
          // if (idSubUnidad) {
          //   // Actualiza la URL con la id de la sede seleccionada
          //   const url = `http://ec2-18-191-1-205.us-east-2.compute.amazonaws.com/api/encuesta/larga/consulta/${idSubUnidad}`;
  
          //   axios.get(url, { headers })
          //     .then(response => {
          //       this.preguntas = response.data;
          //       console.log(response);
          //     })
          //     .catch(error => {
          //       console.error(error);
          //     });
          // }
        },
    },
  };
  </script>
  
  <style scoped>
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

    .btn-scale-desc-1 {
      background-color: #FF0000;
    }

    .btn-scale-desc-2 {
      background-color: #FF3300;
    }

    .btn-scale-desc-3 {
      background-color: #FF6600;
    }

    .btn-scale-desc-4 {
      background-color: #FF9900;
    }

    .btn-scale-desc-5 {
      background-color: #FFFF00;
    }

    .btn-scale-desc-6 {
      background-color: #CCFF00;
    }

    .btn-scale-desc-7 {
      background-color: #33FF00;
    }

    .btn-scale-desc-1:hover { background-color: #DE0000; }
    .btn-scale-desc-2:hover { background-color: #DE2C00; }
    .btn-scale-desc-3:hover { background-color: #DE5900; }
    .btn-scale-desc-4:hover { background-color: #DE8500; }
    .btn-scale-desc-5:hover { background-color: #DEB100; }
    .btn-scale-desc-6:hover { background-color: #DEDE00; }
    .btn-scale-desc-7:hover { background-color: #2CDE00; }
    .titulo {
      text-align: center;
      font-weight: bold;
      font-size: 40px;
    }
    
    .subtitulo {
      padding-top: 20px;
      text-align: center;
      font-size: 30px;
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
    .boton-azul {
      font-family: 'Montserrat', sans-serif;
      font-weight: bold;
      background-color: #005D8E; /* Color azul */
      color: #fff; /* Texto blanco */
      border: none;
      padding: 10px 40px; /* Ajusta el relleno según sea necesario */
      text-align: center;
      text-decoration: none;
      display: inline-block;
      font-size: 16px;
      cursor: pointer;
      border-radius: 10px; /* Bordes redondeados */
      margin-bottom: 20px;
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
  </style>
  