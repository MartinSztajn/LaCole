<template>
    <cliente-layout>
        <div class="altura" style="background-color: #121212;"></div>

        <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img v-if="fotosBanner[num]" class="d-block w-100"  :src="'/fotos/' + fotosBanner[num].path" style="width: 100%" alt="First slide">
                </div>
            </div>
            <a class="carousel-control-prev" @click="moverIzq()" role="button" data-slide="prev">
                <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="black" class="bi bi-arrow-left-circle-fill" viewBox="0 0 16 16">
                    <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0zm3.5 7.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z"/>
                </svg>
            </a>
            <a class="carousel-control-next" @click="moverDer()" role="button" data-slide="next">
                <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="black" class="bi bi-arrow-right-circle-fill" viewBox="0 0 16 16">
                    <path d="M8 0a8 8 0 1 1 0 16A8 8 0 0 1 8 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z"/>
                </svg>
            </a>
        </div>

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
                                <th scope="col" v-if="admin">Cliente</th>
                                <th scope="col" v-if="admin">Mail</th>
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



    <Footer></Footer>
    </cliente-layout>
</template>


<script>
import ClienteLayout from '@/Layouts/ClienteLayout.vue'
import Footer from '@/Layouts/Footer.vue'

export default {
    name: "verOfertasDueno",
    props: ['producto','ofertas','categorias','fotosBanner'],
    components: {
        ClienteLayout,
        Footer
    },
    data()
    {
        return{
            listo: 0,
            num: 0,
            id:'',
            form:{
                nombre:'',
                id_usuarios:[],
            }
        }
    },
    methods:
        {
            verNegocioDetalle($id){
                this.$inertia.get('/verNegocioDetalle/' + $id);
            },
            moverIzq(){
                if (this.num == 0){
                    this.num = this.fotosBanner.length - 1;
                }
                else{
                    this.num = this.num - 1;
                }
            },
            moverDer(){
                this.num =  (this.num+1) % this.fotosBanner.length;
            },
            aceptarOferta($id){
                this.$inertia.post('/aceptarOferta/' + $id);
            },
            rechazarOferta($id){
                this.$inertia.post('/rechazarOferta/' + $id);
            }
        },
    mounted() {
        setInterval(this.moverDer, 5000); // Change image every 2 seconds
    }
}
</script>
<style>
@media (max-width: 500px) {
    .celular{
        display: none;
    }
    .filtros {
        background-color: #17428A;
        margin-top: -1px;
        padding-left: 12%;
        padding-top: 2%;
        padding-bottom: 2%;
        height: 55px;
        top: 80px;
    }
    .compu{
        display: none;
    }
    .altura{
        height: 63px;
    }
}
@media (min-width: 501px) {
    .filtros{
        background-color: #17428A;
        margin-top: -1px;
        padding-bottom: 1%;
        height: 40px;
        top: 79px;
    }
    .compu{
        display: flex;
        flex-wrap: nowrap;
        justify-content: center;
    }
    .altura{
        height: 118px;
    }
}

</style>
