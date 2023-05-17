<template>
    <cliente-layout>
        <div class="filtros" style="text-align: center; width: 100%; position: fixed; z-index: 100">
            <div class="compu">
                <div v-for="cat in categorias">
                    <a v-if="cat.hijos == null"
                       :href="'/verProductosCategoria/' + cat.nombre" style="display: block; color: white; text-align: center; position: center; float: left; font-size: 20px; margin-right: 20px; margin-top: 4px">
                        {{cat.nombre}}
                    </a>
                    <a v-if="cat.hijos != null" style="display: block;color: white;text-align: center;float: left;font-size: 20px;margin-right: 20px;margin-top: 4px;padding: 0px;background-color: #17428A;border: none;" class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                        {{cat.nombre}}
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <li v-for="hijo in cat.hijos">
                            <a class="dropdown-item" :href="'/verProductosCategoria/' + hijo.nombre">{{hijo.nombre}}</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
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



        <footer style="background-color: #EF7728;" class="text-center text-white">
            <!-- Grid container -->
            <div class="container p-3">
                <!-- Section: Links -->
                <section class="">
                    <!--Grid row-->
                    <div class="row" style="margin-bottom: 1%">
                        <div class="col-lg-3 col-md-6 mb-3 mb-md-0">
                            <h1 style="font-size: 20px; color: black"><b>Metodos de Pago</b></h1>
                            <br>
                            <ul class="list-unstyled mb-0">
                                <li>
                                    <p class="text-white">Transferencia Bancaria</p>
                                </li>
                                <li>
                                    <p class="text-white">Mercado Pago</p>
                                </li>
                                <li>
                                    <p class="text-white">Efectivo</p>
                                </li>
                            </ul>
                        </div>
                        <div class="col-lg-2 col-md-6 mb-3 mb-md-0">
                            <h1 style="font-size: 20px; color: black"><b>Medios de envio</b></h1>
                            <br>
                            <ul class="list-unstyled mb-0">
                                <li>
                                    <p class="text-white">Correo Argentino</p>
                                </li>
                                <li>
                                    <p class="text-white">Andreani</p>
                                </li>
                                <li>
                                    <p class="text-white">Expresos</p>
                                </li>
                                <li>
                                    <p class="text-white">A Convenir</p>
                                </li>
                            </ul>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3 mb-md-0">
                            <h1 style="font-size: 20px; color: black"><b>Contacto</b></h1>
                            <br>
                            <ul class="list-unstyled mb-0">
                                <li style="margin-top: 5%;display: flex;justify-content: space-evenly;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-facebook" viewBox="0 0 16 16">
                                        <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z"/>
                                    </svg>
                                    <a href="https://www.instaram.com/wop.ok/">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-instagram" viewBox="0 0 16 16">
                                            <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z"/>
                                        </svg>
                                    </a>
                                    <a href="https://wa.me/5491128495155?text=Buenos%20dias!%20Me%20gustaria%20tener%20más%20informacion" target="_blank">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-telephone-fill" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z"/>
                                        </svg>
                                    </a>
                                    <a href="mailto:admin@wop.com.ar">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-envelope-fill" viewBox="0 0 16 16">
                                            <path d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414.05 3.555ZM0 4.697v7.104l5.803-3.558L0 4.697ZM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586l-1.239-.757Zm3.436-.586L16 11.801V4.697l-5.803 3.546Z"/>
                                        </svg>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-lg-4 col-md-6 mb-3 mb-md-0">
                            <a href="/enviarConsulta">
                                <div style="background-color: #17428A; color: white; padding: 15px 30px 15px 30px; border-radius: 15px; width: 80%; margin-left: 5%; margin-top: 20px">
                                    <h1 style="font-size: 20px;">Recibí atención personalizada ¡Dejanos tu mensaje!</h1>
                                </div>
                            </a>
                        </div>
                    </div>
                </section>
            </div>
            <div style="padding: 8px; background-color: black">
                © Copyright 2023 W.O.P - 1128495155
            </div>
            <!-- Grid container -->
            <!-- Copyright
            <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
                © 2020 Copyright:
                <a class="text-white" href="https://mdbootstrap.com/">MDBootstrap.com</a>
            </div>
           Copyright -->
        </footer>

    </cliente-layout>
</template>


<script>
import ClienteLayout from '@/Layouts/ClienteLayout.vue'
export default {
    name: "verOfertasDueno",
    props: ['producto','ofertas','categorias','fotosBanner'],
    components: {
        ClienteLayout,
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
    #carouselExampleControls{
        margin-top: 134px;
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
    #carouselExampleControls{
        margin-top: 118px;
    }
}

</style>
