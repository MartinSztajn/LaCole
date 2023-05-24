<template>
    <app-layout>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" >

                <h1 style="text-align: center; position: center; font-size: 45px">{{producto.nombre}}</h1>
                <h1 style="text-align: center; position: center; font-size: 25px">Precio: {{producto.precio_max}}</h1>
                <h1 style="text-align: center; position: center; font-size: 25px">Cantidad: {{producto.cantidad}}</h1>

                <h1 style="text-align: center; position: center; font-size: 25px">Fecha: {{producto.fecha_fin}}</h1>

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg" style="margin-bottom: 5%; margin-top: 5%">
                    <div>
                        <h1 style="margin: 20px; text-align: center; font-size: 20px">Ofertas Existentes</h1>
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th scope="col"></th>
                                <th scope="col">Precio</th>
                                <th scope="col">Cantidad</th>
                                <th scope="col" >Cliente</th>
                                <th scope="col">Mail</th>
                                <th scope="col">Aceptar</th>
                                <th scope="col">Rechazar</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(ofe, key) in ofertas"  :style="ofe.es_aceptado == 2  ? 'background-color: red' : ''">
                                <td>{{key + 1}}</td>
                                <td>{{ofe.precio}}</td>
                                <td>{{ofe.cantidad}}</td>
                                <td v-if="admin">{{ofe.nomCli}}</td>
                                <td v-if="admin">{{ofe.mailCli}}</td>
                                <td>
                                    <button v-if="ofe.es_aceptado == 0" @click="aceptarOferta(ofe.id)" class="btn btn-primary" style="background-color: red">No Aceptada</button>
                                    <button  v-if="ofe.es_aceptado == 1" class="btn btn-primary"  style="background-color: green">Aceptada</button>
                                </td>
                                <td>
                                    <button v-if="ofe.es_aceptado == 0" @click="rechazarOferta(ofe.id)" class="btn"  >
                                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="red" class="bi bi-x-square-fill" viewBox="0 0 16 16">
                                            <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm3.354 4.646L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 1 1 .708-.708z"/>
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

        </div>


    </app-layout>
</template>


<script>
import AppLayout from '@/Layouts/AppLayout.vue'
export default {
    name: "verOfertas",
    props: ['producto','ofertas','admin'],
    components: {
        AppLayout,
    },
    data()
    {
        return{
            listo: 0,
            form:{
            }
        }
    },
    methods:
        {
            aceptarOferta($id){
                this.$inertia.post('/aceptarOferta/' + $id);
            },
            rechazarOferta($id){
                this.$inertia.post('/rechazarOferta/' + $id);
            }
        }
}
</script>
