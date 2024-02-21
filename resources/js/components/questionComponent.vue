<!-- MyComponent.vue -->
<template>
    <div>
      <h3 class="titulo">Encuesta de evaluación de la calidad de los servicios</h3>
      <p class="subtitulo">Seleccione el emplazamiento y unidad o servicio a evaluar para comenzar</p>
      <div class="contenedor-centralizado">
        <div class="selector">
          <label style="font-weight: bold;" for="campus">Campus/Sede: </label>
          <br>
          <select class="form-select" v-model="encuesta.campus" id="campus">
            <option disabled value="">Seleccione una opción</option>
            <option value="Campus Casa Central Valparaiso">Campus Casa Central Valparaiso</option>
            <option value="Campus San Joaquin">Campus San Joaquin</option>
            <option value="Campus Vitacura">Campus Vitacura</option>
            <option value="Sede Viña del Mar">Sede Viña del Mar</option>
          </select>
        </div>
        <div class="selector">
          <label style="font-weight: bold;" for="unidad">Unidad o Servicio: </label>
          <br>
          <select class="form-select" v-model="encuesta.unidad" id="unidad">
            <option disabled value="">Seleccione una opción</option>
            <option value="Limpieza">Limpieza</option>
            <option value="Comida">Comida</option>
            <option value="Baños">Baños</option>
          </select>
        </div>
    </div>
    <button class="boton-azul float-end" @click="handleClick">Comenzar</button>
    <br>
    </div>
  </template>
  
  <script>
import {mixin} from '../mixins.js'
  export default {
    mixins: [mixin],
    data: () => ({
      encuesta: {
        campus: '',
        unidad: '',
      },
      siguientePaso: false,
      errors: [],
    }),
    methods: {
        handleClick(){
            this.errors = []

            for (const item in this.encuesta){
              if(this.encuesta[item] === "" || this.encuesta[item] === 0){
                  this.errors.push(item);
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
              this.toast.success( 'Si estan rellenados', {
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
              this.siguientePaso = true;
            }
        },
    },
  };
  </script>
  
  <style scoped>
  .titulo {
    text-align: center;
    font-weight: bold;
  }
  
  .subtitulo {
    padding-top: 20px;
    text-align: center;
    font-size: 25px;
    font-family: 'Montserrat', sans-serif;
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
  </style>
  