<template>
    <cliente-layout>
        <div class="altura" style="background-color: #121212;"></div>

        <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img v-if="fotosBanner[num]" class="d-block w-100"  :src="'/fotos/' + fotosBanner[num].path" style="width: 100%" alt="First slide">
                </div>
            </div>
            <a class="carousel-control-prev compu" @click="moverIzq()" role="button" data-slide="prev">
                <svg xmlns="http://www.w3.org/2000/svg"  width="50" height="50" fill="black" class="bi bi-arrow-left-square-fill" viewBox="0 0 16 16">
                    <path d="M16 14a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12zm-4.5-6.5H5.707l2.147-2.146a.5.5 0 1 0-.708-.708l-3 3a.5.5 0 0 0 0 .708l3 3a.5.5 0 0 0 .708-.708L5.707 8.5H11.5a.5.5 0 0 0 0-1z"/>
                </svg>
            </a>
            <a class="carousel-control-next compu" @click="moverDer()" role="button" data-slide="next">
                <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="black" class="bi bi-arrow-right-square-fill" viewBox="0 0 16 16">
                    <path d="M0 14a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2a2 2 0 0 0-2 2v12zm4.5-6.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5a.5.5 0 0 1 0-1z"/>
                </svg>
            </a>
        </div>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" >
                <h1 style="text-align: center; position: center; font-size: 45px">{{producto.nombre}}</h1>
                <h1 style="text-align: center; position: center; font-size: 25px">Precio: {{producto.precio}}</h1>

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg" style="margin-bottom: 5%; margin-top: 5%">
                    <div>
                        <h1 style="margin: 20px; text-align: center; font-size: 20px">Ofertas Existentes</h1>
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th scope="col"></th>
                                <th scope="col">Cliente</th>
                                <th scope="col">Celular</th>
                                <th scope="col">Mail</th>
                                <th scope="col">Eliminar</th>
                                <th scope="col">Contactar</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(ofe, key) in ofertas" >
                                <td>{{key + 1}}</td>
                                <td>{{ofe.nombre}} {{ofe.apellido}}</td>
                                <td>{{ofe.numero}}</td>
                                <td>{{ofe.email}}</td>
                                <td>
                                    <button v-if="ofe.estado == 0" @click="rechazarOferta(ofe.id)" class="btn" style="background-color: red" > Rechazar</button>
                                    <p  v-if="ofe.estado == 2" style="color: red">Rechazada</p>

                                </td>
                                <td>
                                    <a :href="'https://api.whatsapp.com/send?phone=54' + ofe.numero + '&text=%F0%9F%98%80%20Hola%20' + ofe.nombre + '%20' + ofe.apellido + '!%20Como%20estas%3F%0AMe%20comunico%20con%20vos%20porque%20vi%20que%20estas%20interesado%20en%20mi%20publicaci%C3%B3n%20' + producto.nombre + '%20de%20La%20Cole%20Market!'"  target="_blank">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-whatsapp" viewBox="0 0 16 16">
                                            <path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z"/>
                                        </svg>
                                    </a>
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
