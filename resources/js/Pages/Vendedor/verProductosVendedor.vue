<template>
    <cliente-layout>
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
                <svg v-if="admin == 1"
                     onclick="window.location.href='/login'"
                     style="float: right; margin-top: 3px"
                     xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="white" class="bi bi-person-fill" viewBox="0 0 16 16">
                    <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3Zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/>
                </svg>
            </div>


        <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <div v-if="fotosBanner && fotosBanner[num] " class="carousel-item active">
                    <a :href="'https://' + fotosBanner[num].url" target="_blank">
                        <img v-if="fotosBanner[num]" class="d-block w-100"  :src="'/fotos/' + fotosBanner[num].path" style="width: 100%" alt="First slide">
                    </a>
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



        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg" style="margin: 3%; padding: 50px;">
            <h1 style="font-size: 45px; text-align: center; position: center; margin-bottom: 3%; margin-top: -2%"><b>¡Mira los productos disponibles!</b></h1>
            <div class="card-deck" v-for="pro in productos">
                <div class="card">
                    <img  :src="'/fotos/' + pro.path" class="card-img-top" style="height: 300px;" alt="...">
                    <div class="card-footer">
                        <h1 style="text-align: center; font-size: 30px">{{pro.nombre}}</h1>
                    </div>
                    <div class="card-body">
                        <svg style="float: left; margin-right: 10px" xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-shop" viewBox="0 0 16 16">
                            <path d="M2.97 1.35A1 1 0 0 1 3.73 1h8.54a1 1 0 0 1 .76.35l2.609 3.044A1.5 1.5 0 0 1 16 5.37v.255a2.375 2.375 0 0 1-4.25 1.458A2.371 2.371 0 0 1 9.875 8 2.37 2.37 0 0 1 8 7.083 2.37 2.37 0 0 1 6.125 8a2.37 2.37 0 0 1-1.875-.917A2.375 2.375 0 0 1 0 5.625V5.37a1.5 1.5 0 0 1 .361-.976l2.61-3.045zm1.78 4.275a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 1 0 2.75 0V5.37a.5.5 0 0 0-.12-.325L12.27 2H3.73L1.12 5.045A.5.5 0 0 0 1 5.37v.255a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0zM1.5 8.5A.5.5 0 0 1 2 9v6h1v-5a1 1 0 0 1 1-1h3a1 1 0 0 1 1 1v5h6V9a.5.5 0 0 1 1 0v6h.5a.5.5 0 0 1 0 1H.5a.5.5 0 0 1 0-1H1V9a.5.5 0 0 1 .5-.5zM4 15h3v-5H4v5zm5-5a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1v-3zm3 0h-2v3h2v-3z"/>
                        </svg>
                        <p class="card-text" style="font-size: 20px"><b>Categoria:</b> {{pro.nomCat}}</p>
                        <svg style="float: left; margin-right: 10px" xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-calendar4-week" viewBox="0 0 16 16">
                            <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM2 2a1 1 0 0 0-1 1v1h14V3a1 1 0 0 0-1-1H2zm13 3H1v9a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V5z"/>
                            <path d="M11 7.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-2 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z"/>
                        </svg>
                        <p class="card-text" style="font-size: 20px"><b>Fecha:</b> {{pro.fecha_fin}}</p>
                        <svg style="float: left; margin-right: 10px" xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-square-fill" viewBox="0 0 16 16">
                            <path d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2z"/>
                        </svg>
                        <p class="card-text" style="font-size: 20px"><b>Cantidad:</b> {{pro.cantidad}}</p>
                    </div>
                    <div class="card-footer">
                        <div style="float: left; margin-top: 5px; margin-left: 10%">
                            <h1 style="text-align: center; font-size: 30px">${{pro.precio_max}}</h1>
                        </div>
                        <div style="float: right">
                            <button @click="verProductoDetalle(pro.nomCat, pro.nombre)" class="btn">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="black" class="bi bi-cart-plus-fill" viewBox="0 0 16 16">
                                    <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zM9 5.5V7h1.5a.5.5 0 0 1 0 1H9v1.5a.5.5 0 0 1-1 0V8H6.5a.5.5 0 0 1 0-1H8V5.5a.5.5 0 0 1 1 0z"/>
                                </svg>
                            </button>
                        </div>
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
    name: "verProductosNegocio",
    props: ['productos','categorias','fotosBanner'],
    components:{
        Footer,
        ClienteLayout
    },
    data()
    {
        return{
            hola:'',
            num: 0,
        }
    },
    methods:
        {
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
            verProductoDetalle($nomCat, $nombre){
                this.$inertia.get('/verProductoDetalle/' + $nomCat + '/' + $nombre);
            },
        },
    mounted() {

        this.timer = setInterval(() => {
            this.moverDer();
        }, 5000);
    },
}
</script>


<style scoped>
@media (max-width: 500px) {
    .celular{
        display: none;
    }
    .botones{
        float: left; margin: 2%; width: 45%; background-color: grey; color: white; font-size: 15px;
    }
    .compu{
        display: none;
    }
    .card{
        width: 100%;
        margin-right: 2%;
        margin-bottom: 5%;
    }
    .filtros{
        background-color: black;
        margin-top: -1px;
        padding-left: 12%;
        padding-top: 2%;
        padding-bottom: 2%;

    }
    .botonfiltros{
        width: 140px;
        font-size: 20px;
    }
    #carouselExampleControls{
        margin-top: 63px;
    }
}

@media (min-width: 501px) {
    #carouselExampleControls{
        margin-top: 118px;
    }
    .botones{
        float: left; margin-right: 3%; width: 20%; background-color: grey; color: white; font-size: 30px;
    }
    .card{
        width: 23%;
        margin-right: 2%;
        float: left;
        margin-bottom: 2%;
    }
    .filtros{
        background-color: black;
        margin-top: -1px;
        padding-left: 35%;
        padding-bottom: 1%;
    }
    .botonfiltros{
        width: 200px;
        font-size: 20px;
    }
}

</style>
